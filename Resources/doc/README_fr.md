# SGKBarcodeBundle

[![Build Status](https://travis-ci.org/shangguokan/SGKBarcodeBundle.svg)](https://travis-ci.org/shangguokan/SGKBarcodeBundle)
[![Latest Stable Version](https://poser.pugx.org/sgk/barcode-bundle/v/stable.svg)](https://packagist.org/packages/sgk/barcode-bundle)
[![Total Downloads](https://poser.pugx.org/sgk/barcode-bundle/downloads.svg)](https://packagist.org/packages/sgk/barcode-bundle)
[![License](https://poser.pugx.org/sgk/barcode-bundle/license.svg)](https://packagist.org/packages/sgk/barcode-bundle)

SGKBarcodeBundle est un Symfony2 Bundle pour l’objet de générer tous les types de code-barres !
Ce README document ont aussi une version Anglaise ([English]( https://github.com/shangguokan/SGKBarcodeBundle)) et une version Chinoise ([中文]( README_zh-CN.md)).

Caractéristiques:

1. Capable de générer 3 types de codes-barres bidimensionnels (2D) et 30 types de codes-barres unidimensionnels (1D)
2. Trois formats de sortie : HTML, PNG and SVG canvas
3. Twig intégration: vous pouvez directement utiliser une Twig fonction dans le Template pour générer les codes-barres
4. Ce Bundle est un portage depuis le Laravel project: [dinesh/barcode](https://github.com/dineshrabara/barcode)

![SGKBarcodeBundle](Resources/doc/README.png)

## Installation

Ajoutez SGKBarcodeBundle via exécuter le command:
```sh
$ php composer.phar require sgk/barcode-bundle:dev-master
```

Ou ajoutez la dépendance de  SGKBarcodeBundle à votre fichier ``composer.json``, puis Mettez à jour les bibliothèques vendor : ``php composer.phar update``
```json
"require": {
        "sgk/barcode-bundle": "dev-master"
    }
```

Composer téléchargera automatiquement tous les fichiers requis, et les installera pour vous sous le répertoire vendor/sgk.

Ensuite, comme pour tout autre bundle, incluez dans votre classe Kernel: 
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

## Paramètres de génération

Vous avez 5 paramètres (options) à choisir pour la génération d’un code-barres

|option|type       |required|allowed values|description          |
|:----:|:---------:|:------:|:------------:|:-------------------:|
|code  |string     |required|              |what you want encoded|
|type  |string     |required|[Supported Types](#type-de-code-barres-disponible)|type of barcode|
|format|string     |required|html, svg, png|output format|
|width |**integer**|optional|              |**width of unit**|
|height|**integer**|optional|              |**height of unit**|
|color |string for html, svg / array for png|optional|[HTML Color Names](http://www.w3schools.com/html/html_colornames.asp) / array(R, G, B)|Barcode color|

> Default width and height for two-dimensional are 5, 5, for one-dimensional are 2, 30.
> Default color for html, svg is black, for png is array(0, 0, 0)

## Utilisation par service
  
Ce bundle crée un service ``sgk_barcode.generator``  dans le Conteneur, cela vous permettez de l’utiliser pour générer le code-barres d’une façon très simple.

* outpout html
```php
$options = array(
    'code'   => 'string to encode',
    'type'   => 'c128',
    'format' => 'html',
);

$barcode =
    $this->get('sgk_barcode.generator')->generate($options);
    
return new Response($barcode);
```

* outpout svg
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
    $this->get('sgk_barcode.generator')->generate($options);
    
return new Response($barcode);
```

* outpout png
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
    $this->get('sgk_barcode.generator')->generate($options);
    
$barcode = '<img src="data:image/png;base64,'.$barcode.'" />';

return new Response($barcode);
```
> For format png, the generator return the based64 of png file, so we use [Data URI scheme](http://en.wikipedia.org/wiki/Data_URI_scheme) to display the png in webpage.

## Utilisation dans le Twig Template

Ce bundle crée une fonction de Twig ``barcode`` que vous pouvez l’utiliser directement dans le Twig Template.

``barcode`` prend les mêmes paramètres (options), le seul chose différente est que vous besoin de passer un [Twig tableau](http://twig.sensiolabs.org/doc/templates.html#literals) (qui vraiment ressemble à Json, mais il n’est pas) dans la fonction.

* display html
```twig
{{ barcode({code: 'string to encode', type: 'c128', format: 'html'}) }}
```

* display svg
```twig
{{ barcode({code: 'string to encode', type: 'qrcode', format: 'svg', width: 10, height: 10, color: 'green'}) }}
```

* display png
```twig
<img src="data:image/png;base64,
{{ barcode({code: 'string to encode', type: 'datamatrix', format: 'png', width: 10, height: 10, color: [127, 127, 127]}) }}
" />
```

## Enregistrer les codes-barres dans les fichiers

Comme vous avez vu, ce Bundle n’enregistre rien sur vos ordinateurs, mais si vous voulez les enregistrer, il n’y aura pas de problème !

* save as html
```php
$savePath = '/tmp/';
$fileName = 'sample.html';

file_put_contents($savePath.$fileName, $barcode);
```

* save as svg
```php
$savePath = '/tmp/';
$fileName = 'sample.svg';

file_put_contents($savePath.$fileName, $barcode);
```

* save as png
```php
$savePath = '/tmp/';
$fileName = 'sample.png';

file_put_contents($savePath.$fileName, base64_decode($barcode));
```

## Type de code-barres disponible

Jetez un coup d'œil à [Wikipedia page](http://en.wikipedia.org/wiki/Barcode) pour savoir quel type vous devez choisir. 

### 2d barcodes

|type      |Name                                                   |Example(encode 123456)|
|:--------:|:-----------------------------------------------------:|:--------------------:|
|qrcode    |[QR code](http://en.wikipedia.org/wiki/QR_code)        |![](Resources/doc/barcode/qrcode.png)|
|pdf417    |[PDF417](http://en.wikipedia.org/wiki/PDF417)          |![](Resources/doc/barcode/pdf417.png)|
|datamatrix|[Data Matrix](http://en.wikipedia.org/wiki/Data_Matrix)|![](Resources/doc/barcode/datamatrix.png)|

### 1d barcodes

|type    |Symbology                                              |Example(encode 123456)|
|:------:|:-----------------------------------------------------:|:--------------------:|
|c39     |[Code 39](http://en.wikipedia.org/wiki/Code_39)        |![](Resources/doc/barcode/c39.png)|
|c39+    |Code 39 CHECK_DIGIT                                    |![](Resources/doc/barcode/c39+.png)|
|c39e    |Code 39 EXTENDED                                       |![](Resources/doc/barcode/c39e.png)|
|c39e+   |Code 39 EXTENDED CHECK_DIGIT                           |![](Resources/doc/barcode/c39e+.png)|
|c93     |[Code 93](http://en.wikipedia.org/wiki/Code_93)        |![](Resources/doc/barcode/c93.png)|
|s25     |[Standard 2 of 5](http://www.barcodeisland.com/2of5.phtml)           |![](Resources/doc/barcode/s25.png)|
|s25+    |Standard 2 of 5 CHECK_DIGIT                                          |![](Resources/doc/barcode/s25+.png)|
|i25     |[Interleaved 2 of 5](http://en.wikipedia.org/wiki/Interleaved_2_of_5)|![](Resources/doc/barcode/i25.png)|
|i25+    |Interleaved 2 of 5 CHECK_DIGIT                                       |![](Resources/doc/barcode/i25+.png)|
|c128    |[Code 128](http://en.wikipedia.org/wiki/Code_128)                    |![](Resources/doc/barcode/c128.png)|
|c128a   |Code 128A|![](Resources/doc/barcode/c128a.png)|
|c128b   |Code 128B|![](Resources/doc/barcode/c128b.png)|
|c128c   |Code 128C|![](Resources/doc/barcode/c128c.png)|
|ean2    |[EAN 2](http://en.wikipedia.org/wiki/EAN_2)                 |![](Resources/doc/barcode/ean2.png)|
|ean5    |[EAN 5](http://en.wikipedia.org/wiki/EAN_5)                 |![](Resources/doc/barcode/ean5.png)|
|ean8    |[EAN 8](http://en.wikipedia.org/wiki/EAN-8)                 |![](Resources/doc/barcode/ean8.png)|
|ean13   |[EAN 13](http://en.wikipedia.org/wiki/EAN-13)               |![](Resources/doc/barcode/ean13.png)|
|upca    |[UPC-A](http://en.wikipedia.org/wiki/Universal_Product_Code)|![](Resources/doc/barcode/upca.png)|
|upce    |[UPC-B](http://en.wikipedia.org/wiki/Universal_Product_Code)|![](Resources/doc/barcode/upce.png)|
|msi     |[MSI](http://en.wikipedia.org/wiki/MSI_Barcode)             |![](Resources/doc/barcode/msi.png)|
|msi+    |MSI CHECK_DIGIT                                             |![](Resources/doc/barcode/msi+.png)|
|postnet |[POSTNET](http://en.wikipedia.org/wiki/POSTNET)             |![](Resources/doc/barcode/postnet.png)|
|planet  |[PLANET](http://en.wikipedia.org/wiki/Postal_Alpha_Numeric_Encoding_Technique)|![](Resources/doc/barcode/planet.png)|
|rms4cc|[RMS4CC](http://en.wikipedia.org/wiki/RM4SCC)    |![](Resources/doc/barcode/rms4cc.png)|
|kix     |[KIX-code](http://nl.wikipedia.org/wiki/KIX-code)|![](Resources/doc/barcode/kix.png)|
|imb     |[IM barcode](http://en.wikipedia.org/wiki/Intelligent_Mail_barcode)|![](Resources/doc/barcode/imb.png)|
|codabar |[Codabar](http://en.wikipedia.org/wiki/Codabar)                    |![](Resources/doc/barcode/codabar.png)|
|code11  |[Code 11](http://en.wikipedia.org/wiki/Code_11)                    |![](Resources/doc/barcode/code11.png)|
|pharma  |[Pharmacode](http://en.wikipedia.org/wiki/Pharmacode)              |![](Resources/doc/barcode/pharma.png)|
|pharma2t|Pharmacode Two-Track                                               |![](Resources/doc/barcode/pharma2t.png)|

## Dépendance

Si vous avez rencontré quelque problème de dépendance, vérifierez que vous avez bien installé les deux extensions de PHP (dans phpinfo()).

- [ImageMagick](http://php.net/manual/en/book.imagick.php) pour créer les PNGs sous PHP 5.3.
- [PHP bcmath](http://php.net/manual/en/book.bc.php) extension pour générer le format Intelligent Mail barcodes (IMB)

## Tests

Exécuter les tests unitaires:
```sh
$ phpunit --coverage-text
```
