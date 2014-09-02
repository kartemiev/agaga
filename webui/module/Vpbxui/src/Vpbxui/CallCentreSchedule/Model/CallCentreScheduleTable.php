<?php
namespace Vpbxui\CallCentreSchedule\Model;

use Zend\Db\TableGateway\TableGateway;


class CallCentreScheduleTable implements CallCentreScheduleTableInterface
{
    protected $tableGateway;
     public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
     }
    
    public function getCallCentreSchedule()
    {
    	$rowset = $this->tableGateway->select();
    	 
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row");
    	}
     
    	return $row;    	
    }
    
    
   public function saveCallCentreSchedule(CallCentreSchedule $callcentreschedule)
    {
        
    	$data = array(
    		's_monday' => $callcentreschedule->s_monday,
    	   	'e_monday' => $callcentreschedule->e_monday,
    		'active_monday' => $callcentreschedule->active_monday,	
    		's_tuesday' => $callcentreschedule->s_tuesday,
    		'e_tuesday' => $callcentreschedule->e_tuesday,
    		'active_tuesday' => $callcentreschedule->active_tuesday,
    		's_wednesday' => $callcentreschedule->s_wednesday,
    		'e_wednesday' => $callcentreschedule->e_wednesday,
    		'active_wednesday' => $callcentreschedule->active_wednesday,
    		's_thursday' => $callcentreschedule->s_thursday,
    		'e_thursday' => $callcentreschedule->e_thursday,
    		'active_thursday' => $callcentreschedule->active_thursday,
    		's_friday' => $callcentreschedule->s_friday,
    		'e_friday' => $callcentreschedule->e_friday,
    		'active_friday' => $callcentreschedule->active_friday,
    		's_saturday' => $callcentreschedule->s_saturday,
    		'e_saturday' => $callcentreschedule->e_saturday,
    		'active_saturday' => $callcentreschedule->active_saturday,    		
    		's_sunday' => $callcentreschedule->s_sunday,
    		'e_sunday' => $callcentreschedule->e_sunday,
    		'active_sunday' => $callcentreschedule->active_sunday,  
    		's_shortday' => $callcentreschedule->s_shortday,
    		'e_shortday' => $callcentreschedule->e_shortday,    
    		's_regularwd' => $callcentreschedule->s_regularwd,
    		'e_regularwd' => $callcentreschedule->e_regularwd			
        	);
     
     	 $cSchedule = $this->getCallCentreSchedule();
    		if ($cSchedule) {
    			$this->tableGateway->update($data);
    		} else {
    			throw new \Exception('vpbx id does not exist');
    		}
    	
    }
}