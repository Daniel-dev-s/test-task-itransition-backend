<?php

declare(strict_types=1);

namespace App\Tests\Command;


use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ParseCSVCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:parse');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'path' => 'tests/wellData.csv',
            'mode' => 'test'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('2 items was added correctly', $output);
        $this->assertStringContainsString('0 items contains errors', $output);
        $this->assertStringContainsString('[P0001] TV (32k Tv) (10) 399.99$', $output);
    }

}
