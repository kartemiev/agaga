<?php
namespace Vpbxui\CallCentreSchedule\Model;

use Vpbxui\CallCentreSchedule\Model\CallCentreSchedule;

interface CallCentreScheduleTableInterface
{
   function saveCallCentreSchedule(CallCentreSchedule $callcentreschedule);
   function getCallCentreSchedule($vpbxid);       
}