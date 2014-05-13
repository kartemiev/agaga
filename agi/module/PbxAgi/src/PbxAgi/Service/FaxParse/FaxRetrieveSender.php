<?php
namespace PbxAgi\Service\FaxParse;

class FaxRetrieveSender
{
    protected $emailFrom;
    public function getSender($incomingMessage)
    {
        if (!isset($this->emailFrom))
        {
            $msg = $incomingMessage->getMsg();
            $from = null;
            foreach ($msg->getHeaders() as $plugin)
            {
        		if ($plugin instanceof \Zend\Mail\Header\From)
        			{
        				$from = $plugin;
        			}
        	}
            $addressList = $from->getAddressList();
            $address = $addressList->current();
            $this->emailFrom = $address->getEmail();        		         
       }
       return $this->emailFrom;
    }
}