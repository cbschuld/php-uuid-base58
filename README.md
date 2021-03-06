# php-uuid-base58

<p>
    <img src="https://img.shields.io/travis/cbschuld/php-uuid-base58/master?style=flat-square"/>
    <img src="https://img.shields.io/packagist/l/cbschuld/php-uuid-base58?style=flat-square"/>
    <img src="https://img.shields.io/packagist/dm/cbschuld/php-uuid-base58?style=flat-square"/>
</p>

Generates a RFC4122 compliant v4 UUID and returns it encoded in base-58. This is great for creating unique IDs which only consume 22 characters of storage. Also provides base-58 encoding and decoding.

## Installation

```sh
composer require cbschuld/php-uuid-base58
```

## Usage

```php

use cbschuld\UuidBase58;

$id = UuidBase58::id();
```

## API

The UuidBase58 class provides three static functions

+ `id` - creates the RFC4122 v4 UUID encoded in base-58
+ `encode(string)` - encodes a base-16 string in base-58
+ `decode(string)` - decodes a string from base-58 to base-16

## Testing

```sh
npm run test
```

## Performance Hit

There is an additional performance hit to translate a v4 UUID into base58.  In testing I found the overhead for the translation to base58 adds an additional 31%.  In 100k calculation batches I found that v4 uuid calculation took 1.606s/100k vs 2.319s/100k for uuid58.  Thus, 69% of the runtime was consumed calculating a v4 uuid.  Additional work could be done to bring the uuid calculation internal and attempt to increase performance.

## Base58 Alphabet

This solution uses the Bitcoin / IPFS hash alphabet: 123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz

[Additional information on Base-58](https://en.wikipedia.org/wiki/Base58).

## Contact

**Twitter** - @cbschuld

## Contributing

Yes, thank you!  Please update the docs and tests and add your name to the package.json file.
