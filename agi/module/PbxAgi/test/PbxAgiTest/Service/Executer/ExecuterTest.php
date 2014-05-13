<?php
namespace PbxAgiTest\Service\Executer;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Service\Executer\Executer;

class ExecuterTest extends PHPUnit_Framework_TestCase
{
    public function testExecuterExecutesCorrectly()
    {
        $executer = new Executer();
        $this->assertSame('', $executer->exec(':'),'Executer should empty string on column command');
    }
}