<?php
namespace PbxAgi\Media\Model;

use Zend\Db\TableGateway\TableGateway;
use PbxAgi\Media\Model\Media;

class MediaTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tablegateway)
    {
        $this->tableGateway = $tablegateway;
    }

    public function saveMedia(Media $media)
    {
        $data = array(
            'filename' => $media->filename,
            'mediatype' => $media->mediatype
        );
        $this->tableGateway->insert($data);
    }
}