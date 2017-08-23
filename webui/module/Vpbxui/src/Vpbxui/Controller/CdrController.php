<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\View\Model\JsonModel;
use Zend\Db\Sql\Predicate\Like;
use Vpbxui\Cdr\Form\CdrSearchForm;
use Vpbxui\Cdr\Model\Filter;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;
use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

class CdrController extends AbstractActionController {
    
    protected $cdrTable;
    
    public function indexAction()
    {
       $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 99999999;
       $itemsPerPage = 20;
        
       $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'calldate';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
		$filters = $this->params()->fromQuery('filters');
        $orderseq = $order_by . ' ' . $order;
        $select = new Select();
        $select->order($order_by . ' ' . $order);
        $like_by = $this->params()->fromRoute('like_by');
        $like = $this->params()->fromRoute('like');
        
         
        $orderseq = $order_by . ' ' . $order;
      
        $scope = $this->params()->fromQuery('scope');
        $scope = (isset($scope))?$scope: 'integral';
        $filter = new Where();
        $this->filterAddScope($filter,$select, $scope);
        
        if ($like_by&&$like){
            $adapter = $this->getCdrTable()->getTableGateway()->getAdapter();
            if ('calldate'==$like_by)
            {
                $filter->expression("to_char(calldate,'DD-MM-YYYY')::text LIKE ". $adapter->platform->quoteValue(preg_quote($like."%")));
            }
            else 
            {
                $filter->expression(($adapter->platform->quoteIdentifier($like_by)."::text LIKE ". $adapter->platform->quoteValue(preg_quote("%".$like."%"))));                
            }
        }        
        
        $filter->and->notEqualTo('dcontext', 'dialsipexten');
		        
        
        $this->addSearchFilters($filter,$filters, $itemsPerPage);
        
        $cdrs =  $this->getCdrTable()->fetchAll($select, $filter,$orderseq);      
        $paginator = new Paginator(new paginatorIterator($cdrs));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(10);
 
        $this->getServiceLocator()
    		 ->get('viewhelpermanager')
    		 ->get('HeadScript')
             ->appendFile('/js/jquery.jplayer.min.js')
             ->appendFile('/js/cdr.js')
;
        
        $find = $this->forward()->dispatch(implode('\\',array(__NAMESPACE__,'Cdr')),array('action'=>'find'));
         return new ViewModel(array(
             'cdrs' => $cdrs,
                    'page' => $page,
                    'paginator' => $paginator,
                	'order_by' => $order_by,
                    'order' => $order,
                    'scope'=> $scope,
                    'like_by'=>$like_by,
                    'like'=> $like,
         			'filters'=>$filters,
         			'find'=>$find
        ));
     }
     
	 public function findAction()
	 {
  	 		$form = new CdrSearchForm();
	 		$request = $this->getRequest();	 		
	 		if ($request->isPost()) {
 	 			$form->setData($request->getPost());
 	 			$filter = new Filter();
	 			$form->setInputFilter($filter->getInputFilter());
	 			if ($form->isValid()) {
 	 				$filter->exchangeArray($form->getData());
  	 				$request->setQuery(new Parameters(array('1'=>'333')));
 	 				$data = $filter->getArrayCopy();
 	 				unset($data['inputFilter']);
				 
     	 				return $this->redirect() 
	 					 ->toRoute('vpbxui/cdr',array(),
	 					 		array(
	 					 				'query'=>array('filters'=>array($data)),
	 					 				false
	 							)
	 				);
	 			}
	 		}
	 		$this
	 		->getServiceLocator()
	 		->get('viewhelpermanager')
	 		->get('HeadScript')
 	 		->appendFile('/js/select2.custom.js')
	 		;
	 		return array(
	 				'form' => $form,
	 		);
	 }
     public function searchAction()
     {
         $like = $this->params()->fromQuery('q');
         $page = $this->params()->fromQuery('page');
         $limit = $this->params()->fromQuery('page_limit');
         
         $offset = ($page-1)*$limit;
         $sql = "SELECT DISTINCT(to_char(calldate,'DD-MM-YYYY')) AS calldate FROM cdr WHERE to_char(calldate,'DD-MM-YYYY') LIKE ? ORDER BY calldate DESC";                
         $adapter = $this->getCdrTable()->getTableGateway()->getAdapter(); 
          $dateresult = $adapter->query($sql, array(preg_quote($like)."%"));

             
           $total = $dateresult->count();
         $dates = array();
         foreach ($dateresult as $date)
         {
             $obj = new \stdClass();
             $obj->id = (string)$date->calldate;
             $obj->text = " ".(string)$date->calldate." ";
             $dates[] = $obj;
             $obj = null;
         }
         $viewmodel  = new JsonModel(             
             array('total'=>$total,'results'=>$dates)
         );
         $viewmodel->setJsonpCallback($this->params()->fromQuery('callback'));
         
         return  $viewmodel;
     }

