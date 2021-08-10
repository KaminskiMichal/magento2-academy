<?php
namespace Academy\SuperDuperModule\Console;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\Serialize\Serializer\Json;

use mysql_xdevapi\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SomeCommand
 */
class ReadJsonFile extends Command
{
    const NAME = 'name';

    protected $_file;
    protected $_reader;
    protected $_json;

    public function __construct(
        File $file,
        Reader $reader,
        Json $json,
        string $name = null
    ) {
        parent::__construct($name);
        $this->_file = $file;
        $this->_reader = $reader;
        $this->_json = $json;
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
            'Name'
        );

        parent::configure();
    }

    protected function getJsonPathFile(): string
    {

        $moduleEtcPath = $this->_reader->getModuleDir(
            \Magento\Framework\Module\Dir::MODULE_ETC_DIR,
            'Academy_SuperDuperModule'
        );

        $jsonFilePath = $moduleEtcPath."/test.json";

        return $jsonFilePath;
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
        if ($name = $input->getOption(self::NAME)) {
            $output->writeln('<info>Provided name is `' . $name . '`</info>');
        }

        $jsonFilePath = $this->getJsonPathFile();

        try {
            $jsonString = $this->_file->fileGetContents($jsonFilePath);
        } catch(FileSystemException $e) {
            $output->writeln('Caught exception: ',  $e->getMessage(), "\n");
        }

        $output->writeln($jsonString);

        $product = $this->_json->unserialize($jsonString);
//        $output->writeln(var_dump($product));

    }
}
