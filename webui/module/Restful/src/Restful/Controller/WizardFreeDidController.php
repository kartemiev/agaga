<?php
namespace Restful\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Saas\FreeDid\Model\FreeDidTableInterface;
use Zend\View\Model\JsonModel;
use Saas\VpbxEnv\Model\VpbxEnv;
use Saas\FreeDid\Model\FreeDid;
use Saas\WizardSessionContainer\WizardSessionContainerInterface;
use GuzzleHttp\Exception\ClientException;
use Saas\Did\Model\DidTableInterface;
use Saas\Did\Model\Did;

class WizardFreeDidController extends AbstractRestfulController
{
	protected $freeDidTable;
	protected $wizardSessionContainer;
	protected $didTable;
	public function __construct(FreeDidTableInterface $freeDidTable, WizardSessionContainerInterface $wizardSessionContainer, DidTableInterface $didTable)
	{
		$this->freeDidTable = $freeDidTable;
		$this->wizardSessionContainer = $wizardSessionContainer;
		$this->didTable = $didTable;
	}
	public function getList()
	{
		$page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 99999999;
		$itemsPerPage = $this->params()->fromQuery('limit') ? (int) $this->params()->fromQuery('limit') : 10;
		
		$apiGateway = $this->freeDidTable->getApiGateway();
		
		$resultSet  = $this->freeDidTable->fetchAll(array('offset'=>1,'limit'=>$itemsPerPage));
		$dids = array();
		foreach ($resultSet as $did)
		{
			$dids[]=$did->getArrayCopy();
		}
		
		return new JsonModel(
				array(
				    'error'=>0,
				    'success'=>'true',
				    'data'=>$dids
				)
		);
	}
	public function patch($id, $data)
	{
	    /*
	     * разрешаем только изменять статус свободного номера  - переводить в зарезервированный,
	     * другие операции не разрешены
	     * 
	     */
	    if (!isset($data['status'])||'reserved'!=$data['status'])
	    {
	        $this->getResponse()->setStatusCode(422);
	        return new JsonModel(
	            array(
	                'error'=>1,
	                'errormsg'=>array('status'=>'Поле статус должно быть в позиции "reserved"'),
	                'success'=>false
	            )
	        );
	    }
 	    if ($this->wizardSessionContainer->getDid())
	    {
	        $oldDid = $this->wizardSessionContainer->getDid();
	        $oldDidPatch = new Did();
	        $oldDidPatch->id = $oldDid->id;
	        $currentDate = new \DateTime();
	        $currentDate->sub(new \DateInterval("PT1M"));
	        $oldDidPatch->reservationdate = $currentDate->format('Y-m-d H:i:s');;
	        $oldDidPatch->reserveduntil = $currentDate->format('Y-m-d H:i:s');;
	        $this->didTable->saveDid($oldDidPatch);
	    }
	     
	    
	    try {
	    $did = $this->freeDidTable->getDid($id);

	    } catch (ClientException $e)
	    {
	        $this->getResponse()->setStatusCode($e->getResponse()->getStatusCode());
	        return new JsonModel(array('errmsg'=>'ошибка при проксировании через API'));	         
	    }
	    if (!$did)
	       {
	           $this->getResponse()->setStatusCode(404);    	 
    	             return new JsonModel(
    			         array(
    			             'error'=>404,
    			             'success'=>false    			    	
    	                   )
    	               );
	       }
	    $vpbxEnv = new VpbxEnv();
	    $vpbxEnv->outgoingtrunk_did = $id;
	    $vpbxEnv->vpbx_name = '';
	    $vpbxEnv->vpbx_description = '';	    
	    $this->wizardSessionContainer->setVpbxEnv($vpbxEnv);
	    $didPatch = new FreeDid();
	    $didPatch->id = $id;
	    $currentDate = new \DateTime();
	    $didPatch->reservationdate = $currentDate->format('Y-m-d H:i:s');
	    $reservationDate = clone $currentDate;
	    $reservationDate->add(new \DateInterval("PT1H"));
	    $didPatch->reserveduntil = $reservationDate->format('Y-m-d H:i:s');
	    $this->freeDidTable->saveDid($didPatch);
	    	    
 	    
	    $this->wizardSessionContainer->did=$didPatch;
	     
	    
	    return new JsonModel(
	        array(
	            'error'=>0,
	            'success'=>'true',
	            'data'=>$did->getArrayCopy()	            
	        	)
	    );	     	    
	    }        
	}
