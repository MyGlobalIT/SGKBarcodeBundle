# SGKBarcodeBundle

SGKBarcodeBundle is the Symfony2 Barcode Generator Bundle which you want!

    Features:
    
    1.Barcode generator for 3 two-dimensional and 30 one-dimensional types
    
    2.Output three formats: HTML, PNG, or SVG canvas
    
    3.Twig integration: you can simply use a function extensional of Twig in the template to generate Barcode
    
    4.Core of this bundle use this laravel project: [dinesh/barcode](https://github.com/dineshrabara/barcode)

## Installation

Add SGKBarcodeBundle by running the command:

```sh
$ php composer.phar require "sgk/barcode-bundle": "dev-master"
```
Composer will install the bundle to your project's vendor/sgk directory.

Then, Enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new SGK\BarcodeBundle\SGKBarcodeBundle(),
    );
}
```

## Usage with Service container
  
Used by service ``tms_barcode_generator``:
```php
use Tms\Bundle\BarcodeBundle\Type\BarcodeType;
//....
$barcode = $this->get('tms_barcode_generator')->generate(BarcodeType::QR_CODE, "This is what I want encoded");
```

or

if you don't want to include BarcodeType in your file, a string of type is possible, please read the section *Supported Barcode Types*

```php
$barcode = $this->get('tms_barcode_generator')->generate("QR CODE", "This is what I want encoded");
```

## Usage in Twig

This bundle extend two function of Twig which you can simply use to generate barcode,
now only format html is supported for Twig usage.

```
barcode1d($barcodeType, $code, $width = 2, $height = 30, $color = 'black', $format = 'html')
barcode2d($barcodeType, $code, $width = 5, $height = 5, $color = 'black', $format = 'html')
```

example:
```
{{ barcode1d('Code 128', 'This is what I want encoded') }}
{{ barcode2d('QR CODE', 'This is what I want encoded') }}
{{ barcode2d('PDF417', participation_1.id, 3, 3, 'red') }}
```

## Supported Barcode Types

```php
abstract class BarcodeType
{
    // One dimensional
    const CODABAR = "Codabar";
    const CODE_11 = "Code 11";
    const CODE_39 = "Code 39";
    const CODE_39_CHECK_DIGIT = "Code 39 (Check Digit)";
    const CODE_39_EXTENDED = "Code 39 (Extended)";
    const CODE_39_CHECK_DIGIT_EXTENDED = "Code 39 (Extended, Check Digit)";
    const CODE_93 = "Code 93";
    const CODE_128 = "Code 128";
    const CODE_128A = "Code 128A";
    const CODE_128B = "Code 128B";
    const CODE_128C = "Code 128C";
    const EAN_2 = "EAN-2";
    const EAN_5 = "EAN-5";
    const EAN_13 = "EAN-13";
    const IMB = "IMB";
    const INTERLEAVED_2_OF_5 = "Interleaved 2 of 5";
    const INTERLEAVED_2_OF_5_CHECK_DIGIT = "Interleaved 2 of 5 (Check Digit)";
    const KIX = "KIX";
    const MSI = "MSI";
    const MSI_CHECK_DIGIT = "MSI (Check Digit modulo 11)";
    const STANDARD_2_OF_5 = "Standard 2 of 5";
    const STANDARD_2_OF_5_CHECK_DIGIT = "Standard 2 of 5 (Check Digit)";
    const PHARMACODE = "Pharmacode";
    const PHARMACODE_TWO_TRACK = "Pharmacode Two-Track";
    const POSTNET = "POSTNET";
    const PLANET = "PLANET";
    const RMS4CC = "RMS4CC";
    const UPC_A = "UPC-A";
    const UPC_E = "UPC-E";

    // Two dimensional
    const DATA_MATRIX = "Data Matrix";
    const PDF417 = "PDF417";
    const QR_CODE = "QR CODE";
}
```

## Requirements

- Barcodes requires ImageMagick to create PNGs in PHP 5.3.
- Barcodes requires PHP bcmath extension for Intelligent Mail barcodes