     public function getFetchSqlMap()
     {
         return array(
             'startdate'=>array(
             	'sqlfetch'=>"SELECT DISTINCT(to_char(calldate,'DD-MM-YY HH24:MI')) AS calldate FROM cdr WHERE to_char(calldate,'DD-MM-YY HH24:MI') LIKE ? ORDER BY calldate ASC OFFSET ? LIMIT ?",
             	'sqlcount'=>"SELECT COUNT(calldate) FROM (SELECT DISTINCT(to_char(calldate,'DD-MM-YY HH24:MI')) AS calldate FROM cdr WHERE to_char(calldate,'DD-MM-YY HH24:MI') LIKE ?) p",             		 
             	'adapter'=>	$this->getCdrTable()->getTableGateway()->getAdapter(),
             	'predicate'	=> 'greaterThanOrEqualTo',
             	'idformatspec'=>array(
             			'pattern'=>'/^(\d\d)-(\d\d)-(\d\d) (\d\d):(\d\d)$/',
             			'replacement'=>'20$3-$2-$1 $4:$5:00'
             ),
             	'fieldname'=>'calldate'
         	 ),
         	'enddate'=>array(
                'sqlfetch'=>"SELECT DISTINCT(to_char(calldate,'DD-MM-YY HH24:MI')) AS calldate FROM cdr WHERE to_char(calldate,'DD-MM-YY HH24:MI') LIKE ? ORDER BY calldate DESC OFFSET ? LIMIT ?",
         		'sqlcount'=>"SELECT COUNT(calldate) FROM (SELECT DISTINCT(to_char(calldate,'DD-MM-YY HH24:MI')) AS calldate FROM cdr WHERE to_char(calldate,'DD-MM-YY HH24:MI') LIKE ?) p",         			
         		'adapter'=>	$this->getCdrTable()->getTableGateway()->getAdapter(),
         		'predicate'	=> 'lessThanOrEqualTo',
         			'idformatspec'=>array(
         					'pattern'=>'/^(\d\d)-(\d\d)-(\d\d) (\d\d):(\d\d)$/',
         					'replacement'=>'20$3-$2-$1 $4:$5:59'
         			),
             	'fieldname'=>'calldate'         			
             ),	
         	'calldest'=>array(
         		'sqlfetch'=> "SELECT src FROM (SELECT src FROM cdr UNION SELECT dst AS src FROM cdr) p WHERE src LIKE ? ORDER BY src ASC OFFSET ? LIMIT ?",
         		'sqlcount'=>"SELECT COUNT(src) FROM (SELECT src FROM cdr UNION SELECT dst AS src FROM cdr)",
         		'adapter'=>	$this->getCdrTable()->getTableGateway()->getAdapter(),
         		'predicate'	=> 'equalTo',         			
         		'fieldname'=>'src',
         		'fieldset'=>array('src','dst')
         		),
         	'callerid'=>array(
         		'sqlfetch'=> "SELECT DISTINCT(clid) FROM cdr  WHERE clid LIKE ? ORDER BY clid ASC OFFSET ? LIMIT ?",
         		'sqlcount'=>"SELECT COUNT(clid) FROM (SELECT DISTINCT(clid) FROM cdr)",
         		'adapter'=>	$this->getCdrTable()->getTableGateway()->getAdapter(),
         		'predicate'	=> 'equalTo',         			
         		'fieldname'=>'clid'
         		)
         );
     }
     public function fetchAction()
     {
     	$like = $this->params()->fromQuery('q');
     	$page = $this->params()->fromQuery('page');
     	$limit = $this->params()->fromQuery('page_limit');
     	$field = $this->params()->fromQuery('field');
     	
     	$offset = ($page-1)*$limit;
     	
     	$map = $this->getFetchSqlMap();
     	
     	if (!isset($map[$field]))
     	{
     	    throw new \Exception('Invalid field requested');
     	}
     	
     	$options =  $map[$field];
     	
     	$sql = $options['sqlfetch'];
     	$adapter = $options['adapter'];
     	$resultset = $adapter->query($sql, array('%'.preg_quote($like)."%",($page-1)*$limit,$limit));
     	$fieldname = $options['fieldname'];
     	 
     	$sql = $options['sqlcount'];
     	$totalset = $adapter->query($sql, array('%'.preg_quote($like)."%"));     	
     	     	
     	$total = $totalset->current()->count;     	
     	$results = array();
     	foreach ($resultset as $row)
     	{
     		$obj = new \stdClass();
     		
      		$id = (isset($options['idformatspec']))?
     		preg_replace($options['idformatspec']['pattern'],$options['idformatspec']['replacement'],(string)$row->$fieldname)
     		:
     		(string)$row->$fieldname;
     		$obj->id = $id;
     		$obj->text = str_pad(" ".(string)$row->$fieldname." ",20);
     		$results[] = $obj;
     		$obj = null;
     	}
     	$viewmodel  = new JsonModel(
     			array('total'=>$total,'results'=>$results)
     	);
     	$viewmodel->setJsonpCallback($this->params()->fromQuery('callback'));
     	 
     	return  $viewmodel;
     }
     
