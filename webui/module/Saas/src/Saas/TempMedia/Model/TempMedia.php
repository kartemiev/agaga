<?php
namespace Saas\TempMedia\Model;

use Zend\InputFilter\Factory as InputFactory;      
use Zend\InputFilter\InputFilter;                  
use Zend\InputFilter\InputFilterAwareInterface; 
use Zend\InputFilter\InputFilterInterface;

class TempMedia implements InputFilterAwareInterface
{
    public  $id;
    public  $vpbxid;
    public  $media;
    public  $custdesc;
    public  $contenttype;
    public  $filesize;
    public  $mediatype;
    public $duration;
    public $extension;
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->vpbxid     = (isset($data['vpbxid'])) ? $data['vpbxid'] : null;
        $this->media     = (isset($data['media'])) ? $data['media'] : null;
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;
        $this->contenttype     = (isset($data['contenttype'])) ? $data['contenttype'] : null;
        $this->filesize     = (isset($data['filesize'])) ? $data['filesize'] : null;
        $this->mediatype     = (isset($data['mediatype'])) ? $data['mediatype'] : null;        
        $this->duration   = (isset($data['duration'])) ? $data['duration'] : null;    
        $this->extension   = (isset($data['extension'])) ? $data['extension'] : null;
        
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
     
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
             
            $dbAdapter = $this->dbAdapter;
    
             
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
             
          		$inputFilter->add($factory->createInput(array(
          		    'name'     => 'media',
          		    'required' => false,
          		    'filters'  => array(
          		        array('name' => 'StripTags'),
          		        array('name' => 'StringTrim'),
          		    ),
          		    'validators' => array(
          		        
          		        array(
          		            'name' => 'NotEmpty',
          		            'options' => array(
          		                'messages' => array(
          		                    \Zend\Validator\NotEmpty::IS_EMPTY => 'Поле не может быть пустым".',
          		                ),
          		            ),
          		        ),
          		    ),
          		)));
          		 
          		 
          		$this->inputFilter = $inputFilter;
        }
         
        return $this->inputFilter;
    }
}