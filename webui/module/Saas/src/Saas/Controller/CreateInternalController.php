<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
class CreateInternalController extends AbstractActionController
{
	public function indexAction()
	{
 		return new ViewModel();
	}
	public function fetchAction() //JSON
	{
		$request  = $this->getRequest();
		
		if ($request->isPost())
		{
			$data = \Zend\Json\Json::decode($request->getContent(),\Zend\Json\Json::TYPE_ARRAY);
						
			$taken = (isset($data['taken']))?$data['taken']:array();
			$q = (isset($data['q']))?$data['q']:'';
							
			$numbers = array();
			foreach ($data['allowednums'] as $allowednum)
			{
				$start = (int)$allowednum['value'];
					
				$counter = $start;
				for ($counter; $counter<=$start+99; $counter++)
				{
				if (in_array((string)$counter,$taken))
				{
					continue;
				}
					if ((''==$q) || (strpos((string)$counter,$q)===0))
					{
						$number = array('id'=>(string)$counter,'text'=>(string)$counter);
						$numbers[] = $number;
					}
				}
				}
										
				$data = array('results'=>$numbers);
				return new JsonModel($data);
		}
		
	}
}