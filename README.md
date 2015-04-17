# SGKBarcodeBundle

SGKBarcodeBundle is the Symfony2 Barcode Generator Bundle which you want!

    Features:
    1. Barcode generator for 3 two-dimensional and 30 one-dimensional types
    2. Output three formats: HTML, PNG, or SVG canvas
    3. Twig integration: you can simply use a function extensional of Twig in the template to generate Barcode
    4. Core of this bundle use this laravel project: [dinesh/barcode](https://github.com/dineshrabara/barcode)

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

## Generate options

To generate un barcode, you have 5 options to set.

|option|type   |required|allowed values|desccription                |
|------|:-----:|:------:|:------------:|:---------------------------:|
|code  |string |required|              |string what you want encoded|
|type  |string |required|[read Supported Types](#supported-barcode-types)|type of barcode             |
|format|string |required|html, svg, png|output format               |
|width |integer|Optional|              |minimum width of a single bar in user units|
|height|integer|Optional|              |height of barcode in user units|
|color |string/array |Optional|[HTML Color Names](http://www.w3schools.com/html/html_colornames.asp)/RGB array(0,255,0)|color|

## Usage with service
  
The bundle registers one service: ``sgk_barcode.generator`` which will allows you to generate barcode:

```php
$barcode =
    $this->get('tms_barcode_generator')->generate($options);
```

## Usage in Twig template

This bundle extend two function of Twig which you can simply use to generate barcode,
now only format html is supported for Twig usage.

```

```

## Supported Barcode Types


## Requirements

- Barcodes requires ImageMagick to create PNGs in PHP 5.3.
- Barcodes requires PHP bcmath extension for Intelligent Mail barcodes
