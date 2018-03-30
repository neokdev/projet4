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
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class TimeHelperTest
 * @depends DateHelper
 */
class TimeHelperTest extends TestCase
{
    /**
     * @test
     *
     * @throws \ReflectionException
     */
    public function testIsTimeExceed()
    {
        $timeHelper = new TimeHelper($this->createMock(DateHelper::class));
        $result = $timeHelper->isTimeExceed("18");

        $this->assertTrue($result);
    }
}
