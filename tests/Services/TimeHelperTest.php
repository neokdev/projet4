<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 26/03/2018
 * Time: 16:01
 */

namespace App\Tests\Services;

use App\Services\DateHelper;
use App\Services\TimeHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class TimeHelperTest
 * @depends DateHelper
 */
class TimeHelperTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testIsTimeExceed()
    {
        $timeHelper = $this->createMock(TimeHelper::class);
        $result = $timeHelper->isTimeExceed("18");

        $this->assertEquals(false, $result);
    }
}
