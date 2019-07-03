<?php
namespace src;

final class appFunctions {

    public function setDateToBR($date) {

        $dateUs = explode("-", $date);
        $time = explode(" ", $dateUs[2]);
        if($time[1] != '') {
            $timeTiny = explode(":", $time[1]);
            $timestr = ' ' . $timeTiny[0] . ':' . $timeTiny[1];
        } else {
            $timestr = '';
        }
        
        $dateBr = $time[0] . '/' . $dateUs[1] . '/' . $dateUs[0];

        $dateAndtime = $dateBr . $timestr;
        return $dateAndtime;
    }
}
