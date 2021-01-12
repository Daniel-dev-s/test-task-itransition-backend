<?php

namespace App\Tests;

use App\DTO\ItemDTO;
use App\DTO\ParsedItems;
use App\Entity\Item;
use App\Service\ParseCSVService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;

class ParseCSVServiceTest extends WebTestCase
{

    public function testSomething()
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();
        $service = self::$container->get(ParseCSVService::class);

        // test parse method with correct data
        $this->assertEquals(2, count($service->parse('tests/wellData.csv')->getSuccessItems()));

        // test parse method with half correct data
        $parseResult = $service->parse('tests/halfData.csv');
        $this->assertEquals(1, count($parseResult->getSuccessItems()));
        $this->assertEquals(1, count($parseResult->getFailedItems()));

        // test parse method with wrong data
        $this->assertEquals(2, count($service->parse('tests/badData.csv')->getFailedItems()));

        // test getErrorObject method
        $dataRow = ["1", "2"];
        $this->assertEquals("[1 2] - error", $service->getErrorObject($dataRow, 'error'));

        //test packItemObject method
        $itemDTO = new ItemDTO("code",
            "name",
            "description",
            10,
            10.0,
            'yes');
        $item = new Item("code",
            "name",
            "description",
            10,
            10.0,
            'yes');
        $this->assertEquals($item, $service->packValidItem($itemDTO));

        //test getCustomErrorMessage method with error data
        $itemDTO->setCost(1001);
        $this->assertContains('This value should be less than 1000.',
            $service->getCustomErrorMessage($itemDTO));

        // test getCustomErrorMessage method with correct data
        $itemDTO->setCost(55);
        $this->assertNotContains('This value should be less than 1000.',
            $service->getCustomErrorMessage($itemDTO));
    }
}
