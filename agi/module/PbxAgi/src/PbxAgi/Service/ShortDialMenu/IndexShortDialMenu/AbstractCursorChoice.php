<?php
namespace PbxAgi\Service\ShortDialMenu\IndexShortDialMenu;

use PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\AbstractCursorChoiceInterface;
use Zend\Db\Sql\Select;
use PAGI\Node\Node;

abstract class AbstractCursorChoice implements AbstractCursorChoiceInterface
{
    protected $cursorContainer;
    protected $agi;
    protected $appConfig;
    protected $shortDialTable;
    protected $playCurrentItem;
    protected $nodeController;
    protected $call;
    
    public function __invoke(Node $node)
    {
         if ($this->validate())
        {
            $this->iterate();
        }
        call_user_func($this->playCurrentItem);        
    }
    protected function validate()
    {
         $cursorContainer = $this->cursorContainer;   
        $id = $cursorContainer->getId();        
        if (!$id)
        {
            $shortDial = $this->getFirstItemForContainer();
            if (!$shortDial)
            {
                $this->agi->streamFile($this->appConfig->getShortDialListIsEmpty());
                $this->nodeController->jumpTo('indexMenu');
            }
            $shortDial = $shortDial->current();
            $cursorContainer->setId($shortDial->id);
        }
         return ($id)?true:false;
    }
    abstract protected function getFilter();
    protected function iterate()
    {
       
             $shortDial = $this->shortDialTable->fetchAll($this->getFilter()); 
             if (0==$shortDial->count())
            {
                $this->agi->streamFile($this->getIteratorFailedMedia());
                $this->nodeController->jumpTo('indexMenu');
            }
            $shortDialRow = $shortDial->current();
            $this->cursorContainer->setId($shortDialRow->id);
     }
    protected function getFirstItemForContainer()
    {
        $peerId = $this->call->getCallOwner()->getId();
        $select = new Select();
        $select->where('id>0');
        $select->where(array('peerid' => $peerId));
        $select->limit(1);
        $shortDial = $this->shortDialTable->fetchAll($select);
        return $shortDial;
    }
    
	public function getCursorContainer()
    {
        return $this->cursorContainer;
    }

	public function getAgi()
    {
        return $this->agi;
    }

	public function getAppConfig()
    {
        return $this->appConfig;
    }

	public function getShortDialTable()
    {
        return $this->shortDialTable;
    }

	public function setCursorContainer($cursorContainer)
    {
        $this->cursorContainer = $cursorContainer;
    }

	public function setAgi($agi)
    {
        $this->agi = $agi;
    }

	public function setAppConfig($appConfig)
    {
        $this->appConfig = $appConfig;
    }

	public function setShortDialTable($shortDialTable)
    {
        $this->shortDialTable = $shortDialTable;
    }
	public function getPlayCurrentItem()
    {
        return $this->playCurrentItem;
    }

	public function setPlayCurrentItem($playCurrentItem)
    {
        $this->playCurrentItem = $playCurrentItem;
    }
	public function getNodeController()
    {
        return $this->nodeController;
    }

	public function setNodeController($nodeController)
    {
        $this->nodeController = $nodeController;
    }
	public function getCall()
    {
        return $this->call;
    }

	public function setCall($call)
    {
        $this->call = $call;
    }
    
}