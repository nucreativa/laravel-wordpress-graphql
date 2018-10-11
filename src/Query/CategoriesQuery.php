<?php

namespace Nucreativa\LaravelWordpressGraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Nucreativa\LaravelWordpressGraphQL\Helper\Paginates;
use Nucreativa\LaravelWordpressModels\Models\TermTaxonomy;

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
			'id'                      => [ 'name' => 'id', 'type' => Type::string() ],
			'slug'                    => [ 'name' => 'slug', 'type' => Type::string() ],
			Paginates::PAGINATION_KEY => [
				'name' => Paginates::PAGINATION_KEY,
				'type' => GraphQL::type( 'PaginationInput' )
			],

            // Exclude category ids retrieval
            'exclude_ids'             => [ 'name' => 'exclude_ids', 'type' => Type::listOf(Type::int() ) ],
		];
	}

	public function resolve( $root, $args ) {
		$builder = TermTaxonomy::on( 'wordpress' )->where( 'taxonomy', 'category' );
		if ( isset( $args['id'] ) ) {
			$builder = $builder->where( 'term_id', $args['id'] );
		}
		if ( isset( $args['slug'] ) ) {
			$builder = $builder->where( 'slug', $args['slug'] );
		}
        if ( isset($args['exclude_ids']) && !empty($args['exclude_ids'] ) ) {
            // Only proceed if exclude_ids data is set and not empty array
            $builder = $builder->whereNotIn('term_id', $args['exclude_ids']);
        }

		return Paginates::paginate( $builder, $args );
	}

}
