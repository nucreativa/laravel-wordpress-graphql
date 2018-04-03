<?php

namespace LaravelWordpressGraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use LaravelWordpressGraphQL\Helper\Paginates;
use LaravelWordpressModels\Models\TermTaxonomy;

class CategoriesQuery extends Query {

    const DEFAULT_PAGE = 1;
    const DEFAULT_PERPAGE = 10;

    protected $attributes = [
        'name' => 'categories'
    ];

    public function type() {
        return Type::listOf( GraphQL::type( 'Category' ) );
    }

    public function args() {
        return [
            'id'   => [ 'name' => 'id', 'type' => Type::string() ],
            'slug' => [ 'name' => 'slug', 'type' => Type::string() ],
            Paginates::PAGINATION_KEY => [ 'name' => Paginates::PAGINATION_KEY, 'type' => GraphQL::type('PaginationInput') ],
        ];
    }

    public function resolve( $root, $args ) {
        $builder = TermTaxonomy::on('wordpress')->where( 'taxonomy', 'category' );
        if(isset($args['id']) ) {
            $builder = $builder->where( 'term_id', $args['id']);
        }
        if(isset($args['slug']) ) {
            $builder = $builder->where( 'slug', $args['slug']);
        }

        return Paginates::paginate($builder, $args);
    }

}
