<?php

namespace App\Traits\Misc;

use Carbon\Carbon;

trait FormatedTime{

    /**
     * Return a date formated based on context of request e.g today, yesterday...
     *
     * @param DateTime|string $datetime
     * @return string|null
     */
    function prettyDate($datetime){
        if(!$datetime) return null;

        if(is_string($datetime)){
            if(Carbon::hasFormat($datetime, 'Y-m-d')){
                $datetime = Carbon::createFromFormat('Y-m-d', $datetime);
            }else return null;
        }

        if($datetime->isToday()) return 'Today';
        if($datetime->isYesterday()) return 'Yesterday';
        if($datetime->isCurrentWeek()) return $datetime->dayName;
        if($datetime->isCurrentYear()){
            return substr($datetime->monthName, 0, 3).' '.$datetime->day;
        }

        return substr($datetime->monthName, 0, 3).' '.$datetime->day.' '.$datetime->year;
    }

    /**
     * Return a full formated date i.e date month (and year) e.g Jan 15 2022
     *
     * @param DateTime|string $datetime
     * @return string|null
     */
    function fullFormatedDate($datetime){
        if(!$datetime) return null;

        if(is_string($datetime)){
            if(Carbon::hasFormat($datetime, 'Y-m-d')){
                $datetime = Carbon::createFromFormat('Y-m-d', $datetime);
            }else return null;
        };

        return substr($datetime->monthName, 0, 3).' '.$datetime->day.' '.$datetime->year;
    }

    /**
     * Return a full formated time i.e H:i
     *
     * @param DateTime|string $datetime
     * @return string|null
     */
    function fullFormatedTime($datetime){
        if(!$datetime) return null;

        if(is_string($datetime)){
            if(Carbon::hasFormat($datetime, 'Y-m-d H:i')){
                $datetime = Carbon::createFromFormat('Y-m-d H:i', $datetime);
            }else return null;
        }

        return $datetime->format('H:i');
    }

}
