<?php
namespace PbxAgi\Service\SendEmail;

use PbxAgi\Service\SendEmail\EmailMessage;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use PbxAgi\Service\SendEmail\SendEmailInterface;

class SendEmail implements SendEmailInterface
{
	protected $sendEmailTransport;	
	public function __construct($sendEmailTransport)
	{
		$this->sendEmailTransport = $sendEmailTransport;
	}
	
	public function send(EmailMessage $message)
	{
		$bodyTextPlain = '';
		$date = date('d/m/Y');
		$time = date('H:i:s');
		
		$view = new \Zend\View\Renderer\PhpRenderer();
		$resolver = new \Zend\View\Resolver\TemplateMapResolver();
		$resolver->setMap($this->getTemplateMap());
		$view->setResolver($resolver);
		
		$viewModel = new \Zend\View\Model\ViewModel(
				array_merge(array(
						'date' => $date,
						'time' => $time,
						
				),$message->parameters)
		);
		
		$viewModel->setTemplate($message->templateplain);
		$contentPlain = $view->render($viewModel);
		$viewModel->setTemplate($message->templatehtml);
		$contentHtml = $view->render($viewModel);
		$viewLayout = new \Zend\View\Model\ViewModel();
		$viewLayout->setTemplate($message->layoutplain)
		->setVariables(array(
				'content' => $contentPlain
		));
		
		$bodyTextPlain =  $view->render($viewLayout);
		
		 
		$viewLayout->setTemplate($message->layouthtml)
		->setVariables(array(
				'content' => $contentHtml
		));
		
		$bodyTextHtml = $view->render($viewLayout);
		 
		
		$text = new MimePart($bodyTextPlain);
		$text->type = "text/plain";
		
		$html = new MimePart($bodyTextHtml);
		$html->type = "text/html";
		
		
		$attachments = array();
		foreach ($message->attachments as $attachment)
		{
			$attachment = new MimePart(fopen($attachment['path'], 'r'));
			$type =  $attachment['type'];
			$attachment->type = $type;
			$attachments[] = $attachment;
		}
		
		
		$body = new MimeMessage();
		$body->setParts(array_merge(array($text, $html),$attachments));
		 
		$msgFromEmail = $message->msgfromemail;
		$msgFromFullName = $message->msgfromfullname;
		$msgTo = $message->msgto;
		$msg = new Message();
		$msg->setEncoding('UTF-8');
		$msg->addFrom($msgFromEmail, $msgFromFullName)
				->addTo($msgTo)
				->setSubject($message->msgsubject);
		$msg->setBody($body);
		$this->sendEmailTransport->send($msg);
	}
	protected function getTemplateMap()
	{
		return array(
				'mailLayoutPlain' => __DIR__ . '/../../../../view/layout/layout-mail-plain.phtml',
				'mailTemplatePlain' => __DIR__ . '/../../../../view/pbxagi/faxin/notification-plain.phtml',
				'mailLayoutHtml' => __DIR__ . '/../../../../view/layout/layout-mail-html.phtml',
				'mailTemplateHtml' => __DIR__ . '/../../../../view/pbxagi/faxin/notification-html.phtml'
   
		);
	}
}