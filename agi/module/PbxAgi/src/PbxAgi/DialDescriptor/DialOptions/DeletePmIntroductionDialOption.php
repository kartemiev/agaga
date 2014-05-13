<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOptionParametrizedOptional;
use PbxAgi\DialDescriptor\DialOptions\DeletePmIntroductionDialOptionInterface;
 
class DeletePmIntroductionDialOption extends AbstractDialOptionParametrizedOptional 
implements DeletePmIntroductionDialOptionInterface
{
    protected $delete;
    
    const IDENTIFIER = 'n';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
    
    protected function getValue()
    {
        return $this->delete;
    }
	public function getDelete()
    {
        return $this->delete;
    }

	public function setDelete($delete)
    {
        $this->delete = $delete;
    }
    
}