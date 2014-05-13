<?php
namespace PbxAgi\Service\FaxParse;

use Zend\Validator\AbstractValidator;

class FaxAttachmentPresentValidator extends AbstractValidator
{
    protected $faxRetrieveAttachment;
    public function __construct(FaxRetrieveAttachment $faxRetrieveAttachment)
    {
    	$this->faxRetrieveAttachment = $faxRetrieveAttachment;
    }
	public function isValid($incomingMessage)
	{	    
	    return (null!==$this->faxRetrieveAttachment->getFaxAttachment($incomingMessage));
 	}
}
