<?php
namespace Maintainer\Service\BackupRecording;

use Maintainer\Service\BackupRecording\BackupDomDocumentDomFailureException;
use Maintainer\Service\BackupRecording\BackupDomDocumentInterface;

class BackupDomDocument implements BackupDomDocumentInterface
{
    public function assemble($data)
    {        
       try
       {
       $dom = new \DOMDocument('1.0', 'utf-8');
       $rootElement = $dom->appendChild(new \DOMElement('root'));
       foreach ($data as $key=>$value)
       {
        if (null == $value) 
        {
            continue;
        }
        $propertyElement = new \DOMElement($key, $value);
        $rootElement->appendChild($propertyElement);
       }
       $xmlString = $dom->saveXML();
       } catch (\Exception $e)
       {
           throw new BackupDomDocumentDomFailureException('Failed to create DOM object', null, $e);
       }
       return $xmlString;      
    }    
}