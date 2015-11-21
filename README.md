# Vault

Simple vault that allows encrypting and decrypting files based on an encryption key and a mac from environment variables.

Author: [Fabrizio Branca](https://twitter.com/fbrnc)

### Configuration

```
export VAULT_ENCRYPTION_KEY=<INSERT_YOUR_ENCRYPTION_KEY>
export VAULT_MAC_KEY=<INSERT_YOU_MAC_KEY>
```

### Key Generation

see https://github.com/archwisp/PHPEncryptData

### Commands

```
vault:encrypt <plainTextFilePath> <encryptedFilePath>
vault:decrypt [--force] <encryptedFilePath> <plainTextFilePath>
```

### PHP

Example
```
$plainText = \Vault\Vault::open('vault/config.yml.encrypted');
$config = \Symfony\Component\Yaml\Yaml::parse($plainText);
// and check out \Vault\Vault's other methods...
```

