<?php 
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Saas\WizardSessionContainer\WizardSessionContainer;
use Saas\TempMedia\Model\TempMediaTableInterface;
use Zend\Http\Response;
use Saas\Service\AppConfig\AppConfigInterface;

class PlayTmpMediaController extends AbstractActionController
{
    protected $wizardSessionContainer;
    protected $tempMediaTable;    
    protected $appConfigService;
    public function __construct(WizardSessionContainer $wizardSessionContainer, TempMediaTableInterface $tempMediaTable, AppConfigInterface $appConfigService)
    {
        $this->wizardSessionContainer = $wizardSessionContainer;
        $this->tempMediaTable = $tempMediaTable;
        $this->appConfigService = $appConfigService;
    }
    public function playAction()
    {
        $id = $this->params('id');
        
        $tempMedia = $this->tempMediaTable->getTempMediaById($id);

        if (!$tempMedia)
        {
            $response = $this->getResponse();
            $response->setStatusCode(Response::STATUS_CODE_404);
            return $response;
        }
        
        $accesslevel = $tempMedia->accesslevel;
        if ('session'==$accesslevel)
        {
            $wizardSessionContainer = $this->wizardSessionContainer;
            if (!$wizardSessionContainer)
            {
                $response = $this->getResponse();
                $response->setStatusCode(Response::STATUS_CODE_404);
                return $response;
            }
            if (!$wizardSessionContainer->media)
            {
                $response = $this->getResponse();
                $response->setStatusCode(Response::STATUS_CODE_404);
                return $response;
            }
            $media = $wizardSessionContainer->media;
            $found = false;
            foreach ($media as $entry)
            {
                if ($id==$entry->id)
                {
                    $found = true;
                    break;
                }
            }
            if (!$found)
            {
                $response = $this->getResponse();
                $response->setStatusCode(Response::STATUS_CODE_404);
                return $response;
            }            
        }
        elseif ('global'!==$accesslevel)
        {
            $response = $this->getResponse();
            $response->setStatusCode(Response::STATUS_CODE_404);
            return $response;            
        };
        $filename = $this->appConfigService->getTempMediaPath().'/'.$tempMedia->id;
        $fh = fopen($filename, 'rb');
        header('Content-type: audio/mpeg');
        header("Content-Length: " . filesize($filename));
        fpassthru($fh);
        exit;
        
    }
}

