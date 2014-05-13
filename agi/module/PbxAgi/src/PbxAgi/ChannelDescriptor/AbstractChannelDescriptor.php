<?php
namespace PbxAgi\ChannelDescriptor;

abstract class AbstractChannelDescriptor
{
    public $technology;
    public $uniqueid;
	/**
     * @return the $technology
     */
    public function getTechnology()
    {
        return $this->technology;
    }

	/**
     * @return the $extension
     */
    

	/**
     * @return the $uniqueid
     */
    public function getUniqueid()
    {
        return $this->uniqueid;
    }

	/**
     * @param field_type $technology
     */
    public function setTechnology($technology)
    {
        $this->technology = $technology;
    }

	 
	/**
     * @param field_type $uniqueid
     */
    public function setUniqueid($uniqueid)
    {
        $this->uniqueid = $uniqueid;
    }

}