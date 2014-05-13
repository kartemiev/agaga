<?php
namespace Vpbxui\Reload\Model;

use PAMI\Client\IClient;
use PAMI\Listener\IEventListener;
use PAMI\Message\Event\EventMessage;
use PAMI\Message\Action\CommandAction;
use PAMI\Client\Exception\ClientException;

class ReloadCommand {

    protected $amiGateway;
    public function __construct(IClient $amiGateway)
    {
    	$this->amiGateway = $amiGateway;
    }
    
    public function sipReload()
    {
        try{
        $a = $this->amiGateway;
	$a->open();       
        $response = $a->send(new CommandAction("sip reload"));
        $a->Close();
       
        }  catch (ClientException $e){}
        	return $response;
    }
}
class A implements IEventListener
{
    public function handle(EventMessage $event)
    {
     }
}