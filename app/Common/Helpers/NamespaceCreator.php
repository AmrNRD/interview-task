<?php

namespace App\Common\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NamespaceCreator
{
    /**
     * Create Name Space for an entity
     *
     * @param [type] $domain
     * @param [type] $entity
     * @return string
     */
    public static function Entity($domain,$entity):string{
        $domain = Naming::class($domain);
        $entity = Naming::class($entity);
        $class = '\\App\\Domain\\'.$domain.'\\Entities\\'.$entity;

        return $class;
    }

    /**
     * Create Name Space for an entity
     *
     * @param [type] $domain
     * @param [type] $entity
     * @return string
     */
    public static function Segments(...$segments):string{

        $class = '\\'.join('\\',$segments);

        return $class;
    }

    /**
     * Create Name Space for an entity
     *
     * @param [type] $domain
     * @param [type] $entity
     * @return string
     */
    public static function table($domain,$entity):string{
        $class = self::Entity($domain,$entity);

        return with(new $class())->getTable();
    }


    /**
     * Create Name Space for an entity
     *
     * @param [type] $domain
     * @param [type] $entity
     * @return array
     */
    public static function fillables($domain,$entity):array{
        $class = self::Entity($domain,$entity);

        return with(new $class())->getFillable();
    }

}
