<?php
/**
 * SerializerFactory.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\DynamicComponentRegistry\Model;

use Doctrine\Common\Annotations\AnnotationRegistry;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

/**
 * Class SerializerFactory
 *
 * @category magento2
 * @package  DavidVerholen\DynamicComponentRegistry\Model
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class SerializerFactory
{
    /**
     * @var Serializer
     */
    protected static $instance = null;

    /**
     * @var SerializerBuilder
     */
    protected $serializerBuilder;

    /**
     * SerializerFactory constructor.
     *
     * @param SerializerBuilder $serializerBuilder
     */
    public function __construct(SerializerBuilder $serializerBuilder)
    {
        $this->serializerBuilder = $serializerBuilder;
    }

    /**
     * create
     *
     * @return Serializer
     */
    public function create()
    {
        AnnotationRegistry::registerLoader('class_exists');
        return $this->serializerBuilder->build();
    }

    /**
     * get
     *
     * @return Serializer
     */
    public function get()
    {
        if (null === static::$instance) {
            static::$instance = $this->create();
        }

        return static::$instance;
    }
}
