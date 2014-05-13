<?php
namespace PbxAgi\Conference\Model;

 
class Conference
{  
    public $id;
    public $custname;
    public $custdesc;
    public $confnumber;
    public $ownertype;
    public $ownerref;
    public $isprotected;
    public $pin;
    public $websecret;      
    public $maxmembers;
    public $memberspresent;
    public $datecreated;
    public $datesettoexpiry;
    public $datefirstentered;
    public $createdfrom;
    public $ispstnallowed;
    public $vpbxnum;
    public $lastentered;
    public $joinacl;
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->custname = (isset($data['custname'])) ? $data['custname'] : null;
        $this->custdesc = (isset($data['custdesc'])) ? $data['custdesc'] : null;
        $this->confnumber = (isset($data['confnumber'])) ? $data['confnumber'] : null;        
        $this->ownertype = (isset($data['ownertype'])) ? $data['ownertype'] : null;
        $this->ownerref = (isset($data['ownerref'])) ? $data['ownerref'] : null;
        $this->isprotected = (isset($data['isprotected'])) ? $data['isprotected'] : null;
        $this->pin = (isset($data['pin'])) ? $data['pin'] : null;
        $this->websecret = (isset($data['websecret'])) ? $data['websecret'] : null;
        $this->maxmembers = (isset($data['maxmembers'])) ? $data['maxmembers'] : null;
        $this->memberspresent = (isset($data['memberspresent'])) ? $data['memberspresent'] : null;
        $this->datecreated = (isset($data['datecreated'])) ? $data['datecreated'] : null;
        $this->datesettoexpiry = (isset($data['datesettoexpiry'])) ? $data['datesettoexpiry'] : null;
        $this->datefirstentered = (isset($data['datefirstentered'])) ? $data['datefirstentered'] : null;
        $this->createdfrom = (isset($data['createdfrom'])) ? $data['createdfrom'] : null;
        $this->ispstnallowed = (isset($data['ispstnallowed'])) ? $data['ispstnallowed'] : null;
        $this->vpbxnum = (isset($data['vpbxnum'])) ? $data['vpbxnum'] : null;     
        $this->lastentered = (isset($data['lastentered'])) ? $data['lastentered'] : null;        
        $this->joinacl = (isset($data['joinacl'])) ? $data['joinacl'] : null;        
    }
    
}
