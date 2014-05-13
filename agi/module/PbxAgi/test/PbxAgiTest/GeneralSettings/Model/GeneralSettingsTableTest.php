<?php
namespace PbxAgiTest\GeneralSettings\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\GeneralSettings\Model\GeneralSettings;
use PbxAgi\GeneralSettings\Model\GeneralSettingsTable;

class GeneralSettingsTableTest extends PHPUnit_Framework_TestCase
{
    public function testCanRetrieveAGeneralSettingsByItsVpbxId()
    {
        $data = array(
                 'vpbxid'=>1,
		         'greeting'=> 'телеконференция',
		         'mohtone'=> 2,		    
		    	 'ringingtone'=> 3,		    
		         'greetingofftime'=> 4,	    
		         'mediarepospath'=> '/var/spool/asterisk/mediarepos',		    
		    	 'mohinternal'=> 5		 
        );
        
    	$generalsettings = new GeneralSettings();
    	$generalsettings->exchangeArray($data);
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new GeneralSettings());
    	$resultSet->initialize(array($generalsettings));
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	                 ->method('select')
    	                 ->with(array('vpbxid'=>1))
    	                 ->will($this->returnValue($resultSet));
    
    	$generalsettingsTable = new GeneralSettingsTable($mockTableGateway);
    
    	$this->assertSame($generalsettings, $generalsettingsTable->getSettings(1));
    }
     public function testGetSettingsThrowsAnExceptionRowIsNotFound()
    {
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new GeneralSettings());
    	$resultSet->initialize(array());
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	                 ->method('select')
    	                 ->with(array('vpbxid' => 1))
    	                 ->will($this->returnValue($resultSet));
    
    	$generalSettingsTable = new GeneralSettingsTable($mockTableGateway);
    
    	try
    	{
    		$generalSettingsTable->getSettings(1);		}
    		catch (\Exception $e)
    		{
    			$this->assertSame("Could not find row", $e->getMessage());
    			return;
    		}
    			
    		$this->fail('Expected exception was not thrown');
    
    }
    
 }