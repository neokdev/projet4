<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 07/03/2018
 * Time: 13:55
 */

namespace App\tests\Services;

use App\Services\DateHelper;
use App\Services\PriceHelper;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Class PriceHelperTest
 */
class PriceHelperTest extends TestCase
{
    /**
     * @var DateTime
     */
    protected $selectedDate;
    /**
     * @var DateTime
     */
    protected $age3;
    /**
     * @var DateTime
     */
    protected $age11;
    /**
     * @var DateTime
     */
    protected $age59;
    /**
     * @var DateTime
     */
    protected $age79;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->age3         = (new DateTime())->modify("-3 years");
        $this->age11        = (new DateTime())->modify("-11 years");
        $this->age59        = (new DateTime())->modify("-59 years");
        $this->age79        = (new DateTime())->modify("-79 years");
        $this->selectedDate = (new DateTime())->modify("+5 days");
    }

    /**
     * @test
     */
    public function testcalculatePriceAge3(): void
    {
        $dateHelper = $this
            ->getMockBuilder(DateHelper::class)
            ->disableOriginalConstructor()
            ->setMethods(['getSelectedDate'])
            ->getMock();
        $dateHelper
            ->method('getSelectedDate')
            ->willReturn($this->selectedDate);

        $classToTest = new PriceHelper($dateHelper);

        $result = $classToTest->calculatePrice($this->age3, false);

        $this->assertEquals(0, $result);
    }

    /**
     * @test
     */
    public function testcalculatePriceAge11(): void
    {
        $dateHelper = $this
            ->getMockBuilder(DateHelper::class)
            ->disableOriginalConstructor()
            ->setMethods(['getSelectedDate'])
            ->getMock();
        $dateHelper
            ->method('getSelectedDate')
            ->willReturn($this->selectedDate);

        $classToTest = new PriceHelper($dateHelper);

        $result = $classToTest->calculatePrice($this->age11, false);

        $this->assertEquals(8, $result);
    }
    /**
     * @test
     */
    public function testcalculatePriceAge59(): void
    {
        $dateHelper = $this
            ->getMockBuilder(DateHelper::class)
            ->disableOriginalConstructor()
            ->setMethods(['getSelectedDate'])
            ->getMock();
        $dateHelper
            ->method('getSelectedDate')
            ->willReturn($this->selectedDate);

        $classToTest = new PriceHelper($dateHelper);

        $result = $classToTest->calculatePrice($this->age59, false);

        $this->assertEquals(16, $result);
    }
    /**
     * @test
     */
    public function testcalculatePriceAge79(): void
    {
        $dateHelper = $this
            ->getMockBuilder(DateHelper::class)
            ->disableOriginalConstructor()
            ->setMethods(['getSelectedDate'])
            ->getMock();
        $dateHelper
            ->method('getSelectedDate')
            ->willReturn($this->selectedDate);

        $classToTest = new PriceHelper($dateHelper);

        $result = $classToTest->calculatePrice($this->age79, false);

        $this->assertEquals(12, $result);
    }
    /**
     * @test
     */
    public function testcalculatePriceReducedPrice(): void
    {
        $dateHelper = $this
            ->getMockBuilder(DateHelper::class)
            ->disableOriginalConstructor()
            ->setMethods(['getSelectedDate'])
            ->getMock();
        $dateHelper
            ->method('getSelectedDate')
            ->willReturn($this->selectedDate);

        $classToTest = new PriceHelper($dateHelper);

        $result = $classToTest->calculatePrice($this->age59, true);

        $this->assertEquals(10, $result);
    }
    /**
     * @test
     */
    public function testcalculatePriceReducedPriceAge3(): void
    {
        $dateHelper = $this
            ->getMockBuilder(DateHelper::class)
            ->disableOriginalConstructor()
            ->setMethods(['getSelectedDate'])
            ->getMock();
        $dateHelper
            ->method('getSelectedDate')
            ->willReturn($this->selectedDate);

        $classToTest = new PriceHelper($dateHelper);

        $result = $classToTest->calculatePrice($this->age3, true);

        $this->assertEquals(0, $result);
    }
    /**
     * @test
     */
    public function testcalculatePriceReducedPriceAge11(): void
    {
        $dateHelper = $this
            ->getMockBuilder(DateHelper::class)
            ->disableOriginalConstructor()
            ->setMethods(['getSelectedDate'])
            ->getMock();
        $dateHelper
            ->method('getSelectedDate')
            ->willReturn($this->selectedDate);

        $classToTest = new PriceHelper($dateHelper);

        $result = $classToTest->calculatePrice($this->age11, true);

        $this->assertEquals(8, $result);
    }
}