     public function playAction()
     {
         $id = $this->params('id');        
         $cdr =  $this->getCdrTable()->getCdr($id);
         $filename = '/var/spool/asterisk/mediarepos/'.$cdr->recordedname.'.mp3';
         $fh = fopen($filename, 'rb'); 
         header('Content-type: audio/mpeg'); 
         header("Content-Length: " . filesize($filename));
         fpassthru($fh); 
        exit; 
      }
         
     public function getCdrTable() {
     	if (!$this->cdrTable) {
     		$sm = $this->getServiceLocator();
     		$this->cdrTable = $sm->get('Vpbxui\Cdr\Model\CdrTable');
     	}
     	return $this->cdrTable;
     }
     
     protected function filterAddScope(Where $filter, Select $select, $scope)
     {
         
         $scopeFiltersPgSql = array(
             'thishour' => "date_trunc('hour',now())",
             'today' => "date_trunc('day',now())",
             '24hours' => "now()- interval '24 hours'",
             'thismonth' => "date_trunc('month',now())",
             'past30days' => "now()- interval '30 days'"
         );
         
         if (isset($scopeFiltersPgSql[$scope])){
             $filter->expression('calldate>='.$scopeFiltersPgSql[$scope],array());
         }         
    }
    protected function addSearchFilters($filter,$filters, &$itemsPerPage)
    {
    	$map = $this->getFetchSqlMap();
    	if ($filters){
         array_walk(array_shift(array_values($filters)), function($fil,$name) use ($map, $filter, $itemsPerPage){
         	$where = new Where();
             if(isset($map[$name]))
            {
            	$options = $map[$name];
            	$predicate = $options['predicate'];            	
              	if (isset($options['fieldset']))
             	{
             		$predicateSet = new PredicateSet();
              		foreach ($options['fieldset'] as $field)
             		{
             			$where = new Where();
             			$predicateSet->addPredicate($where->$predicate($field,$fil),PredicateSet::COMBINED_BY_OR);    	    
         	        }
         	        $filter->addPredicate($predicateSet);
              	}
             	else 
             	{	
             		$filter->and->$predicate($options['fieldname'],$fil);    	    
             	}
            }
            else 
            {
             	switch ($name){
            	    case 'calldirection':
            	    		if ('INCOMING'==$fil)
            	    		{
            	    		    $filter->and->notEqualTo('dcontext','vpbx_dialout');
            	    		}
            	    		elseif ('OUTGOING'==$fil){
            	    			$filter->and->equalTo('dcontext','vpbx_dialout');            	    			
            	    		};
            	    	break;
            	    case 'itemsperpage':
            	    	{
            	    		$itemsPerPage = (int)$fil;
            	    	}
            	    	break;
            	    case 'onlyrecorded':
            	    	if ('1'==$fil)
            	    	{
            	    		$filter->and->equalTo('disposition','ANSWERED');
            	    		$filter->and->notEqualTo('recordedname','');
            	    	} elseif ('2'==$fil)
            	    	{
            	    		$sql = new Sql($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
            	    		$select = new Select('cdr_callcentre_calls_missed');
            	    		$filter->and->in('linkedid',$select->columns(array('linkedid')));
            	    	}
            	    	break;
             	}
             }
            
            
        });
    	}
    }
}
 