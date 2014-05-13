<?php
namespace Vpbxui\Restart\Model;

use Vpbxui\Service\Ami\AmiGateway;
use PAMI\Client\IClient;
use PAMI\Message\OutgoingMessage;
use PAMI\Listener\IEventListener;
use PAMI\Message\Event\EventMessage;
use PAMI\Message\Action\CommandAction;
use PAMI\Client\Exception\ClientException;


class RestartCommand {

    protected $amiGateway;
    public function __construct(IClient $amiGateway)
    {
    	$this->amiGateway = $amiGateway;
    }
    
    public function invokeHardRestartCommand()
    {
        try{
        $a = $this->amiGateway;
        $a->registerEventListener(new A());
	$a->open();
      
        
        $response = $a->send(new CommandAction('core restart now'));
                
              
       $a->close(); // send logoff and close the connection.

   } catch (ClientException $e) {
	echo $e->getMessage() . "\n";
}
 
    	return $result;
    }
    
    
}
class A implements IEventListener
{
    public function handle(EventMessage $event)
    {
     }
}