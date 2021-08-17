<?php
namespace Academy\SuperDuperModule\Console;


use Magento\Framework\Exception\FileSystemException;

// dependencies - Reading files
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\Serialize\Serializer\Json;

// dependencies - Reading files
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ResourceModel\Product;
use Magento\InventoryApi\Api\SourceItemsSaveInterface;
use Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory;
use Magento\Framework\App\State;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Area;

use mysql_xdevapi\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class ReadJsonFile extends Command
{
    const NAME = 'name';
    const SERIALIZED = 'serialized';

    protected $_file;
    protected $_reader;
    protected $_json;

    protected $_productFactory;
    protected $_resourceModel;
    protected $_sourceItemsSaveInterface;
    protected $_sourceItemInterfaceFactory;
    protected $_state;
    protected $_storeManager;

    public function __construct(
        File $file,
        Reader $reader,
        Json $json,

        ProductFactory $productFactory,
        Product $resourceModel,
        SourceItemsSaveInterface $sourceItemsSaveInterface,
        SourceItemInterfaceFactory $sourceItemInterfaceFactory,
        State $state,
        StoreManagerInterface $storeManager,

        string $name = null
    ) {
        parent::__construct($name);
        $this->_file = $file;
        $this->_reader = $reader;
        $this->_json = $json;

        $this->_productFactory = $productFactory;
        $this->_resourceModel = $resourceModel;
        $this->_sourceItemsSaveInterface = $sourceItemsSaveInterface;
        $this->_sourceItemInterfaceFactory = $sourceItemInterfaceFactory;
        $this->_state = $state;
        $this->_storeManager = $storeManager;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('academy:read:json-file');
        $this->setDescription('This is my first console command.');
        $this->addOption(
            self::NAME,
            null,
            InputOption::VALUE_REQUIRED,
            'File name',
            'test.json'
        );

        $this->addOption(
        self::SERIALIZED,
        null,
        InputOption::VALUE_NONE,
        'Is json should be serialized'
        );

        parent::configure();
    }

    protected function getJsonPathFile($fileName): string {

        $moduleEtcPath = $this->_reader->getModuleDir(
            \Magento\Framework\Module\Dir::MODULE_ETC_DIR,
            'Academy_SuperDuperModule'
        );

        $jsonFilePath = $moduleEtcPath."/".$fileName;

        return $jsonFilePath;
    }

    protected function createProduct(array $productsDataArray) {

        $this->_state->setAreaCode(Area::AREA_ADMINHTML);
        $this->_storeManager->setCurrentStore($this->_storeManager->getDefaultStoreView()->getWebsiteId());

        foreach ($productsDataArray as $productData) {

            $product = $this->_productFactory->create();

            $product->unsetData();
            $product->setTypeId("simple")
                ->setAttributeSetId($productData["attribute_set_id"])
                ->setWebsiteIds([$this->_storeManager->getDefaultStoreView()->getWebsiteId()])
                ->setName($productData["name"])
                ->setSku($productData["sku"])
                ->setPrice($productData["price"])
                ->setVisibility($productData["visibility"])
                ->setStatus($productData["status"])
                ->setWeight($productData["weight"])
                ->addImageToMediaGallery("/var/www/html/pub/media/catalog/product".$productData['image'],
                    ['image', 'small_image', 'thumbnail'],
                    false,
                    false )
                // Assign category for product
                ->setCategoryIds($productData["categoriesIds"]); // Category Default

//            $product->setCustomAttribute(
//                $colorAttr->getAttributeCode(),
//                $option->getValue()
//            );

            $this->_resourceModel->save($product);

            $sourceItem = $this->_sourceItemInterfaceFactory->create();
            $sourceItem->setSourceCode('default');
            $sourceItem->setQuantity(100);
            $sourceItem->setSku($productData["sku"]);
            $sourceItem->setStatus(1);

            //Execute Update Stock Data
            try {
                $this->_sourceItemsSaveInterface->execute([$sourceItem]);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($fileName = $input->getOption(self::NAME)) {
            $output->writeln('<info>Provided file name is `' . $fileName . '`</info>');
        }

        $ifSerialized = $input->getOption(self::SERIALIZED);
        if ($ifSerialized) {
            $output->writeln("Do serialize");
        } else {
            $output->writeln("Don't serialize");
        }


        $jsonFilePath = $this->getJsonPathFile($fileName);

        try {
            $jsonString = $this->_file->fileGetContents($jsonFilePath);
        }
        catch(FileSystemException $e) {
            $output->writeln('Caught exception: ',  $e->getMessage(), "\n");
        }

        $productsDataArray = $this->_json->unserialize($jsonString);

        $this->createProduct($productsDataArray);

        if($ifSerialized)
            $output->writeln(var_dump($productsDataArray));
        else
            $output->writeln($jsonString);

        $output->writeln('<info>Products created!</info>');

    }
}
