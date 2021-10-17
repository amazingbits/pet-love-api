<?php

require __DIR__ . "/../app/helper/UtilsHelper.php";

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
}