<?php
namespace PbxAgi\ShortDial\Model;

class ShortDial
{
    public $id;
    public $peerid;
    public $number;
    public $short;
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id']))?$data['id']:null;         
        $this->peerid = (isset($data['peerid']))?$data['peerid']:null;
        $this->number = (isset($data['number']))?$data['number']:null;        
        $this->short =  (isset($data['short']))?$data['short']:null; 
    }
}