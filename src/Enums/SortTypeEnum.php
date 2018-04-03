<?php

namespace LaravelWordpressGraphQL\Enums;

use Folklore\GraphQL\Support\EnumType;

/**
 * Provides enum for GraphQL pagination sorting parameters.
 * Must register in config/graphql.php files under 'types' configuration.
 *
 * @author Fanny Irawan Sutawanir (fannyirawans@gmail.com)
 *  _               _     _     _           _       _
 * | |_ ___ ___ ___| |___| |_  |_|___ _____| |_ _ _| |_
 * | '_| -_|_ -| -_| | -_| '_| | | -_|     | . | | |  _|
 * |_,_|___|___|___|_|___|_,_|_| |___|_|_|_|___|___|_|
 *                           |___|
 */
class SortTypeEnum extends EnumType {

    const ASC = 'asc';
    const DESC = 'desc';
    const DEFAULT_TYPE = self::DESC;

    protected $attributes = [
        'name' => 'SortTypeEnum',
        'description' => 'An enum for Order By'
    ];

    /** {@inheritdoc} */
    public function values() {
        return [
            self::ASC => self::ASC,
            self::DESC => self::DESC,
        ];
    }

}
