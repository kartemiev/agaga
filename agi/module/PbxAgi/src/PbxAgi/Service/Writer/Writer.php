<?php
namespace PbxAgi\Service\Writer;

use PbxAgi\Service\Writer\WriterInterface;

class Writer implements WriterInterface
{
    public function writeStream($path,$content)
    {
    	$fh = fopen($path,'w');
    	fwrite($fh,$content);
    	fclose();
    }
}