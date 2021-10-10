<?php

require __DIR__ . "/../app/helper/DateHelper.php";

use App\Helper\DateHelper;
use PHPUnit\Framework\TestCase;

class DateHelperTest extends TestCase
{

    /** @test */
    public function firstDayOfMonthTest()
    {
        $dateHelper = new DateHelper();
        $date1 = "2020-01-18";
        $date2 = "1499-01-18";
        $date3 = "2020-13-18";
        $this->assertEquals("2020-01-01", $dateHelper->fisrtDayOfMonth($date1));
        $this->assertEquals(false, $dateHelper->fisrtDayOfMonth($date2));
        $this->assertEquals(false, $dateHelper->fisrtDayOfMonth($date3));
    }

    /** @test */
    public function lastDayOfMonthTest()
    {
        $dateHelper = new DateHelper();
        $date1 = "2020-01-18";
        $date2 = "1499-01-18";
        $date3 = "2020-13-18";
        $this->assertEquals("2020-01-31", $dateHelper->lastDayOfMonth($date1));
        $this->assertEquals(false, $dateHelper->lastDayOfMonth($date2));
        $this->assertEquals(false, $dateHelper->lastDayOfMonth($date3));
    }

    /** @test */
    public function dateBrlToSqlTest()
    {
        $dateHelper = new DateHelper();
        $date1 = "29/11/1991";
        $date2 = "05/h8-2025";
        $this->assertEquals("1991-11-29", $dateHelper->dateBrlToSql($date1));
        $this->assertEquals("", $dateHelper->dateBrlToSql($date2));
    }

    /** @test */
    public function isBiggerTest()
    {
        $dateHelper = new DateHelper();
        $date1 = "2021-10-10";
        $date2 = "2021-10-09";
        $this->assertEquals(true, $dateHelper->isBigger($date1, $date2));
    }

    /** @test */
    public function addDaysToDateTest()
    {
        $dateHelper = new DateHelper();
        $date = "2021-10-10";
        $days = 50;
        $this->assertEquals("2021-11-29", $dateHelper->addDaysToDate($date, $days));
    }

    /** @test */
    public function timeIdBiggerTest()
    {
        $dateHelper = new DateHelper();
        $time1 = "10:00";
        $time2 = "10:01";
        $this->assertEquals(false, $dateHelper->timeIsBigger($time1, $time2));
        $this->assertEquals(false, $dateHelper->timeIsBigger($time1, $time1));
        $this->assertEquals(true, $dateHelper->timeIsBigger($time2, $time1));
    }
}