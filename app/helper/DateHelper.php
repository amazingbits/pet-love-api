<?php

namespace App\Helper;

class DateHelper
{

    public function fisrtDayOfMonth(string $date): string|bool
    {
        if (!$this->isSqlDate($date)) return false;
        return date("Y-m-01", strtotime($date));
    }

    public function lastDayOfMonth(string $date): string|bool
    {
        if (!$this->isSqlDate($date)) return false;
        return date("Y-m-t", strtotime($date));
    }

    public function addDaysToDate(string $date, int $days): string|bool
    {
        if (!$this->isSqlDate($date)) return false;
        return date("Y-m-d", strtotime($date . " + {$days} days"));
    }

    public function isBigger(string $dateOne, string $dateTwo): bool
    {
        if(!$this->isSqlDate($dateOne) || !$this->isSqlDate($dateTwo)) return false;
        return strtotime($dateOne) > strtotime($dateTwo);
    }

    public function dateSqlToBrl(string $sqlDate): string
    {
        if (!$this->isSqlDate($sqlDate)) return "";
        $sqlDate = str_replace("/", "-", $sqlDate);
        $sqlDate = explode("-", $sqlDate);
        return $sqlDate[2] . "-" . $sqlDate[1] . "-" . $sqlDate[0];
    }

    public function dateBrlToSql(string $brlDate): string
    {
        if (!$this->isBrlDate($brlDate)) return "";
        $brlDate = str_replace("/", "-", $brlDate);
        $brlDate = explode("-", $brlDate);
        return $brlDate[2] . "-" . $brlDate[1] . "-" . $brlDate[0];
    }

    public function isSqlDate(string $date): bool
    {
        $date = trim($date);
        if (mb_strlen($date) !== 10) return false;
        $date = str_replace("/", "-", $date);
        $date = explode("-", $date);
        if (count($date) !== 3) return false;
        $day = (int)$date[2];
        $month = (int)$date[1];
        $year = (int)$date[0];
        if ($month < 1 || $month > 12) return false;
        if ($day < 1 || $day > 31) return false;
        if ($month === 2 && $day > 29) return false;
        if ($year < 1500) return false;
        return true;
    }

    public function isBrlDate(string $date): bool
    {
        $date = trim($date);
        if (mb_strlen($date) !== 10) return false;
        $date = str_replace("/", "-", $date);
        $date = explode("-", $date);
        if (count($date) !== 3) return false;
        $day = (int)$date[0];
        $month = (int)$date[1];
        $year = (int)$date[2];
        if ($month < 1 || $month > 12) return false;
        if ($day < 1 || $day > 31) return false;
        if ($month === 2 && $day > 29) return false;
        if ($year < 1500) return false;
        return true;
    }
}