<?php

namespace Vault;

class Vault
{

    /**
     * @var \PHPEncryptData\Simple
     */
    protected $phpCrypt;

    public function __construct()
    {
        $encryptionKey = getenv('VAULT_ENCRYPTION_KEY');
        if (empty($encryptionKey)) {
            throw new \Exception('No VAULT_ENCRYPTION_KEY found in env vars.');
        }

        $macKey = getenv('VAULT_MAC_KEY');
        if (empty($macKey)) {
            throw new \Exception('No VAULT_MAC_KEY found in env vars.');
        }

        $this->phpCrypt = new \PHPEncryptData\Simple($encryptionKey, $macKey);
    }

    public function decryptString($signedCiphertext)
    {
        return $this->phpCrypt->decrypt($signedCiphertext);
    }

    public function encryptString($plaintext)
    {
        return $this->phpCrypt->encrypt($plaintext);
    }

    public function decryptFile($encryptedFilePath, $plainTextFilePath = null)
    {
        if (!is_file($encryptedFilePath)) {
            throw new \Exception("File '$encryptedFilePath' not found");
        }
        $plainText = $this->decryptString(file_get_contents($encryptedFilePath));
        if (!is_null($plainTextFilePath)) {
            $this->writeFile($plainText, $plainTextFilePath);
        }
        return $plainText;
    }

    public function encryptFile($plainTextFilePath, $encryptedFilePath = null)
    {
        if (!is_file($plainTextFilePath)) {
            throw new \Exception("File '$plainTextFilePath' not found");
        }
        $cipherText = $this->encryptString(file_get_contents($plainTextFilePath));
        if (!is_null($encryptedFilePath)) {
            $this->writeFile($cipherText, $encryptedFilePath);
        }
        return $cipherText;
    }

    public function writeFile($content, $filepath)
    {
        $res = file_put_contents($filepath, $content);
        if ($res === false) {
            throw new \Exception("Error while writing file '$filepath'");
        }
    }

    public static function open($file) {
        $vault = new Vault();
        return $vault->decryptFile($file);
    }

}
