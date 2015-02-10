# Carrooi/PdfExtractor

[![Build Status](https://img.shields.io/travis/Carrooi/PHP-PdfExtractor.svg?style=flat-square)](https://travis-ci.org/Carrooi/PHP-PdfExtractor)
[![Donate](https://img.shields.io/badge/donate-PayPal-brightgreen.svg?style=flat-square)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=97TWD4XVL4F64)

PDF text extractor.

Depends on pdftotext library.

## Installation

```
$ composer require carrooi/pdf-extractor
$ composer update
```

## Usage

```php
use Carrooi\PdfExtractor\PdfExtractor;

$extractor = new PdfExtractor;
$extractor->setTemp('/temporary/directory/path');

$text = $extractor->extractText('/path/to/file.pdf');
```

## Options

### -nopgbrk

```php
$extractor->setPageNoBreak(true);
```

### -layout

```php
$extractor->preserveLayout(true);
```

## Changelog

* 1.0.0
	+ Initial version
