<?php
namespace PbxAgi\Entity;

use Zend\Mime\Message as MimeMessage;

class IncomingMessage
{
	protected $msg;
	protected $mimemessage;
    public function create($msg)
    {
    	$this->msg = $msg;
    	$body = $msg->getBody();
    	 
    	$boundary = $msg->getHeaders()->get('ContentType')->getParameters()['boundary'];
    	$multipart = MimeMessage::createFromMessage($body,$boundary);
    	$this->mimemessage = $multipart; 
    	return $this;
    }

 public function getMsg() {
  return $this->msg;
 }
 
 public function setMsg($msg) {
  $this->msg = $msg;
  return $this;
 }
 
 public function getMimemessage() {
  return $this->mimemessage;
 }
 
 public function setMimemessage($mimemessage) {
  $this->mimemessage = $mimemessage;
  return $this;
 }
 
}