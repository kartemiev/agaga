<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController; 
use PbxAgi\Service\AppConfig\AppConfigInterface;

class RecordCallController extends AbstractActionController 
{
    protected $agi; 
    protected $appConfig;
    protected $mediaFileName;
 
    public function __construct(
     $agi, 
       AppConfigInterface $appConfig      
        ) {
        $this->agi = $agi;
        $this->appConfig = $appConfig;
    }
    public function indexAction() {
             $this->setMonitorOnChannel();
    }
      public function updateCDR()
    {
             if ('ANSWER' == $this->agi->getVariable('DIALSTATUS'))
            {             
                $this->agi->exec('Set',array('CDR(recordedname)='.$this->mediaFileName)); 
            }
            return true;
    }
    
    protected function setMonitorOnChannel()
    {
        $appconfig = $this->appConfig;
        
        $mediaExtension = $appconfig->getCallRecordFileExtension();
        
         $mediaFilename = $this->agi->getVariable('RECORD_FILENAME');
        
        if (isset($mediaFilename)&&(''==!$mediaFilename))
        {
            $this->mediaFileName = $mediaFilename;
            $tmpDir = $appconfig->getTmpDir();
            $tmpName = "{$tmpDir}/{$mediaFilename}".'.'.$mediaExtension;
             
            $postRecordCommand = $appconfig->getPostRecordCommand();
            if ($postRecordCommand) {          
                $postRecordCommand = sprintf($postRecordCommand, $tmpName, $mediaFilename);
            }
            $cdrfacade = $this->agi->getCDR();
            $this->agi->exec('Set',array('CDR(recordedname)='.$mediaFilename)); 

            $cdrfacade->setCustom('recordedname', $mediaFilename);
            $this->agi->exec('MixMonitor', array(
                $tmpName,'',
                $postRecordCommand . " && rm {$tmpName}"
            ));
         //   $this->agi->exec('Set',array('AUDIOHOOK_INHERIT(MixMonitor)=yes'));
        }
    }
     
}
