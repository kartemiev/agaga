<?php
namespace PbxAgi\Service\RecordCall;

use PAGI\Client\IClient;
use PbxAgi\Media\Model\MediaInterface;
use PbxAgi\Media\Model\Media;
use PbxAgi\Service\ClientImpl\ClientImplInterface as CInterface;
use PbxAgi\AppConfig\Service\AppConfigInterface;
use PbxAgi\Service\RecordCall\RecordCallServiceInterface;
use PbxAgi\Cdr\Model\CdrTableInterface;

class RecordCallService implements RecordCallServiceInterface
{
    protected $clientImpl;
    protected $fileName;
    protected $appConfig;
    protected $recordCallService;
    protected $cdrTable;

    public function __construct(
    		IClient $client, 
    		AppConfigInterface $appConfig, 
    		RecordCallServiceInterface $recordCallService, 
    		CdrTableInterface $cdrTable
			)
    {
        $this->appConfig = $appConfig;
        $this->clientImpl = $client;
        $this->cdrTable = $cdrTable;
    }

    public function setMonitorOnChannel()
    {
        $appconfig = $this->getAppConfig();
        $client = $this->getClientImpl();
        
        $mediaExtension = $appconfig->getCallRecordFileExtension();
        $mediaFileName = $this->getUniqueRecordingId();
        
        $tmpDir = $appconfig->getTmpDir();
        $tmpName = "{$tmpDir}/{$mediaFileName}.${$mediaExtension}";
        $this->setFileName($mediaFileName);
        
        $postRecordCommand = $appconfig->getPostRecordCommand();
        if ($postRecordCommand) {
            $postRecordCommand = str_replace(array(
                '&',
                '|'
            ), '', $postRecordCommand);
            $postRecordCommand = sprintf($postRecordCommand, $tmpName, $mediaFileName);
        }
        $cdrfacade = $client->CDRFacade();
        $cdrfacade->setCustom('recorded_call_ref', $mediaFileName);
        $client->exec('MixMonitor', array(
            $tmpName,
            CInterface::MONITOR_OPTION_RECORD_WHEN_BRIDGED,
            $postRecordCommand . " && rm {$tmpName}"
        ));
    }

    public function saveMonitored()
    { // intended to push into the persistance layer
        $this->saveMedia();
        $this->updateCDR();
    }

    protected function getUniqueRecordingId()
    {
        $client = $this->getClientImpl();
        return $client->getVariable('UNIQUEID');
    }

    protected function saveMedia()
    {
        $mediareposdir = $this->getMediaReposDir();
        $media = new Media();
        $fileName = $this->getFileName();
        $media->setFilename($media);
        $media->setMediatype(MediaInterface::VPBX_MEDIATYPE_CALLRECORDING);
        $this->getMediaTable()->saveMedia($media);
    }

    protected function updateCDR()
    {
        // todo
    }

    public function getClientImpl()
    {
        return $this->clientImpl;
    }

    public function setClientImpl($clientImpl)
    {
        $this->clientImpl = $clientImpl;
        return $this;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getAppConfig()
    {
        return $this->appConfig;
    }

    public function setAppConfig($appConfig)
    {
        $this->appConfig = $appConfig;
        return $this;
    }
    public function getTotalRecordedSize()
    {
    		
    }
}
