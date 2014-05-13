<?php
namespace Vpbxui\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
 
class ChannelStateDebrief extends AbstractHelper
{   
	protected $channelStatesDebrief = array('отключен','зарезервировано','нет соединения','набирается номер',
			'идет КПВ', 'КПВ','разговор','занято','набор без поднятия трубки','обработка вызова',65535=>'Режим Mute');
      public function __invoke($channelstatuscode)
    {
    	$channelStatesDebrief = $this->channelStatesDebrief;
    	$state = (isset($channelStatesDebrief[$channelstatuscode]))?
    	$channelStatesDebrief[$channelstatuscode]:
    	'';
         return  $state;
    }
}
