<?php
namespace Vpbxui\Status\Model;

use Vpbxui\Status\Model\Status;
use Vpbxui\Service\Ami\AmiGateway;
use Zend\Db\Sql\Select;
use  PAMI\Client\IClient;
use PAMI\Message\OutgoingMessage;
use PAMI\Listener\IEventListener;
use PAMI\Message\Event\EventMessage;
use PAMI\Message\Action\SIPPeersAction;
use PAMI\Message\Action\SIPShowPeerAction;
use Zend\Stdlib\Hydrator\ClassMethods;
use PAMI\Message\Action\StatusAction;
use PAMI\Message\Action\GetVarAction;
use PAMI\Client\Exception\ClientException;


class StatusCommand {

    protected $amiGateway;
    protected $isError;
    protected $error;
    const AMI_ERROR_FAILED_TO_CONNECT = 1;
    public function __construct(IClient $amiGateway)
    {
    	$this->amiGateway = $amiGateway;
    }
    
    public function fetchAll()
    {
        $this->isError = false;
        try{
        $a = $this->amiGateway;
        $a->registerEventListener(new A());
	
        try {
            $a->open();
        } catch (ClientException $e)
        {
            $this->isError = true;
            $this->setError(self::AMI_ERROR_FAILED_TO_CONNECT);
             return;
        }
        $hydrator = new ClassMethods();         
 
        
        $response = $a->send(new StatusAction());
        
        $channelStatuses = array();
        $cStatuses = $response->getEvents();
         foreach ($cStatuses as $status)
        {
             $status = $hydrator->extract($status);
              if ('Status'==$status['name'])
              {
                $channelStatuses[] = $status;  
              }
        }
         
       $result = $a->send(new SIPPeersAction());
              
       $PeersActionEvents = $result->getEvents();
        
         $sipPeersStatus = array();
        foreach ($PeersActionEvents as $status)
         {            
             $status = $hydrator->extract($status);  
              if ('PeerEntry'==$status['name'])
              {
                  $result = $a->send(new SIPShowPeerAction($status['object_name']));
                  if ($result)
                      {
                      $PeerInfo = $hydrator->extract($result);  
                       $calls = array();
                      $peerName = $status['object_name'];
                       array_walk($channelStatuses,
                              function($status) use (&$calls,$peerName,$a, $hydrator)
                                {
                                    
                                    if (preg_match("/^SIP\/{$peerName}-[\w]{8}$/",$status['channel']))
                                    {
                                         
                                        $response = $a->send(new GetVarAction('RECORD_FILENAME', $status['channel']));
                                        if ($response)
                                        {
                                          $variable = $hydrator->extract($response);
                                          $status['record_filename'] = $variable['keys']['value'];
                                        }
                                         $calls[] = $status;
                                                
                                                
                                    }
                                }
                              );
                              $status['calls'] = $calls;
                         $sipPeersStatus[]=  array_merge($status,$PeerInfo['keys']);

                      }
              }
         }                  
       $a->close(); // send logoff and close the connection.
        return $sipPeersStatus;
             
 } catch (Exception $e) {
	echo $e->getMessage() . "\n";
}
 
    	return $result;
    }
	public function isError()
    {
        return $this->isError;
    }

	public function getError()
    {
        return $this->error;
    }

 	public function setError($error)
    {
        $this->error = $error;
    }

    
    
}
class A implements IEventListener
{
    public function handle(EventMessage $event)
    {
     }
}