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

class EncryptCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('vault:encrypt')
            ->setDescription('Encrypt file')
            ->addArgument(
                'plainTextFilePath',
                InputArgument::REQUIRED,
                'Plaintext file path'
            )
            ->addArgument(
                'encryptedFilePath',
                InputArgument::REQUIRED,
                'Encrypted file path'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $plainTextFilePath = $input->getArgument('plainTextFilePath');
        $encryptedFilePath = $input->getArgument('encryptedFilePath');

        $vault = new Vault();
        $vault->encryptFile($plainTextFilePath, $encryptedFilePath);

        $output->writeln("File written: $encryptedFilePath");
    }

}