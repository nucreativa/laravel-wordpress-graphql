<?php

namespace LaravelWordpressGraphQL\Inputs;

use GraphQL;
use Folklore\GraphQL\Support\InputType;
use GraphQL\Type\Definition\Type;

/**
 * A class to serve GraphQL API pagination input.
 * Must register in config/graphql.php files under 'types' configuration.
 *
 * @author Fanny Irawan Sutawanir (fannyirawans@gmail.com)
 *  _               _     _     _           _       _
 * | |_ ___ ___ ___| |___| |_  |_|___ _____| |_ _ _| |_
 * | '_| -_|_ -| -_| | -_| '_| | | -_|     | . | | |  _|
 * |_,_|___|___|___|_|___|_,_|_| |___|_|_|_|___|___|_|
 *                           |___|
 */
class PaginationInput extends InputType {

    const DEFAULT_PAGE = 1;
    const DEFAULT_PERPAGE = 10;

    protected $attributes = [
        'name'        => 'PaginationInput',
        'description' => 'Pagination input'
    ];

    /** {@inheritdoc} */
    public function fields() {
        return [
            'page' => [
                'type' => Type::int(),
                'description' => 'Current page value',
            ],
            'per_page' => [
                'type' => Type::int(),
                'description' => 'Per page row limit value',
            ],
            'sort_by' => [
                'type' => Type::string(),
                'description' => 'Contains sorting by column name value',
            ],
            'sort_type' => [
                'type' => GraphQL::type('SortType'),
                'description' => 'Contains sorting type value',
            ]
        ];
    }

}