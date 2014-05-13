<?php
namespace Vpbxui\Registry\Model;

use Vpbxui\Service\Ami\AmiGateway;
use PAMI\Client\IClient;
use PAMI\Message\OutgoingMessage;
use PAMI\Listener\IEventListener;
use PAMI\Message\Event\EventMessage;
use PAMI\Message\Action\SIPShowRegistryAction;
use PAMI\Client\Exception\ClientException;

class RegistryCommand {

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

        $result = $a->send(new SIPShowRegistryAction());
              
       $SIPShowRegistryActionEvents = $result->getEvents();
          $sipRegistryStatus = array();
        foreach ($SIPShowRegistryActionEvents as $status)
         {  
         	$keys = $status->getKeys();          
         	if ('RegistryEntry'==$keys['event'])
         	{
          	    $registry = new Registry();
         	    $registry->exchangeArray($keys);
         	    $sipRegistryStatus[]=$registry;         	    
         	}
            
         }          
       $a->close();
        return $sipRegistryStatus;
             
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