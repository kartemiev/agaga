<?php
namespace Vpbxui\GeneralSettings\Model;

use Zend\Db\TableGateway\TableGateway;
use Vpbxui\GeneralSettings\Model\GeneralSettings;

class GeneralSettingsTable {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
       
    public function getSettings()
    {
     	$rowset = $this->tableGateway->select();
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row");
    	}
     	return $row;
    }
        
    public function saveSettings(GeneralSettings $settings)
    {
        
    	$data = array(
    	    'vmtimeout' => $settings->vmtimeout     	   	
    	); 
    	if ($settings->greeting)
    	{
    	    $data['greeting']=$settings->greeting;
    	}
    	if ($settings->greetingofftime)
    	{
    	    $data['greetingofftime']=$settings->greetingofftime;
    	}
    	if ($settings->mohtone)
    	{
    	    $data['mohtone']=$settings->mohtone;
    	}
    	if ($settings->ringingtone)
    	{
    	    $data['ringingtone']=$settings->ringingtone;
    	}
    	if ($settings->greeting) $data['greeting']=$settings->greeting;
    	
    	if ($settings->mohinternal)
    	{
    		$data['mohinternal']=$settings->mohinternal;
    	}
    	
         $this->tableGateway->update($data);
    }
    
    
}
