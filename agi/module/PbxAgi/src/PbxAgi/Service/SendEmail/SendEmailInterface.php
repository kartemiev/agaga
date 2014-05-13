<?php
namespace PbxAgi\Service\SendEmail;

use PbxAgi\Service\SendEmail\EmailMessage;

interface SendEmailInterface
{
	function send(EmailMessage $message);	
}