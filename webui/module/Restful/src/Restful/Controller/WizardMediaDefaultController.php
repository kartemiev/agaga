<?php
namespace Restful\Controller;
  
use Zend\Mvc\Controller\AbstractRestfulController;
use Saas\WizardSessionContainer\WizardSessionContainer;
use Saas\TempMedia\Model\TempMediaTableInterface;
use Saas\WizardSessionContainer\MediaTypeMapperNamingStrategy;
use Zend\View\Model\JsonModel;
use Zend\Http\Response;

class WizardMediaDefaultController extends AbstractRestfulController
{
     protected $wizardSessionContainter;
     protected $tempMediaTable;
     public function __construct(WizardSessionContainer $wizardSessionContainter, TempMediaTableInterface $tempMediaTable)
     {
         $this->wizardSessionContainter = $wizardSessionContainter;
         $this->tempMediaTable = $tempMediaTable;
     }
     
     public function update($id, $data)
     {
         $mediaTypeMapperNamingStrategy = new MediaTypeMapperNamingStrategy();

         $mediatype = $mediaTypeMapperNamingStrategy->hydrate($id);
         if (!$mediatype)
         {
             $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);              
             return new JsonModel();
         }
         if (!key_exists('default', $data))
         {
             $this->getResponse()->setStatusCode(Response::STATUS_CODE_400);
             return new JsonModel();
         }
         if (true!==$data['default'])
         {
             $this->getResponse()->setStatusCode(Response::STATUS_CODE_403);
             return new JsonModel();
         }
          
         $defaultmedia = $this->tempMediaTable->fetchAll(array('isdefault'=>true,'mediatype'=>$mediatype))->current();
         $this->wizardSessionContainter->media[$id]=$defaultmedia;
         return new JsonModel(
                array('success'=>true,'result'=>array('id'=>$defaultmedia->id, 'custname'=>$defaultmedia->custname),'data'=>array('default'=>true))
             );
     }
}