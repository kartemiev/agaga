<?php
namespace PbxAgiTest\Extension\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\Extension\Model\Extension;
use PbxAgi\Extension\Model\ExtensionTable;

class ExtensionTableTest extends PHPUnit_Framework_TestCase
{
    public function testCanRetriveAllExtensions()
    {
        $extension = new Extension();
        $extension->exchangeArray(array(
        		'id'=>2,
        		'extension'=>'100',
        		'extensiongroup'=>3,
        		'extensiontype'=>'',
        		'name'=>'100',
        		'outgoingcallspermission'=>'undefined',
        		'transfer'=>'allowed',
        		'statuschange'=>'allowed',
        		'incoming'=>'allowed',
        		'hold'=>'allowed',
        		'forwarding'=>'allowed',
        		'memberofcallcentreque'=>true,
        		'mailbox'=>'100@default',
        		'callsequence'=>'sequential',
        		'number_status'=>'active',
        		'extensionrecord'=>'UNDEFINED',
        		'peertype'=>'EXTENSION',
        		'diversion_unconditional_status'=>'UNDEFINED',
        		'diversion_unconditional_number'=>'',
        		'diversion_unavail_status'=>'UNDEFINED',
        		'diversion_unavail_number'=>'',
        		'diversion_busy_status'=>'UNDEFINED',
        		'diversion_busy_number'=>'',
        		'diversion_noanswer_status'=>'UNDEFINED',
        		'diversion_noanswer_number'=>'',
        		'diversion_unconditional_landingtype'=>'',
        		'diversion_busy_landingtype'=>'',
        		'diversion_noanswer_landingtype'=>'',
        		'diversion_unavail_landingtype'=>'',
        		'diversion_noanswer_duration'=>''
        )
        );
        
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Extension());
        $resultSet->initialize(array($extension));
        
        $filter = null;
        $limit = null;

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
        		array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
        ->method('select')
        ->with(function(){})
        ->will($this->returnValue($resultSet));
        
        $extensionTable = new ExtensionTable($mockTableGateway);
        
