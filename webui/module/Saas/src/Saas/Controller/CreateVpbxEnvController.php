<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vpbxui\Extension\Model\ExtensionTableInterface;
use DOMPDFModule\View\Model\PdfModel;
use Saas\WizardSessionContainer\WizardSessionContainer;
 

class CreateVpbxEnvController extends AbstractActionController
{	
    protected $extensionTable;
    protected $wizardSessionContainer;
    public function __construct(ExtensionTableInterface $extensionTable, WizardSessionContainer $wizardSessionContainer)
    {
        $this->extensionTable = $extensionTable;
        $this->wizardSessionContainer = $wizardSessionContainer;
    }
	public function indexAction()
	{
	    if ((!isset($this->wizardSessionContainer->internalnumbers)&&!isset($this->wizardSessionContainer->did))||isset($this->wizardSessionContainer->completed))
	    {
	        return $this->redirect()->toRoute('home');
	    }	     
	    $indexView = $this->forward()->dispatch('Vpbxui\Controller\Index',array('action'=>'index'));
	    $viewModel = new ViewModel();
	    $viewModel->addChild($indexView,'indexView');
        return $viewModel;
	}
	public function overviewAction()
	{
	    $internalnumbers = $this->extensionTable->fetchAll();
	    $indexView = $this->forward()->dispatch('Vpbxui\Controller\Index',array('action'=>'index'));	     
	    $viewModel = new ViewModel(array('internalnumbers'=>$internalnumbers));
	    $viewModel->addChild($indexView,'indexView');
 	    return $viewModel;
	}
	public function pdfAction()
	{
	    $internalnumbers = $this->extensionTable->fetchAll();
	    $pdf = new PdfModel(array('internalnumbers'=>$internalnumbers));
	    $pdf->setOption("filename", "internal");    
	    return $pdf;
	}
	public function csvAction()
	{
	    $internalnumbers = $this->extensionTable->fetchAll();
	     
	  $view = new ViewModel(array('internalnumbers'=>$internalnumbers));
        $view->
        setTemplate('createvpbx/csv')
        ->setTerminal(true);


    $output = $this->getServiceLocator()
                   ->get('viewrenderer')
                   ->render($view);

    $response = $this->getResponse();

    $headers = $response->getHeaders();
    $headers->addHeaderLine('Content-Type', 'text/csv')
            ->addHeaderLine(

                'Content-Disposition', 
                sprintf("attachment; filename=\"%s\"", 'internal.csv')
            )
            ->addHeaderLine('Accept-Ranges', 'bytes')
            ->addHeaderLine('Content-Length', strlen($output));

    $response->setContent($output);

    return $response;
	}
	
}