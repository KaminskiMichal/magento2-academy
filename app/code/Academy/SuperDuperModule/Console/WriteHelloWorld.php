<?php

namespace Academy\SuperDuperModule\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class WriteHelloWorld extends Command
{
    const NAME = 'name';

    protected function configure()
    {
        $this->setName('academy:write:hello-world');
        $this->setDescription('This command writes some example text into console.');
        $this->addOption(
            self::NAME,
            null,
            InputOption::VALUE_REQUIRED,
            'Name'
        );

        parent::configure();
    }

    public function test(string $test)
    {
        return 'outputted string';
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if ($name = $input->getOption(self::NAME)) {
            $output->writeln('<info>Provided name is `' . $name . '`</info>');
        }

        $this->test('original TEXT');

        $output->writeln('<info>Success Message.</info>');
        $output->writeln('<error>An error encountered.</error>');
        $output->writeln('<comment>Some Comment.</comment>');
    }
}
