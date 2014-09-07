<?php
namespace Saas\WizardSessionContainer;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class MediaTypeMapperNamingStrategy implements StrategyInterface
{
    protected $mediatypeMapper = array(
        'wtgreeting'=>'greeting',
        'wegreeting'=>'greetingofftime',
        'musiconhold'=>'mohtone',
        'ringingbacktone'=>'ringingtone'
    );
    public function extract($name)
    {
        return (false!==array_search($name, $this->mediatypeMapper))?array_search($name, $this->mediatypeMapper):null;
    }
    public function hydrate($name)
    {   
        return (key_exists($name, $this->mediatypeMapper))?$this->mediatypeMapper[$name]:null;        
    }
}