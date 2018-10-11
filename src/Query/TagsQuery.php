<?php

namespace Nucreativa\LaravelWordpressGraphQL\Query;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Nucreativa\LaravelWordpressGraphQL\Helper\Paginates;
use Nucreativa\LaravelWordpressModels\Models\Term;
use Nucreativa\LaravelWordpressModels\Models\TermTaxonomy;

class TagsQuery extends Query {
	protected $attributes = [
		'name' => 'tags'
	];

	public function type() {
		return Type::listOf( GraphQL::type( 'Tag' ) );
	}

	public function args() {
		return [
			'id'                      => [ 'name' => 'id', 'type' => Type::string() ],
			'name'                    => [ 'name' => 'name', 'type' => Type::string() ],
			'slug'                    => [ 'name' => 'slug', 'type' => Type::string() ],
			Paginates::PAGINATION_KEY => [
				'name' => Paginates::PAGINATION_KEY,
				'type' => GraphQL::type( 'PaginationInput' )
			],
		];
	}

	public function resolve( $root, $args ) {
		if ( isset( $args['id'] ) ) {
			$builder = Term::on( 'wordpress' )->where( 'term_id', $args['id'] );
		} else if ( isset( $args['name'] ) ) {
			$builder = Term::on( 'wordpress' )->where( 'name', $args['name'] );
		} else if ( isset( $args['slug'] ) ) {
			$builder = Term::on( 'wordpress' )->where( 'slug', $args['slug'] );
		} else {
			$builder = TermTaxonomy::on( 'wordpress' )->where( 'taxonomy', 'post_tag' );
		}

		return Paginates::paginate( $builder, $args );
	}
}