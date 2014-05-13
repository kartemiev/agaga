<?php
namespace Vpbxui\PbxSettings\Model;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\PbxSettings\Model\PbxSettingsTableInterface;
use Vpbxui\PbxSettings\Model\PbxSettings;

class PbxSettingsTable implements PbxSettingsTableInterface
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter = null)
    {        
        if (!$filter) $filter = array();
        $filter['vpbxid'] = ($filter['vpbxid'])?$filter['vpbxid']:1;
        $resultSet = $this->tableGateway->select($filter);
        return $resultSet;
    }       
    public function savePbxSettings(PbxSettings $pbxsettings)
    {
    
        $data = array(
            'callcentre_status_override' => $pbxsettings->callcentre_status_override, 
        );
        $virtualpbxid = (isset($data['vpbxid']))?(int)$data['vpbxid']:1;
                 $this->tableGateway->update($data, array('vpbxid' => $virtualpbxid));         
    }
}