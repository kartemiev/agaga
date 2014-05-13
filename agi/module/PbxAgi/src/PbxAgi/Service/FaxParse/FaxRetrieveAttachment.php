<?php
namespace PbxAgi\Service\FaxParse;

class FaxRetrieveAttachment
{
    protected $attachment;
    
    public function getFaxAttachment($msg)
 	{
 	    if (!isset($this->attachment))
 	    {
 	    	
 		 $mimeParts = $msg->getMimemessage();
 		 $parts = $mimeParts->getParts();
 		 $parts = (is_array($parts))?$parts:array($parts);
 		 foreach ($parts as $part)
 		 {
 		    $parttype = explode(';', strtoupper($part->type));
 		    if (!$parttype || !isset($parttype[0])) continue;
 			if (strtoupper('application/pdf') == $parttype[0])
 			{
 				$faxContent = $part;
 				break;
 			}
 		 }
 		 if (isset($faxContent))
 		 {
 			$this->attachment = $faxContent;
 		 }
 		 $this->attachment = isset($faxContent)?$faxContent:null; 			
 	    }
 	    return $this->attachment;
 	}	
}