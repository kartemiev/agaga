<?php
namespace Vpbxui\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class ReportScopeFilterControllerPlugin extends AbstractPlugin {
    public function getFilterbyScope($scope)
    {
           switch ($scope)
        {
            case 'today':
                $dateStart = date('Y-m-d 00:00:00');
                $dateEnd = date('Y-m-d 23:59:59');
                break;
                ;
            case 'yesterday':
                $dateStart = date('Y-m-d 00:00:00',strtotime('-1 day'));
                $dateEnd = date('Y-m-d 23:59:59',strtotime('-1 day'));
                break;
                ;

            case 'past24hrs':
                $dateStart = date('Y-m-d h:i:s',strtotime('-24 hours'));
                $dateEnd = date('Y-m-d h:i:s');                
                break;
                ;
                
                
            case 'lastmonth':
               $dateStart = date('Y-m-1 0:0:0',strtotime('-1 month'));
                $lastDayofMonth = date("t",strtotime('-1 month'));
                $dateEnd = date("Y-m-{$lastDayofMonth} 23:59:59",strtotime('-1 month'));         
                break;
                ;
                
            case 'currentmonth':
                $dateStart = date('Y-m-1 00:00:00');
                $dateEnd = date('Y-m-d h:i:s');
                break;
                ;

            case 'past30days':
                 $dateStart = date('Y-m-d 00:00:00',strtotime('-30 days'));
                $dateEnd = date('Y-m-d h:i:s');
                break;
                ;

            case 'integral':
                $dateStart='';
                $dateEnd='';
                break;
                ;
            default:
                $dateStart='';
                $dateEnd='';                
        };
            if ($dateStart!=='' && $dateEnd!==''){
                $filter = array("calldate>'$dateStart'","calldate<'".$dateEnd."'"); 
            }
            else
            {
                $filter = array();
            }
            return $filter;
    }
}
