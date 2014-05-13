<?php
namespace PbxAgiTest\Service\SkypeAliasResolver;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use Zend\Mail\Message as MailMessage;
use PbxAgi\Entity\IncomingMessage;
use PbxAgi\Service\FaxParse\FaxRetrieveSender;
use PbxAgi\Service\SkypeAliasResolver\SkypeAliasResolverFactory;
use PbxAgi\SkypeAlias\Model\SkypeAlias;

class SkypeAliasResolverTest extends PHPUnit_Framework_TestCase
{
	protected $mockedSkypeAliasTable;
	protected $faxAliasResolver;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $mockedSkypeAliasTable = $this->getMock('PbxAgi\SkypeAlias\Model\SkypeAliasTable', array('getSkypeAliasByExten'), array(), '', false);
        
        $serviceManager->setService('PbxAgi\SkypeAlias\Model\SkypeAliasTable', $mockedSkypeAliasTable);
        $this->mockedSkypeAliasTable = $mockedSkypeAliasTable;
        
        $factory = new SkypeAliasResolverFactory();
        $this->faxAliasResolver  = $factory->createService($serviceManager);
                        
    }
    public function testSkypeAliasResolverReturnsTrueOnValidSkypeAlias()
    {
        $skypeAlias = new SkypeAlias();
        $skypeAlias->skypeid = 'ivan_ivanov';
        $this->mockedSkypeAliasTable->expects($this->once())
                                    ->method('getSkypeAliasByExten')
                                    ->with('2100')
                                    ->will($this->returnValue($skypeAlias));
        $this->assertSame('ivan_ivanov',$this->faxAliasResolver->resolve('2100'),'Fax Alias resolver should return correct skype alias on existant Skype Alias');
    }
    public function testSkypeAliasResolverReturnsNullOnVInvalidSkypeAlias()
    {
    	$this->mockedSkypeAliasTable->expects($this->once())
    	->method('getSkypeAliasByExten')
    	->with('2100')
    	->will($this->returnValue(null));
    	$this->assertSame(null,$this->faxAliasResolver->resolve('2100'),'Fax Alias resolver should return correct skype alias on existant Skype Alias');
    }
    
}