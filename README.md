# SGKBarcodeBundle

SGKBarcodeBundle is the Symfony2 Barcode Generator Bundle which you want!

Features:

1. Support 3 two-dimensional and 30 one-dimensional Barcode types
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

To generate a barcode, you have 5 options can be configured.

|option|type   |required|allowed values|desccription                |
|------|:-----:|:------:|:------------:|:---------------------------:|
|code  |string |required|              |what you want encoded|
|type  |string |required|[Read Supported Types](#supported-barcode-types)|type of barcode|
|format|string |required|html, svg, png|output format|
|width |**integer**|optional|              |width of units|
|height|**integer**|optional|              |height of units|
|color |string for html, svg / array for png|optional|[HTML Color Names](http://www.w3schools.com/html/html_colornames.asp) / array(R, G, B)|Barcode color|

## Usage with service
  
The bundle registers one service: ``sgk_barcode.generator`` which will allows you to generate barcode:

outpout html
```php
$options = array(
    'code'   => 'string to encode',
    'type'   => 'c128',
    'format' => 'html',
);

$barcode =
    $this->get('tms_barcode_generator')->generate($options);
    
echo $barcode;
```

outpout svg
```php
$options = array(
    'code'   => 'string to encode',
    'type'   => 'qrcode',
    'format' => 'svg',
    'width'  => 10,
    'height' => 10,
    'color'  => 'green',
);

$barcode =
    $this->get('tms_barcode_generator')->generate($options);
    
echo $barcode;
```

outpout png
```php
$options = array(
    'code'   => 'string to encode',
    'type'   => 'datamatrix',
    'format' => 'png',
    'width'  => 10,
    'height' => 10,
    'color'  => array(127, 127, 127),
);

$barcode =
    $this->get('tms_barcode_generator')->generate($options);
    
echo '<img src="data:image/png;base64,'.$barcode.'" />';
```
note: for format png, the generator return the based64 of png file, so we use [Data URI scheme](http://en.wikipedia.org/wiki/Data_URI_scheme) to display the png in webpage.

## Usage in Twig template

This bundle extend one function of Twig ``barcode`` which you can simply use it to generate barcode in the twig template.

``barcode`` Twig fuction use the same options as the service function before, the only diffrent is your need pass a [Twig array](http://twig.sensiolabs.org/doc/templates.html#literals) in the function.

display html

```twig
{{ barcode({code: 'string to encode', type: 'c128', format: 'html'}) }}
```

display svg

```twig
{{ barcode({code: 'string to encode', type: 'qrcode', format: 'svg', width: 10, height: 10, color: 'green'}) }}
```

display png

```twig
<img src="data:image/png;base64,
{{ barcode({code: 'string to encode', type: 'datamatrix', format: 'png', width: 10, height: 10, color: [127, 127, 127]}) }}
" />
```

## Supported Barcode Types


## Requirements

- Barcodes requires ImageMagick to create PNGs in PHP 5.3.
- Barcodes requires PHP bcmath extension for Intelligent Mail barcodes
