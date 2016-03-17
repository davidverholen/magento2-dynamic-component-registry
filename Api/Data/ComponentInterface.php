<?php

namespace DavidVerholen\DynamicComponentRegistry\Api\Data;

interface ComponentInterface
{
    const COMPONENT_ID = 'component_id';
    const NAME = 'name';
    const TYPE = 'type';
    const PATH = 'path';
    const PSR4_PREFIX = 'psr4_prefix';
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
     * @return string
     */
    public function getPsr4Prefix();

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
     * @param $psr4Prefix
     *
     * @return ComponentInterface
     */
    public function setPsr4Prefix($psr4Prefix);

    /**
     * @param $status
     *
     * @return ComponentInterface
     */
    public function setStatus($status);
}
