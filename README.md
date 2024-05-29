# AES Cryptor

A basic PHP package for encrypting and decrypting strings using an AES 256-bit key.

This library requires the PHP OpenSSL extension.

This package is based on https://gist.github.com/turret-io/957e82d44fd6f4493533.

## Installation

The package can be installed via composer:

```
composer install neezaan\aescryptor
```

## Usage

This package can generate a secure key and initialisation vector for you. You will need to store the key securely, but this package handles storing the IV itself with the encrypted string, so you don't have to store it elsewhere like you might a password salt. Arguably this is less secure, but it makes the implementation simpler.

```
<?php 
use Meezaan\Aescryptor\Generate;
use Meezaan\Aescryptor\Aes;

// Generate a 256-bit key. Store this somewhere in a secure vault. You don't need this step as you can generate your own key elsewhere too.
$key = Generate::key();

// Generate the required initialisation vector for a 256-bit key. You don't need this step as you can generate your own IV, but it should be AES 256 compliant (meaning it should be 16 characters long).
$iv = Generate::iv();

// Our secret
$secret = 'A_Secret';

// Instantiate the Aes class.
$aes = new Aes($key, $iv);

// Encrypt your string
$encrypted = $aes->encrypt($secret);

// Decrypt your string
$decrypted = $aes->decrypt($encrypted);

// Note that $decrypted === $secret

// Use the below if you will encrypt with your PHP application and decrypt via bash.
// The following method just returns the pure encrypted string. If you use this output, you will have to store the IV as you would a password hash somewhere to later decrypt.
$encryptedString = $aes->encryptWithoutIv($secret);

// Then decrypt this the following method and explicitly pass in the iv
$decryptedString = $aes->decryptWithoutIv($encryptedString, $iv);

```
## Purpose

This library is built primarily for interoperability between applications and pipelines.

You might use this library to write encrypted content to an s3 bucket or a git repository, then use the equivalent `openssl` commands on bash or an equivalent shell in your pipeline to decrypt the content and do something with it.

### Enrypt via Bash

First write your encrypted / decrypted content to a file called `input.txt`, then run the below.

`output.txt` will contain the result of the encryption/decryption operation in either case.

```
openssl enc -aes-256-cbc -in input.txt -out output.txt -K <key> -iv <iv>
```

### Decrypt via Bash
```
openssl enc -d -aes-256-cbc -in input.txt -out output.txt -K <key> -iv <iv>
```

## Credits

* https://gist.github.com/turret-io/957e82d44fd6f4493533

## License

MIT