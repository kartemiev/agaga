<?php
namespace PbxAgiTest\GeneralSettings\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\GeneralSettings\Model\GeneralSettings;

class GeneralSettingsTest extends PHPUnit_Framework_TestCase
{
    public function testGeneralSettingsInitialState()
    {        
         $generalsettings = new GeneralSettings();
         $this->assertNull($generalsettings->vpbxid, '"vpbxid" should initially be null');
         $this->assertNull($generalsettings->greeting, '"greeting" should initially be null');
         $this->assertNull($generalsettings->mohtone, '"mohtone" should initially be null');
         $this->assertNull($generalsettings->ringingtone, '"ringingtone" should initially be null');
         $this->assertNull($generalsettings->greetingofftime, '"greetingofftime" should initially be null');
         $this->assertNull($generalsettings->mediarepospath, '"mediarepospath" should initially be null');
         $this->assertNull($generalsettings->mohinternal, '"mohinternal" should initially be null');          
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $generalsettings = new GeneralSettings();
		$data = array(
		         'vpbxid'=>1,
		         'greeting'=> 'телеконференция',
		         'mohtone'=> 2,		    
		    	 'ringingtone'=> 3,		    
		         'greetingofftime'=> 4,	    
		         'mediarepospath'=> '/var/spool/asterisk/mediarepos',		    
		    	 'mohinternal'=> 5		    
		    );
         $generalsettings->exchangeArray($data);

         $this->assertSame($data['vpbxid'], $generalsettings->vpbxid, '"vpbxid" was not set correctly');
         $this->assertSame($data['greeting'], $generalsettings->greeting, '"greeting" was not set correctly');
         $this->assertSame($data['mohtone'], $generalsettings->mohtone, '"mohtone" was not set correctly');
         $this->assertSame($data['ringingtone'], $generalsettings->ringingtone, '"ringingtone" was not set correctly');
         $this->assertSame($data['greetingofftime'], $generalsettings->greetingofftime, '"greetingofftime" was not set correctly');
         $this->assertSame($data['mediarepospath'], $generalsettings->mediarepospath, '"mediarepospath" was not set correctly');
         $this->assertSame($data['mohinternal'], $generalsettings->mohinternal, '"mohinternal" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $generalsettings = new GeneralSettings();
            	
        $generalsettings->exchangeArray(array(
                  'vpbxid'=>1,
		         'greeting'=> 'телеконференция',
		         'mohtone'=> 2,		    
		    	 'ringingtone'=> 3,		    
		         'greetingofftime'=> 4,	    
		         'mediarepospath'=> '/var/spool/asterisk/mediarepos',		    
		    	 'mohinternal'=> 5			    
                                    ));
        $generalsettings->exchangeArray(array());    
        $this->assertNull($generalsettings->vpbxid, '"vpbxid" should have defaulted to null');
        $this->assertNull($generalsettings->greeting, '"vpbxid" should have defaulted to null');
        $this->assertNull($generalsettings->mohtone, '"mohtone" should have defaulted to null');
        $this->assertNull($generalsettings->ringingtone, '"ringingtone" should have defaulted to null');
        $this->assertNull($generalsettings->greetingofftime, '"greetingofftime" should have defaulted to null');
        $this->assertNull($generalsettings->mediarepospath, '"mediarepospath" should have defaulted to null');
        $this->assertNull($generalsettings->mohinternal, '"mohinternal" should have defaulted to null');
      }
      public function testGetArrayCopyPerformsCorrectly()
      {
      	$generalsettings = new GeneralSettings();
      	$this->assertSame(get_object_vars($generalsettings), $generalsettings->getArrayCopy(), 'getArrayCopy should return array copy of GeneralSettings porperties');
      }
      
}
