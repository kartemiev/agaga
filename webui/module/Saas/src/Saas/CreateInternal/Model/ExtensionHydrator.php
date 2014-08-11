<?php
namespace Saas\CreateInternal\Model;

use Zend\Stdlib\Hydrator\AbstractHydrator;
class ExtensionHydrator extends AbstractHydrator
{
	public function hydrate(array $data, $object)
	{
		
		if (preg_match("/^\[(\d{3})\] (.+)$/", $data['custname'], $matches))
		{
			$object->custname = $matches[2];
		}
 
		$object->extension = $data['extension'];
	}
	public function extract($object)
	{
		$data = array(
			'id'=>(string)$object->extension,
			'text'=>'['.$object->extension.'] '.$object->custname
		);
		return $data;
	}
}