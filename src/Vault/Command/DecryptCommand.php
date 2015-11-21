<?php

namespace Vault\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Vault\Vault;

class DecryptCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('decrypt')
            ->setDescription('Decrypt file')
            ->addArgument(
                'encryptedFilePath',
                InputArgument::REQUIRED,
                'Encrypted file path'
            )
            ->addArgument(
                'plainTextFilePath',
                InputArgument::REQUIRED,
                'Plaintext file path'
            )
            ->addOption(
                'force',
                null,
                InputOption::VALUE_NONE,
                'Overwrite plaintext file if it exists'
            );
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $plainTextFilePath = $input->getArgument('plainTextFilePath');
        if (is_file($plainTextFilePath) && !$input->getOption('force')) {
            $dialog = $this->getHelper('dialog');
            $confirmed = $dialog->askConfirmation(
                $output,
                "File '$plainTextFilePath' already exists. Do you want to overwrite it? [y/N] ",
                false
            );
            if (!$confirmed) {
                throw new \Exception('Operation aborted');
            }
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $encryptedFilePath = $input->getArgument('encryptedFilePath');
        $plainTextFilePath = $input->getArgument('plainTextFilePath');

        $vault = new Vault();
        $vault->decryptFile($encryptedFilePath, $plainTextFilePath);

        $output->writeln("File written: $plainTextFilePath");
    }

}