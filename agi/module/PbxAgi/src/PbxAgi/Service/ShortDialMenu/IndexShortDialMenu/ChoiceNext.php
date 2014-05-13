<?php
namespace PbxAgi\Service\ShortDialMenu\IndexShortDialMenu;

use PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\AbstractCursorChoice;
use Zend\Db\Sql\Where;

class ChoiceNext extends AbstractCursorChoice
{    
    protected function getFilter()
    {
        $peerid = $this->call->getCallOwner()->getId();        
        $id = $this->cursorContainer->getId();        
        $where = new Where();
        $where->equalTo('peerid', $peerid)->and->greaterThan('id', $id);                 
        return  $where;    
    }
    protected function getIteratorFailedMedia()
    {
        return $this->appConfig->getShortDialListLastItemReached();
    }
}