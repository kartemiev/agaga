<?php
namespace PbxAgi\Service\SendEmail;

class EmailMessage
{
    public $templatehtml;
    public $templateplain;
    public $layouthtml;
    public $layoutplain;
    public $attachments;    
    public $parameters;
    public $msgfromemail;
    public $msgfromfullname;
    public $msgto;
    public $msgsubject;    

    public function exchangeArray($data)
    {
    	$this->templatehtml = (isset($data['templatehtml'])) ? $data['templatehtml'] : null;
    	$this->templateplain = (isset($data['templateplain'])) ? $data['templateplain'] : null;
    	$this->layouthtml = (isset($data['layouthtml'])) ? $data['layouthtml'] : null;
    	$this->layoutplain = (isset($data['layoutplain'])) ? $data['layoutplain'] : null;
    	$this->attachments = (isset($data['attachments'])) ? $data['attachments'] : array();
    	$this->parameters = (isset($data['parameters'])) ? $data['parameters'] : array();
    	$this->msgfromemail = (isset($data['msgfromemail'])) ? $data['msgfromemail'] : null;
    	$this->msgfromfullname = (isset($data['msgfromfullname'])) ? $data['msgfromfullname'] : null;
    	$this->msgto = (isset($data['msgto'])) ? $data['msgto'] : null;
    	$this->msgsubject = (isset($data['msgsubject'])) ? $data['msgsubject'] : null;     	 
    }
}