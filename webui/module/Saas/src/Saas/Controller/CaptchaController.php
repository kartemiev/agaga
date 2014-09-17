<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class CaptchaController extends AbstractActionController
{
    public function generateAction()
    {
        $response = $this->getResponse();
        $this->getResponse()->getHeaders()->addHeaderLine('Content-Type', "image/png");
        
        $id = $this->params('id', false);
        
        if ($id) {
        
            $image = './data/captcha/' . $id;
        
            if (file_exists($image) !== false) {
                $imagegetcontent = @file_get_contents($image);
        
                $response->setStatusCode(200);
                $response->setContent($imagegetcontent);
        
                if (file_exists($image) == true) {
                    unlink($image);
                }
            }
        
        }        
        return $response;
    }
    
}