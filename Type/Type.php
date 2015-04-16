<?php

namespace SGK\BarcodeBundle\Type;

/**
 * Class BarcodeType
 * Supported standards of barcode
 *
 * @package SGK\BarcodeBundle\Type
 */
class BarcodeType
{
    /**
     * @var array oneDimensionalBarcodeType
     */
    public static $oneDimensionalBarcodeType = array(
        'C39',
        'C39+',
        'C39E',
        'C39E+',
        'C93',
        'S25',
        'S25+',
        'I25',
        'I25+',
        'C128',
        'C128A',
        'C128B',
        'C128C',
        'EAN2',
        'EAN5',
        'EAN8',
        'EAN13',
        'UPCA',
        'UPCE',
        'MSI',
        'MSI+',
        'POSTNET',
        'PLANET',
        'RMS4CC',
        'KIX',
        'IMB',
        'CODABAR',
        'CODE11',
        'PHARMA',
        'PHARMA2T',
    );

    /**
     * @var array twoDimensionalBarcodeType
     */
    public static $twoDimensionalBarcodeType = array(
        'QRCODE',
        'PDF417',
        'DATAMATRIX',
    );

    /**
     * @param string $type type of barcode
     *
     * @return string
     */
    public static function getDimension($type)
    {
        if (!self::hasType($type)) {
            throw new \InvalidArgumentException("Type of Barcode is not supported.");
        }

        if (in_array($type, self::$twoDimensionalBarcodeType)) {
            return '2D';
        } else {
            return '1D';
        }
    }

    /**
     * @param string $type type of barcode
     *
     * @return bool
     */
    public static function hasType($type)
    {
        return in_array($type, self::$oneDimensionalBarcodeType) || in_array($type, self::$twoDimensionalBarcodeType);
    }
}
