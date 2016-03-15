<?php

namespace DavidVerholen\DynamicComponentRegistry\Api\Data;

interface ComponentInterface
{
    const COMPONENT_ID = 'component_id';
    const NAME = 'name';
    const TYPE = 'type';
    const PATH = 'path';
    const STATUS = 'status';

    /**
     * @return integer
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return integer
     */
    public function getType();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return integer
     */
    public function getStatus();

    /**
     * @param $name
     *
     * @return ComponentInterface
     */
    public function setName($name);

    /**
     * @param $type
     *
     * @return ComponentInterface
     */
    public function setType($type);

    /**
     * @param $path
     *
     * @return ComponentInterface
     */
    public function setPath($path);

    /**
     * @param $status
     *
     * @return ComponentInterface
     */
    public function setStatus($status);
}
