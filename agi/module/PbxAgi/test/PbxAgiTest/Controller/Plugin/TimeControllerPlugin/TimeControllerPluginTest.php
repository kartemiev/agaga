<?php
namespace PbxAgiTest\Controller\Plugin\TimeControllerPlugin;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\Plugin\TimeControllerPluginFactory;
use Zend\Db\ResultSet\ResultSet;
use PbxAgi\CallCentreStatus\Model\CallCentreStatus;

class TimeControllerPluginTest extends PHPUnit_Framework_TestCase
{
	protected $mockedCallCentreStatusTable;	
	protected $timeControllerPlugin;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         

        $factory = new TimeControllerPluginFactory();
        
        $mockedCallCentreStatusTable = $this->getMockBuilder('PbxAgi\CallCentreStatus\Model\CallCentreStatusTable')
                                            ->disableOriginalConstructor()
                                            ->getMock();
        
        $serviceManager->setService('PbxAgi\CallCentreStatus\Model\CallCentreStatusTable', $mockedCallCentreStatusTable);
        
        
        $this->timeControllerPlugin = $factory->createService($serviceManager);
        
        $this->mockedCallCentreStatusTable = $mockedCallCentreStatusTable;
        
    }
    public function testTimeControllerPluginReturnsTrueWhenIsWorkingHours()
    {
        $callcentrestatus = new CallCentreStatus();
        $callcentrestatus->exchangeArray(array(
        	'status'=>true
        ));
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new CallCentreStatus());
        $resultSet->initialize(array($callcentrestatus));
        $this->mockedCallCentreStatusTable->expects($this->once())
    		 ->method('fetchAll')
    		 ->will($this->returnValue($resultSet));  
	  $this->timeControllerPlugin->isWorkingHours();
    }
}