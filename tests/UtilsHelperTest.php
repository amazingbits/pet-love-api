<?php

require __DIR__ . "/../app/helper/UtilsHelper.php";
require __DIR__ . "/../app/helper/DateHelper.php";

use App\Helper\DateHelper;
use App\Helper\UtilsHelper;
use PHPUnit\Framework\TestCase;

class UtilsHelperTest extends TestCase
{
    /** @test */
    public function generateNumberTest()
    {
        $utils = new UtilsHelper();
        $this->assertEquals(4, mb_strlen($utils->generateNumber(4)));
    }

    /** @test */
    public function addMinutesToTimeTest()
    {
        $dateHelper = new DateHelper();
        $this->assertEquals("10:30:00", $dateHelper->addMinutesToTime("10:00:00", 30));
    }
}