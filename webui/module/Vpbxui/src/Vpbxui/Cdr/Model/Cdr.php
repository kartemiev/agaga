<?php
namespace Vpbxui\Cdr\Model;
 
class Cdr
{             
    public $id;
    public $calldate;
    public $clid;
    public $src;
    public $dst;
    public $dcontext;
    public $channel;
    public $dstchannel;
    public $lastapp;
    public $lastdata;
    public $duration;
    public $billsec;
    public $disposition;
    public $accountcode;
    public $uniqueid;
    public $userfield;
    public $peeraccount;
    public $linkedid;
    public $sequence;
    public $transferred_from;
    public $amaflags;
    public $test;
    public $srcname;
    public $dstname;
    public $calleridname;
    public $operatorstatus;
    public $backupdate;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->calldate     = (isset($data['calldate'])) ? $data['calldate'] : null;
        $this->clid     = (isset($data['clid'])) ? $data['clid'] : null;
        $this->src     = (isset($data['src'])) ? $data['src'] : null;
        $this->dst     = (isset($data['dst'])) ? $data['dst'] : null;
        $this->dcontext     = (isset($data['dcontext'])) ? $data['dcontext'] : null;
        $this->channel     = (isset($data['channel'])) ? $data['channel'] : null;
        $this->dstchannel     = (isset($data['dstchannel'])) ? $data['dstchannel'] : null;
        $this->lastapp     = (isset($data['lastapp'])) ? $data['lastapp'] : null;
        $this->lastdata     = (isset($data['lastdata'])) ? $data['lastdata'] : null;
        $this->duration     = (isset($data['duration'])) ? $data['duration'] : null;
        $this->billsec     = (isset($data['billsec'])) ? $data['billsec'] : null;
        $this->disposition     = (isset($data['disposition'])) ? $data['disposition'] : null;
        $this->accountcode     = (isset($data['accountcode'])) ? $data['accountcode'] : null;
        $this->uniqueid     = (isset($data['uniqueid'])) ? $data['uniqueid'] : null;
        $this->userfield     = (isset($data['userfield'])) ? $data['userfield'] : null;
        $this->peeraccount     = (isset($data['peeraccount'])) ? $data['peeraccount'] : null;
        $this->linkedid     = (isset($data['linkedid'])) ? $data['linkedid'] : null;
        $this->sequence     = (isset($data['sequence'])) ? $data['sequence'] : null;
        $this->transferred_from     = (isset($data['transferred_from'])) ? $data['transferred_from'] : null;
        $this->amaflags     = (isset($data['amaflags'])) ? $data['amaflags'] : null;
        $this->test     = (isset($data['test'])) ? $data['test'] : null;
        
        $this->srcname     = (isset($data['srcname'])) ? $data['srcname'] : null;
        $this->dstname     = (isset($data['dstname'])) ? $data['dstname'] : null;
        $this->calleridname     = (isset($data['calleridname'])) ? $data['calleridname'] : null;
        $this->operatorstatus     = (isset($data['operatorstatus'])) ? $data['operatorstatus'] : null;
        $this->backupdate     = (isset($data['backupdate'])) ? $data['backupdate'] : null;
    }
     
     public function getArrayCopy()
     {
     	return get_object_vars($this);
     }

  }
