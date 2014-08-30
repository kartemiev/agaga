<?php
namespace Vpbxui\Service\VpbxidProvider;

use Zend\Db\TableGateway\Feature\AbstractFeature;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Update;
  
class VpbxidFeature extends AbstractFeature
{
    protected $vpbxidProvider;
     public function __construct(VpbxidProviderInterface $vpbxidProvider)
    {
        $this->vpbxidProvider = $vpbxidProvider;
     }
    public function preSelect(Select $select)
    {
          $this->vpbxidProvider->vpbxFilter($select);
    }
    public function preUpdate(Update $update)
    {
         $this->vpbxidProvider->vpbxFilter($update);
     }
    public function preInsert(Insert $insert)
    {
        $insert->values(array('vpbxid'=>$this->vpbxidProvider->getVpbxId()), Insert::VALUES_MERGE);
     }
    public function preDelete(Delete $delete)
    {
        $this->vpbxidProvider->vpbxFilter($delete);        
    }
            
}