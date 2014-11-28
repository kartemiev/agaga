<?php
namespace Vpbxui\ConferenceSettings\Model;
 
use Zend\Db\TableGateway\TableGateway;

class ConferenceSettingsTable
{
    
    protected $tableGateway;
     
    public function __construct(TableGateway $tablegateway)
    {
        $this->tableGateway = $tablegateway;
     }

    public function getConferenceSettings()
    {
         $rowset = $this->tableGateway->select();          
         return $rowset->current();
    }  
    public function saveConferenceSettings(ConferenceSettings $conferenceSettings)
    {        
    	$data = array(            
      	    'deny' => $conferenceSettings->deny,
    	    'permit' => $conferenceSettings->permit,
    	    'accessmode' => $conferenceSettings->accessmode    	  
      	);
     	  $this->tableGateway->update($data);
    }          
}