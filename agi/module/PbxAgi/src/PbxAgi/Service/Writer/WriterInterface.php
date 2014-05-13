<?php
namespace PbxAgi\Service\Writer;

interface WriterInterface
{
	function writeStream($path, $content);	
}