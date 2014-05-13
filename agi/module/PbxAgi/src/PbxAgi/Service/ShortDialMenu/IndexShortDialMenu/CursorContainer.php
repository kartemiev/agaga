<?php
namespace PbxAgi\Service\ShortDialMenu\IndexShortDialMenu;

use PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainerInterface;

class CursorContainer implements  CursorContainerInterface
{    
    public $id;
	public function getId()
    {
        return $this->id;
    }

	public function setId($id)
    {
        $this->id = $id;
    }    
}