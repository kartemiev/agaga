<?php
namespace Vpbxui\Prune\Model;

use  PAMI\Client\IClient;
use PAMI\Listener\IEventListener;
use PAMI\Message\Event\EventMessage;
use PAMI\Message\Action\CommandAction;
use PAMI\Client\Exception\ClientException;

class PruneCommand {

    protected $amiGateway;
    public function __construct(IClient $amiGateway)
    {
    	$this->amiGateway = $amiGateway;
    }
    
    public function prunePeer($peerName)
    {
       try{
            $a = $this->amiGateway;
	        $a->open();       
            $response = $a->send(new CommandAction("sip prune realtime {$peerName}"));
            $a->Close();
        }  catch (ClientException $e){            
        }
        	return $response;
    }
}
class A implements IEventListener
{
    public function handle(EventMessage $event)
    {
     }
}