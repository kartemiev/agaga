<?php
namespace MaintainerTest\Controller\RecordingBackup;

use \MaintainerTest\Bootstrap;
use Zend\Mvc\Router\Console\SimpleRouteStack as ConsoleRouter;
use Zend\Console\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase; 
use Maintainer\Controller\RecordingBackupControllerFactory;
use Zend\Db\ResultSet\ResultSet;
use Maintainer\Cdr\Model\Cdr;
use Zend\Db\Sql\Where;

class RecordingBackupControllerTest extends AbstractControllerTestCase
{
    protected $mockedCdrTable;
    protected $mockedBackupDomDocumentWriter;
    protected $mockedBackupRecordingMedia;
    protected $mockedLockHandler;

    public function setUp()
    {     	 
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);  
        
         
        $this->mockedLockHandler = $this->getMockBuilder('Maintainer\Service\LockHandler\LockHandler')
        						  ->disableOriginalConstructor()
        						  ->getMock();
        
        $serviceManager->setService('Maintainer\Service\LockHandler\LockHandler', $this->mockedLockHandler);
        
        $this->mockedCdrTable =  $this->getMockBuilder('Maintainer\Cdr\Model\CdrTable')
        						  ->disableOriginalConstructor()
        						  ->getMock();
        
        $serviceManager->setService('Maintainer\Cdr\Model\CdrTable', $this->mockedCdrTable);

        
        $this->mockedBackupDomDocumentWriter =  $this->getMockBuilder('Maintainer\Service\BackupRecording\BackupDomDocumentWriter')
        						  ->disableOriginalConstructor()
        						  ->getMock();
        
        $serviceManager->setService('Maintainer\Service\BackupRecording\BackupDomDocumentWriter', $this->mockedBackupDomDocumentWriter);
        
        $this->mockedBackupRecordingMedia = $this->getMockBuilder('Maintainer\Service\BackupRecording\BackupRecordingMedia')
        						  ->disableOriginalConstructor()
        						  ->getMock();
        
        $serviceManager->setService('Maintainer\Service\BackupRecording\BackupRecordingMedia', $this->mockedBackupRecordingMedia);
                      
        $recordingBackupControllerFactory = new RecordingBackupControllerFactory();
        $this->controller = $recordingBackupControllerFactory->createService($serviceManager);
        
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'Maintainer\Controller\RecordingBackupController'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = ConsoleRouter::factory($routerConfig);
  
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
        $this->routeMatch->setParam('action', 'Index');
        
     }
    
      
     public function test_backup_recording_controller_can_backup_recordings()
     {

         $mockedCdrTable = $this->mockedCdrTable;
         $mockedCdrTable->expects($this->once())->method('beginTransaction')
                                                ->will($this->returnValue(true));
          
         $filter = new Where();
         $filter->notEqualTo('userfield', '')->and->isNull('backupdate');
         
         
         $cdr = new Cdr();
                
         $cdrData = array(
             'id' => 1804,
             'calldate' => '2013-09-01 04:38:52',
             'clid' => '"501" <501>',
             'src' => '501',
             'dst' => '*70',
             'dcontext' => 'vpbx_dialout',
             'channel' => 'SIP/501-00000002',
             'dstchannel' => '',
             'lastapp' => 'VoiceMailMain',
             'lastdata' => 's1@default',
             'duration' => 5,
             'billsec' => 3,
             'disposition' => 'ANSWERED',
             'accountcode' => '',
             'uniqueid' => '1377995932.2',
             'userfield' => '81ab6a2aeaf7305dda0ef334d5bf8cc4',
             'peeraccount' => '',
             'linkedid' => '1377995932.2',
             'sequence' => 2,
             'transferred_from' => '',
             'amaflags' => null,
             'srcname' => null,
             'dstname' => null,
             'calleridname' => null,
             'operatorstatus' => null,
             'backupdate' => null
            );
         
         $cdr->exchangeArray($cdrData);
         $resultSet = array($cdr);
         
         
         $mockedCdrTable = $this->mockedCdrTable;
         $mockedCdrTable->expects($this->once())->method('fetchAll')
                                                ->with($filter,'calldate ASC')
                                                ->will($this->returnValue($resultSet));
         
         
        $mockedBackupDomDocumentWriter = $this->mockedBackupDomDocumentWriter;

        
        
        
        $xmlString = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<root><id>1804</id><calldate>2013-09-01 04:38:52</calldate><clid>\"501\" &lt;501&gt;</clid><src>501</src><dst>*70</dst><dcontext>vpbx_dialout</dcontext><channel>SIP/501-00000002</channel><lastapp>VoiceMailMain</lastapp><lastdata>s1@default</lastdata><duration>5</duration><billsec>3</billsec><disposition>ANSWERED</disposition><uniqueid>1377995932.2</uniqueid><userfield>81ab6a2aeaf7305dda0ef334d5bf8cc4</userfield><linkedid>1377995932.2</linkedid><sequence>2</sequence></root>\n";
         $fileName = '/backup/asterisk/recordings/81ab6a2aeaf7305dda0ef334d5bf8cc4.xml';
        
        $mockedBackupDomDocumentWriter->expects($this->once())->method('flush')
                       ->with($this->equalTo($xmlString),$this->equalTo($fileName))
                       ->will($this->returnValue($resultSet));
        
        $mockedBackupRecordingMedia = $this->mockedBackupRecordingMedia;
        $mockedBackupRecordingMedia->expects($this->once())->method('doCopy')
                                   ->with($this->equalTo('81ab6a2aeaf7305dda0ef334d5bf8cc4'))
                                   ->will($this->returnValue(true));
        
        $mockedCdrTable->expects($this->once())->method('updateBackupDateOnly')
                       ->with($this->equalTo($cdr->id));
          
        $mockedCdrTable->expects($this->once())->method('commit');
        
        $mockedLockHandler = $this->mockedLockHandler;
      	$mockedLockHandler->expects($this->any())->method('isLocked')
      					->will($this->returnValue(false));
      	
      	$mockedLockHandler->expects($this->once())->method('closeLock');
       	 
      	
      	$result   = $this->controller->dispatch($this->request);
     	$response = $this->controller->getResponse();
      }
      
    
}