<?php
namespace Maintainer\Service\BackupRecording;

use Maintainer\Service\BackupRecording\BackupDomDocument;
use Maintainer\Service\BackupRecording\BackupDomDocumentWriterException;
use Maintainer\Service\BackupRecording\BackupDomDocumentWriterInterface;

class BackupDomDocumentWriter implements BackupDomDocumentWriterInterface
{
    protected $outputFormatMethod;
    public function flush($string, $fileName)
    {
        try {
            $metaFile = new \SplFileObject($fileName, 'w');
            if (!isset($metaFile))
            {
                throw new \Exception("Failure to open file $fileName");
            }
            $result = $metaFile->fwrite($string);
            if (!$result)
            {
                throw new \Exception("Failure to write to file $fileName");
            }
            $result = $metaFile->fflush();
            if (!$result)
            {
        	   throw new \Exception("Failure to flush to file $fileName");
            }
            unset($metaFile);
        } catch (\Exception $e)
        {
            throw new BackupDomDocumentWriterException("Failure to write metadata to disk for file $fileName", null, $e);
        }
    }
}