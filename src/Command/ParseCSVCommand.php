<?php


namespace App\Command;


use App\DTO\ParsedItems;
use App\Entity\Item;
use App\Service\ParseCSVService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseCSVCommand extends Command
{
    private ParseCSVService $parseCSVService;
    protected static $defaultName = 'app:parse';

    public function __construct(ParseCSVService $parseCSVService)
    {
        $this->parseCSVService = $parseCSVService;
        parent::__construct();
    }

    // command config, adds argument, set description
    protected function configure()
    {
        $this->setDescription('Parsing csv file and add positions to database.')
            ->setHelp('This command allows you to add items from csv')
            ->addArgument('path', InputArgument::REQUIRED, "path to csv file")
            ->addArgument('mode', InputArgument::OPTIONAL, "can run in a test mode");
    }

    // prints array to screen
    protected function writeArray(array $array, OutputInterface $output): void
    {
        foreach ($array as $a)
        {
            $output->writeln($a);
        }
    }

    // enter point of command
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            // try to receive parsed data
            $parseResult = $this->parseCSVService->parse($input->getArgument('path'));
            // call function to output results
            $this->buildConsoleOutput($parseResult, $output);
            // if it isn't test - add items to database
            if ($input->getArgument('mode') != 'test')
            {
                $this->parseCSVService->addItemsToDatabase($parseResult->getSuccessItems());
            }
            return Command::SUCCESS;
        } catch (Exception $exception) {
            $output->writeln($exception->getMessage());
            return Command::FAILURE;
        }
    }

    // builds console view
    protected function buildConsoleOutput(ParsedItems $parseResult, OutputInterface $output): void
    {
        $parsedCount = count($parseResult->getSuccessItems());
        $failedCount = count($parseResult->getFailedItems());
        $this->writeParsedTitle($parsedCount, $output);
        $this->writeArray($parseResult->getSuccessItems(), $output);
        $this->writeFailedTitle($failedCount, $output);
        $this->writeArray($parseResult->getFailedItems(), $output);
    }

    // prints the title of parsed elements
    protected function writeParsedTitle(int $parsedCount, OutputInterface $output): void
    {
        $output->writeln("<comment>==========================</comment>");
        $output->writeln("<info>$parsedCount items was added correctly:</info>");
        $output->writeln("<comment>==========================</comment>");
    }

    // prints the title of failed elements
    protected function writeFailedTitle(int $failedCount, OutputInterface $output): void
    {
        $output->writeln("<comment>==========================</comment>");
        $output->writeln("<error>$failedCount items contains errors:</error>");
        $output->writeln("<comment>==========================</comment>");
    }

}
