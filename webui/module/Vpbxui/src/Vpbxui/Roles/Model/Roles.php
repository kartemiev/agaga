<?php
namespace Vpbxui\Roles\Model;

class Roles
{
    public $role_id;
    public $description;
    public function exchangeArray($data)
    {
        $this->role_id     = (isset($data['role_id'])) ? $data['role_id'] : null;        
        $this->description     = (isset($data['description'])) ? $data['description'] : null;
        
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
 }