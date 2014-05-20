<?php
namespace Maintainer\Service\BackupRecording;

interface BackupDomDocumentWriterInterface
{
    function flush($string, $fileName);
}
