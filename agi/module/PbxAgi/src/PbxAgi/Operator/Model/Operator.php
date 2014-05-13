<?php
namespace PbxAgi\Operator\Model;

use PbxAgi\Operator\Model\OperatorInterface;

class Operator implements OperatorInterface
{

    public $id;
    public $extension;
    public $extensiontype;
    public $name;
    public $operatorstatus;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getExtension() {
        return $this->extension;
    }

    public function setExtension($extension) {
        $this->extension = $extension;
    }

    public function getExtensiontype() {
        return $this->extensiontype;
    }

    public function setExtensiontype($extensiontype) {
        $this->extensiontype = $extensiontype;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getOperatorstatus() {
        return $this->operatorstatus;
    }

    public function setOperatorstatus($operatorstatus) {
        $this->operatorstatus = $operatorstatus;
    }

        public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->extension = (isset($data['extension'])) ? $data['extension'] : null;
        $this->extensiontype = (isset($data['extensiontype'])) ? $data['extensiontype'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->operatorstatus = (isset($data['operatorstatus'])) ? $data['operatorstatus'] : null;
        
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
 
