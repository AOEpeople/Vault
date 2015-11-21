<?php

namespace Vault;


class CommandRegistry {

    public static function getCommands() {
        return [
            new \Vault\Command\EncryptCommand(),
            new \Vault\Command\DecryptCommand()
        ];
    }

}