        $this->assertSame($resultSet, $extensionTable->fetchAll());
        
    }
    
    public function testCanRetriveFaxExtension()
    {
    	$extension = new Extension();
    	$extension->exchangeArray(array(
    			'id'=>2,
    			'extension'=>'100',
    			'extensiongroup'=>3,
    			'extensiontype'=>'',
    			'name'=>'100',
    			'outgoingcallspermission'=>'undefined',
    			'transfer'=>'allowed',
    			'statuschange'=>'allowed',
    			'incoming'=>'allowed',
    			'hold'=>'allowed',
    			'forwarding'=>'allowed',
    			'memberofcallcentreque'=>true,
    			'mailbox'=>'100@default',
    			'callsequence'=>'sequential',
    			'number_status'=>'active',
    			'extensionrecord'=>'UNDEFINED',
    			'peertype'=>'EXTENSION',
    			'diversion_unconditional_status'=>'UNDEFINED',
    			'diversion_unconditional_number'=>'',
    			'diversion_unavail_status'=>'UNDEFINED',
    			'diversion_unavail_number'=>'',
    			'diversion_busy_status'=>'UNDEFINED',
    			'diversion_busy_number'=>'',
    			'diversion_noanswer_status'=>'UNDEFINED',
    			'diversion_noanswer_number'=>'',
    			'diversion_unconditional_landingtype'=>'',
    			'diversion_busy_landingtype'=>'',
    			'diversion_noanswer_landingtype'=>'',
    			'diversion_unavail_landingtype'=>'',
    			'diversion_noanswer_duration'=>''
    	)
    	);
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Extension());
    	$resultSet->initialize(array($extension));
    
    	$filter = null;
    	$limit = null;
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	->method('select')
    	->with(array(
            'faxextension' => true
        ))
    	->will($this->returnValue($resultSet));
    
    	$extensionTable = new ExtensionTable($mockTableGateway);
    
    	$this->assertSame($extension, $extensionTable->getFaxExtension());
    
    }
    public function testRetriveFaxExtensionWhenFaxExtensionIsNotFound()
    {
    	 
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Extension());
    	$resultSet->initialize(array());
    
    	$filter = null;
    	$limit = null;
    
    	$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
    	$mockTableGateway->expects($this->once())
    	->method('select')
    	->with(array(
    			'faxextension' => true
    	))
    	->will($this->returnValue($resultSet));
    
    	$extensionTable = new ExtensionTable($mockTableGateway);
    
    	$this->assertNull($extensionTable->getFaxExtension());
    
    }
    
	public function testCanRetrieveAnextensionByItsId()
	{
		$extension = new Extension();
		$extension->exchangeArray(array(
		      'id'=>2,
		      'extension'=>'100',
		      'extensiongroup'=>3,
		      'extensiontype'=>'',
		      'name'=>'100',
		      'outgoingcallspermission'=>'undefined',
		      'transfer'=>'allowed',
		      'statuschange'=>'allowed',
		      'incoming'=>'allowed',
		      'hold'=>'allowed',
		      'forwarding'=>'allowed',
		      'memberofcallcentreque'=>true,
		      'mailbox'=>'100@default',
		      'callsequence'=>'sequential',
		      'number_status'=>'active',
		      'extensionrecord'=>'UNDEFINED',
		      'peertype'=>'EXTENSION',
		      'diversion_unconditional_status'=>'UNDEFINED',
		      'diversion_unconditional_number'=>'',
		      'diversion_unavail_status'=>'UNDEFINED',
		      'diversion_unavail_number'=>'',
		      'diversion_busy_status'=>'UNDEFINED',
		      'diversion_busy_number'=>'',
		      'diversion_noanswer_status'=>'UNDEFINED',
		      'diversion_noanswer_number'=>'',
		      'diversion_unconditional_landingtype'=>'',
		      'diversion_busy_landingtype'=>'',
		      'diversion_noanswer_landingtype'=>'',
		      'diversion_unavail_landingtype'=>'',
		      'diversion_noanswer_duration'=>''		    
		)
		    );
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new Extension());
		$resultSet->initialize(array($extension));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(array('id' => 2))
		->will($this->returnValue($resultSet));
	
		$extensionTable = new ExtensionTable($mockTableGateway);
	
		$this->assertSame($extension, $extensionTable->getExtensionById(2));
	}
	
	public function testRetrieveAnextensionByItsIdReturnsNullWhenExtensionIsNotFound()
	{
		 
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new Extension());
		$resultSet->initialize(array());
		
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		->method('select')
		->with(array('id' => 2))
		->will($this->returnValue($resultSet));
	
		$extensionTable = new ExtensionTable($mockTableGateway);
	
		$this->assertNull($extensionTable->getExtensionById(2));
	}
	
	public function testCanRetrieveAnextensionByExtensionNum()
	{
		$extension = new Extension();
		$extension->exchangeArray(array(
				'id'=>2,
				'extension'=>'100',
				'extensiongroup'=>3,
				'extensiontype'=>'',
				'name'=>'100',
				'outgoingcallspermission'=>'undefined',
				'transfer'=>'allowed',
				'statuschange'=>'allowed',
				'incoming'=>'allowed',
				'hold'=>'allowed',
				'forwarding'=>'allowed',
				'memberofcallcentreque'=>true,
				'mailbox'=>'100@default',
				'callsequence'=>'sequential',
				'number_status'=>'active',
				'extensionrecord'=>'UNDEFINED',
				'peertype'=>'EXTENSION',
				'diversion_unconditional_status'=>'UNDEFINED',
				'diversion_unconditional_number'=>'',
				'diversion_unavail_status'=>'UNDEFINED',
				'diversion_unavail_number'=>'',
				'diversion_busy_status'=>'UNDEFINED',
				'diversion_busy_number'=>'',
				'diversion_noanswer_status'=>'UNDEFINED',
				'diversion_noanswer_number'=>'',
				'diversion_unconditional_landingtype'=>'',
				'diversion_busy_landingtype'=>'',
				'diversion_noanswer_landingtype'=>'',
				'diversion_unavail_landingtype'=>'',
				'diversion_noanswer_duration'=>''
		)
		);
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new Extension());
		$resultSet->initialize(array($extension));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                 ->with(array('extension' => '100', 
		                     'peertype'=>'EXTENSION'		                 	
		                 ))
		                 ->will($this->returnValue($resultSet));
	
		$extensionTable = new ExtensionTable($mockTableGateway);
	
		$this->assertSame($extension, $extensionTable->getExtension('100'));
	}
	
	public function testRetrieveAnextensionByNumReturnsNullWhenExtensionIsNotFound()
	{
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new Extension());
		$resultSet->initialize(array());
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                  ->method('select')
		                  ->with(array('extension' => '100','peertype'=>'EXTENSION'))
		                  ->will($this->returnValue($resultSet));
	
		$extensionTable = new ExtensionTable($mockTableGateway);
	
		$this->assertNull($extensionTable->getExtension('100'));
	}
	public function testCanUpdateUconditionalForwardForAnExtension()
	{
	    $data = array(
	        'diversion_unconditional_status'=>'UNDEFINED',
	        'diversion_unconditional_number'=>''	    
	    );
		$extension = new Extension();
		$extension->exchangeArray($data);
	    $extension->extension = '100';
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new Extension());
		$resultSet->initialize(array($extension));
	
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('update'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('update')
		                 ->with($data,array('extension' => '100'
		                  ))
		->will($this->returnValue($resultSet));
	
		$extensionTable = new ExtensionTable($mockTableGateway);
	
	    $extensionTable->updateExtensionUnconditionalForward($extension);
	}
	 
	public function testCanCheckExtensionValidatorReturnsTrueWhenExtensionIsValid()
	{
	    $data = 
	    array(
	    		'id'=>2,
	    		'extension'=>'100',
	    		'extensiongroup'=>3,
	    		'extensiontype'=>'',
	    		'name'=>'100',
	    		'outgoingcallspermission'=>'undefined',
	    		'transfer'=>'allowed',
	    		'statuschange'=>'allowed',
	    		'incoming'=>'allowed',
	    		'hold'=>'allowed',
	    		'forwarding'=>'allowed',
	    		'memberofcallcentreque'=>true,
	    		'mailbox'=>'100@default',
	    		'callsequence'=>'sequential',
	    		'number_status'=>'active',
	    		'extensionrecord'=>'UNDEFINED',
	    		'peertype'=>'EXTENSION',
	    		'diversion_unconditional_status'=>'UNDEFINED',
	    		'diversion_unconditional_number'=>'',
	    		'diversion_unavail_status'=>'UNDEFINED',
	    		'diversion_unavail_number'=>'',
	    		'diversion_busy_status'=>'UNDEFINED',
	    		'diversion_busy_number'=>'',
	    		'diversion_noanswer_status'=>'UNDEFINED',
	    		'diversion_noanswer_number'=>'',
	    		'diversion_unconditional_landingtype'=>'',
	    		'diversion_busy_landingtype'=>'',
	    		'diversion_noanswer_landingtype'=>'',
	    		'diversion_unavail_landingtype'=>'',
	    		'diversion_noanswer_duration'=>''
	    )
	     ;
	    $extension = new Extension();
		$extension->exchangeArray($data);
	
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new Extension());
		$resultSet->initialize(array($extension));
	    
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		                 ->method('select')
		                  ->with(array('extension' => '100',
		                  'peertype'=>'EXTENSION'))
		                 ->will($this->returnValue($resultSet));
	
		
		$extensionTable = new ExtensionTable($mockTableGateway);		
		$this->assertTrue($extensionTable->isValid('100'),'Extension Validator should return true on valid extension');
	}
	public function testCanCheckExtensionValidatorReturnsFalseWhenExtensionIsInvalid()
	{
		$resultSet = new ResultSet();
		$resultSet->setArrayObjectPrototype(new Extension());
		 
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
		$mockTableGateway->expects($this->once())
		->method('select')
		->with(array('extension' => '100',
				'peertype'=>'EXTENSION'))
				->will($this->returnValue($resultSet));
	
	
		$extensionTable = new ExtensionTable($mockTableGateway);
		$this->assertFalse($extensionTable->isValid('100'),'Extension Validator should return false on invalid extension');
	}
	
}