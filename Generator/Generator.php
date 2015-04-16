<?php

namespace SGK\BarcodeBundle\Generator;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;
use SGK\BarcodeBundle\Type\BarcodeType;
use Dinesh\Barcode\DNS1D;
use Dinesh\Barcode\DNS2D;

/**
 * Class Generator
 * Encapsulation of project https://github.com/dineshrabara/barcode for Symfony2 usage
 *
 * @package SGK\BarcodeBundle\Generator
 */
class Generator
{
    /**
     * @var DNS2D
     */
    protected $dns2d;

    /**
     * @var DNS1D
     */
    protected $dns1d;

    /**
     * @var OptionsResolver
     */
    protected $resolver;

    /**
     * @var array
     */
    protected $formatFunctionMap = array(
        'svg'  => 'getBarcodeSVG',
        'html' => 'getBarcodeHTML',
        'png'  => 'getBarcodePNG',
    );

    /**
     * construct
     */
    public function __construct()
    {
        $this->dns2d = new DNS2D();
        $this->dns1d = new DNS1D();
        $this->resolver = new OptionsResolver();
        $this->configureOptions($this->resolver);
    }

    /**
     * @param string $code   code to print
     * @param string $type   type of barcode
     * @param string $format output format
     * @param int    $width  Minimum width of a single bar in user units.
     * @param int    $height Height of barcode in user units.
     * @param string $color  Foreground color (in SVG format) for bar elements (background is transparent).
     *
     * @return DNS2D | DNS1D
     */
    public function generate($code, $type, $format, $width = null, $height = null, $color = null)
    {
        $options = $this->resolver->resolve(array(
            'code'   => $code,
            'type'   => strtoupper($type),
            'format' => $format,
            'width'  => $width,
            'height' => $height,
            'color'  => $color,
        ));

        unset($options['format']);
        if (BarcodeType::getDimension($options['type']) == '2D') {
            return call_user_func_array(
                array(
                    $this->dns2d,
                    $this->formatFunctionMap[$options['format']],
                ),
                $options
            );
        } else {
            return call_user_func_array(
                array(
                    $this->dns1d,
                    $this->formatFunctionMap[$options['format']],
                ),
                $options
            );
        }
    }

    /**
     * Configure generate options
     *
     * @param OptionsResolverInterface $resolver
     */
    protected function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setAllowedTypes(array(
                'code'   => array('string'),
                'type'   => array('string'),
                'format' => array('string'),
                'width'  => array('integer'),
                'height' => array('integer'),
                'color'  => array('string', 'array'),
            ))
            ->setAllowedValues(array(
                'type'   => array_merge(
                    BarcodeType::$oneDimensionalBarcodeType,
                    BarcodeType::$twoDimensionalBarcodeType
                ),
                'format' => array('html', 'png', 'svg'),
            ));
    }
}
