<?php
namespace PbxAgi\Controller\Plugin;

use PbxAgi\Service\ClientImpl\ClientImplInterface;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mvc\Controller\Plugin\PluginInterface;

class RecordCallControllerPlugin extends AbstractPlugin implements PluginInterface
{
    protected $agi; 
    protected $appConfig;
    protected $uniqueRecordingId;
    protected $mediaFileName;
    public function __construct($agi, AppConfigInterface $appConfig) {
        $this->agi = $agi;
        $this->appConfig = $appConfig;
    }
    public function updateCDR(){
        
    if ($this->agi->getVariable('HANGUPCAUSE')=='16')
       {             
        $mediaFilename = $this->agi->getVariable('RECORD_FILENAME');
        $this->agi->exec('Set',array('CDR(recordedname)='.$mediaFilename)); 
       }
    }    
}
