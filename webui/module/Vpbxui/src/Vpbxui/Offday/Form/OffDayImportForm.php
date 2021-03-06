<?php
namespace Vpbxui\Offday\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class OffdayImportForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('offdays-file');
        $file->setLabel('Загрузка файла замены/праздничных дней')
        ->setAttribute('id', 'offdays-file');
        $this->add($file);
    }
}