<?php
namespace PbxAgi\FaxSpool\Model;

class FaxSpool
{ 
    public $id;
    public $recordtype;
    public $uniqueid;
    public $faxstatus;
    public $pages;    
    public function exchangeArray($data)
    {
        $this->uniqueid = (isset($data['uniqueid']))?$data['uniqueid']:null;        
         $this->recordtype = (isset($data['recordtype']))?$data['recordtype']:null;
          $this->faxstatus = (isset($data['faxstatus']))?$data['faxstatus']:null;
         $this->pages = (isset($data['pages']))?$data['pages']:null;          
    }

 public function getId() {
  return $this->id;
 }
 
 public function setId($id) {
  $this->id = $id;
  return $this;
 }
 
 public function getRecordtype() {
  return $this->recordtype;
 }
 
 public function setRecordtype($recordtype) {
  $this->recordtype = $recordtype;
  return $this;
 }
 
 public function getUniqueid() {
  return $this->uniqueid;
 }
 
 public function setUniqueid($uniqueid) {
  $this->uniqueid = $uniqueid;
  return $this;
 }
 
 public function getFaxstatus() {
  return $this->faxstatus;
 }
 
 public function setFaxstatus($faxstatus) {
  $this->faxstatus = $faxstatus;
  return $this;
 }
 
 public function getPages() {
  return $this->pages;
 }
 
 public function setPages($pages) {
  $this->pages = $pages;
  return $this;
 }
 
    
 }
