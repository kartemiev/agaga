<?php
namespace PbxAgi\Service\FaxParse;

use Zend\Validator\AbstractValidator;
use PbxAgi\FaxUser\Model\FaxUserTableInterface;

class FaxSenderValidator extends AbstractValidator
{
    protected $faxUserTable;
    protected $faxRetrieveSender;
    public function __construct(
        FaxUserTableInterface $faxUserTable, 
        FaxRetrieveSender $faxRetrieveSender
        )
    {
    	$this->faxUserTable = $faxUserTable;
    	$this->faxRetrieveSender = $faxRetrieveSender;
    }
	public function isValid($incomingMessage)
	{
	    $faxSender = $this->faxRetrieveSender->getSender($incomingMessage);
	    $faxUser = $this->checkFaxUser($faxSender);
 	    $faxUser = (isset($faxUser))?$faxUser:null;
	    if (!$faxUser)
	    {
	       return false;
	    }
	    return (null!==$faxUser);
	}
	protected function checkFaxUser($email)
	{
		$faxuser =  $this->faxUserTable->getFaxUserByEmail($email);
		$faxuser = (isset($faxuser))?$faxuser:null;
		return $faxuser;
	}
}
