<?php

namespace App\Utils;


class CheckPeriod
{

    /**
     * @param \DateTime $date Date that is to be checked if it falls between $startDate and $endDate
     * @param \DateTime $startDate Date should be after this date to return true
     * @param \DateTime $endDate Date should be before this date to return true
     * @return bool
     */
    public function isDateBetweenDates(\DateTime $date, \DateTime $startDate, \DateTime $endDate)
    {
        if ($startDate > $endDate){
            return false;
        } else{
            return $date > $startDate && $date < $endDate;
        }
    }
}