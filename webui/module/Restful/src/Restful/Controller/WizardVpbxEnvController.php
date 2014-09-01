<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Saas\FreeDid\Model\FreeDidTableInterface;
use Saas\WizardSessionContainer\WizardSessionContainerInterface;
use Zend\View\Model\JsonModel;
use Zend\Http\Response;
use Zend\Form\Annotation\AnnotationBuilder as FormBuilder;
use Saas\VpbxEnv\Model\VpbxEnv;

class WizardVpbxEnvController extends AbstractRestfulController
{
	protected $freeDidTable;
	protected $wizardSessionContainer;
	public function __construct(FreeDidTableInterface $freeDidTable, WizardSessionContainerInterface $wizardSessionContainer)
	{
		$this->freeDidTable = $freeDidTable;
		$this->wizardSessionContainer = $wizardSessionContainer;
	}
	public function patchList($data) // allowed to patch only one propery - outgoingtrunk_did
	{
		
		$did = $this->freeDidTable->getDid($id);
			
		if (!$did)
		{
			$this->getResponse()->setStatusCode(Response::STATUS_CODE_409);				
			 return new JsonModel(array('success'=>'false'));
		}
		$vpbxEnv = $this->wizardSessionContainer->getVpbxEnv();
		$vpbxEnv->outgoingtrunk_did = $did->id;
		$vpbxEnv->vpbx_name = '';
		$vpbxEnv->vpbx_description = '';
		$this->wizardSessionContainer->setVpbxEnv($vpbxEnv);
		$didPatch = new FreeDid();
		$didPatch->id = $did->id;
		$currentDate = new \DateTime();
		$didPatch->reservationdate = $currentDate->format('Y-m-d H:i:s');;
		$reservationDate = clone $currentDate;
		$reservationDate->add(new \DateInterval("PT1H"));
		$didPatch->reserveduntil = $reservationDate->format('Y-m-d H:i:s');;
		$this->freeDidTable->saveDid($didPatch);
		$this->wizardSessionContainer->setDid($did);		
		$builder = new FormBuilder();
		$form = $builder->createForm(new VpbxEnv());
		$this->getResponse()->setStatusCode(Response::STATUS_CODE_201);		
		return new JsonModel(array('success'=>'true','data'=>$form->getHydrator()->extract($did)));	
	}
	
}