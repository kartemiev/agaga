<?php
namespace Vpbxui\ExtensionDefaults\Model;

use Vpbxui\ExtensionDefaults\Model\ExtensionDefaults;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ExtensionDefaultsTable {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
         
    public function getExtensionDefaults()
    {
     	$rowset = $this->tableGateway->select();
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row");
    	}
     	return $row;
    }
     
    public function saveExtensionDefaults(ExtensionDefaults $extensionDefaultsGroup)
    {
        
    	$data = array(
     	    'transfer' => $extensionDefaultsGroup->transfer,
    	    'statuschange' => $extensionDefaultsGroup->statuschange,
    	    'incoming' => $extensionDefaultsGroup->incoming,
     	    'hold' => $extensionDefaultsGroup->hold,
    	    'forwarding' => $extensionDefaultsGroup->forwarding,
     		'number_status' => $extensionDefaultsGroup->number_status, 
    		'extensionrecord' => $extensionDefaultsGroup->extensionrecord,
    	    'diversion_unconditional_status' => $extensionDefaultsGroup->diversion_unconditional_status,
    		'diversion_unconditional_number' => $extensionDefaultsGroup->diversion_unconditional_number,
    		'diversion_unavail_status' => $extensionDefaultsGroup->diversion_unavail_status,
    		'diversion_unavail_number' => $extensionDefaultsGroup->diversion_unavail_number,
    		'diversion_busy_status' => $extensionDefaultsGroup->diversion_busy_status,
    		'diversion_busy_number' => $extensionDefaultsGroup->diversion_busy_number,
    		'diversion_noanswer_status' => $extensionDefaultsGroup->diversion_noanswer_status,
    		'diversion_noanswer_number' => $extensionDefaultsGroup->diversion_noanswer_number,
    		'diversion_unconditional_landingtype' => $extensionDefaultsGroup->diversion_unconditional_landingtype,
    		'diversion_unavail_landingtype' => $extensionDefaultsGroup->diversion_unavail_landingtype,
    		'diversion_busy_landingtype' => $extensionDefaultsGroup->diversion_busy_landingtype,
    		'diversion_noanswer_landingtype' => $extensionDefaultsGroup->diversion_noanswer_landingtype,
    		'diversion_noanswer_duration' => $extensionDefaultsGroup->diversion_noanswer_duration,    			     			     			    			
    	);
     		if ($this->getExtensionDefaults()) {
    			$this->tableGateway->update($data);
    		} else {
    			throw new \Exception('Form does not exist');
    	}
    }     
}
