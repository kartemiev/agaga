<?php
namespace Vpbxui\FeatureTest\Model;

class FeatureTest
{
    public $id;
    public $vpbxid;
    public $test1;
    public $test2;
    public $test3;
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->test1     = (isset($data['test1'])) ? $data['test1'] : null;
        $this->test2     = (isset($data['test2'])) ? $data['test2'] : null;
        $this->test3     = (isset($data['test3'])) ? $data['test3'] : null;
         
    
    }
     
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}