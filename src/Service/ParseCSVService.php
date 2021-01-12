<?php


namespace App\Service;


use App\DTO\ItemDTO;
use App\DTO\ParsedItems;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ParseCSVService
{
    private ParsedItems $parsedItems;
    private ValidatorInterface $validator;
    private EntityManagerInterface $entityManager;

    public function __construct(ValidatorInterface $validator,
                                EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    // parse csv file from given path
    public function parse(string $filename)//: ParsedItems
    {
        $this->parsedItems = new ParsedItems();
        $serializer = new Serializer([], [new CsvEncoder()]);
        $data = $serializer->decode(file_get_contents($filename), 'csv');
        $this->objectProcessing($data);

        return $this->parsedItems;
    }

    // process csv object
    public function objectProcessing(array $data): void
    {
        foreach ($data as $dataRow) {
            try {
                $currentItem = $this->packItemDTO($dataRow);
                if (($message = $this->getCustomErrorMessage($currentItem)) == null) {
                    $this->parsedItems->pushIntoSuccessItems($this->packValidItem($currentItem));
                } else {
                    $this->parsedItems->pushIntoFailedItems($this->getErrorObject($dataRow, $message));
                }
            } catch (Exception $e) {
                $this->parsedItems->pushIntoFailedItems($this->getErrorObject($dataRow, $e->getMessage()));
            }
        }
    }

    // method to add or update entity
    protected function addOrUpdate(Item $parsedItem): void
    {
        $item = $this->entityManager
            ->getRepository(Item::class)
            ->findOneBy(['productCode' => $parsedItem->getProductCode()]);
        if ($item !== null) {
            $item->setProductName($parsedItem->getProductName())
                ->setDescription($parsedItem->getDescription())
                ->setStock($parsedItem->getStock())
                ->setCost($parsedItem->getCost())
                ->setDiscontinued($parsedItem->getDiscontinued());
            $this->entityManager->persist($item);
        } else {
            $this->entityManager->persist($parsedItem);
        }
    }

    // method which adds all items to database
    public function addItemsToDatabase(array $items): void
    {
        foreach ($items as $item) {
            $this->addOrUpdate($item);
        }
        $this->entityManager->flush();
    }

    // processing valid item to database and array
    public function packValidItem(ItemDTO $item): Item
    {
        return new Item($item->getProductCode(),
            $item->getProductName(),
            $item->getDescription(),
            $item->getStock(),
            $item->getCost(),
            $item->getDiscontinued());
    }

    // returns failed object with its error
    public function getErrorObject(array $item, string $error): string
    {
        return '[' . implode(' ', $item) . '] - ' . $error;
    }

    // builds object from csv row
    public function packItemDTO(array $data): ItemDTO
    {
        return new ItemDTO($data['Product Code'],
            $data['Product Name'],
            $data['Product Description'],
            (int)$data['Stock'],
            (float)$data['Cost in GBP'],
            ($data['Discontinued'] == 'yes' ? true : false));
    }

    // returns custom error message if it exists
    public function getCustomErrorMessage(ItemDTO $item): ?string
    {
        $errors = null;
        $errors = $this->validator->validate($item);
        return $errors;
    }
}
