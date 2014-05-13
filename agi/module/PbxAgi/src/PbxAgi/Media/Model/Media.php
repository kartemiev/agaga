<?php
namespace PbxAgi\Media\Model;

use PbxAgi\Media\Model\MediaInterface;

class Media implements MediaInterface
{
    public $id;
    public $filename;
    public $mediatype;

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->filename = (isset($data['filename'])) ? $data['filename'] : null;
        $this->mediatype = (isset($data['mediatype'])) ? $data['mediatype'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return the $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     *
     * @return the $mediatype
     */
    public function getMediatype()
    {
        return $this->mediatype;
    }

    /**
     *
     * @param
     *            Ambigous <NULL, unknown> $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param
     *            Ambigous <NULL, unknown> $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     *
     * @param
     *            Ambigous <NULL, unknown> $mediatype
     */
    public function setMediatype($mediatype)
    {
        $this->mediatype = $mediatype;
    }
}
