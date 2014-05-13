<?php
namespace Fax\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mail\Message as MailMessage;
use Zend\Mime\Message as MimeMessage;

class ParseFaxEmailController extends AbstractActionController
{
    public function indexAction()
    {
        $message ='';
        $stdin = fopen('php://stdin', 'r');
        
        while($line = fgets($stdin)) {
            $message .= $line;
        }        
        fclose($stdin);
        $msg = MailMessage::fromString($message);
        
        var_dump($msg);
        exit;
        
        $mime = MimeMessage::createFromMessage($msg->getBody());
        var_dump($mime);
    }
}