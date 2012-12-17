<?php
namespace Tiddr\Date;
/**
 * User: wangting
 * Date: 12-11-26
 * Time: 下午12:11
 * copyright 2012 tiddr.de
 */
class ChineseSeason
{
    const CHUN = 1;
    const XIA  = 2;
    const QIU  = 3;
    const DONG = 4;

    public function __construct($timezone = '')
    {
        if ($timezone === '') {
            $timezone = 'Asia/Shanghai';
        }
        date_default_timezone_set($timezone);
    }
    public function getCurrentSeason()
    {
        $currentMonth = date('n');
        if ($currentMonth >= 3 && $currentMonth <= 5) {
            return ChineseSeason::CHUN;
        }

        if ($currentMonth >= 6 && $currentMonth <= 8) {
            return ChineseSeason::XIA;
        }

        if ($currentMonth >= 9 && $currentMonth <= 11) {
            return ChineseSeason::QIU;
        }

        return ChineseSeason::DONG;
    }

    public function translate($season)
    {
        switch ($season) {
            case self::DONG:
                return "冬";
            case self::CHUN:
                return "春";
            case self::XIA:
                return "夏";
            case self::QIU:
                return "秋";
            default:
                return "";
        }
    }

    public function getLastSeason($number)
    {
        $currentYear = date('Y');
        $currentSeason = $this->getCurrentSeason();
        if ($number >= $currentSeason) {
            $deltaYear = (int)(($number + 1 - $currentSeason) / 4) + 1;
        } else {
            $deltaYear = 0;
        }

        $year = $currentYear - $deltaYear;
        $season = $this->_stepBackward($currentSeason, $number);
        return array('year' => $year, 'season' => $season);

    }

    public function seasonStart($year, $season)
    {
        switch($season) {
            case self::CHUN:
                return $year . '-03-01';
            case self::XIA:
                return $year . '-06-01';
            case self::QIU:
                return $year . '-09-01';
            case self::DONG:
                $year = $year - 1;
                return $year . '-12-01';
            default:
                throw new Exception('there are just four seasons');
        }
    }

    public function seasonEnd($year, $season)
    {
        switch($season) {
            case self::CHUN:
                return $year . '-05-31';
            case self::XIA:
                return $year . '-08-31';
            case self::QIU:
                return $year . '-11-30';
            case self::DONG:
                return $year . '-02-29';
            default:
                throw new Exception('there are just four seasons');
        }

    }
    private function _stepBackward($start, $steps)
    {
        $backwardSeason = array(self::CHUN, self::DONG, self::QIU, self::XIA);
        $index = array_search($start, $backwardSeason);
        $index = ($index + $steps) % 4;
        return $backwardSeason[$index];
    }

    private function _stepForward($start, $steps)
    {
        $forwardSeason = array(self::CHUN, self::XIA, self::QIU, self::DONG);
        $index = array_search($start, $forwardSeason);
        $index = ($index + $steps) % 4;
        return $forwardSeason[$index];
    }
}
