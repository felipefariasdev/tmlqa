<?php
namespace Model\Compomentes;
use ReflectionClass;

class JsonEncodePrivate {

    public static function execute($object) {
        $public = [];
        $reflection = new ReflectionClass($object);
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $public[$property->getName()] = $property->getValue($object);
        }
        return ($public);
    }


} 