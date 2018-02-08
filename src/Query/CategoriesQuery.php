<?php

namespace LaravelWordpressGraphQL\Query;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use LaravelWordpressModels\Models\TermTaxonomy;

class CategoriesQuery extends Query {
	protected $attributes = [
		'name' => 'categories'
	];

	public function type() {
		return Type::listOf( GraphQL::type( 'Category' ) );
	}

	public function args() {
		return [
			'id'   => [ 'name' => 'id', 'type' => Type::string() ],
			'name' => [ 'name' => 'name', 'type' => Type::string() ],
			'slug' => [ 'name' => 'slug', 'type' => Type::string() ],
			'menu' => [ 'name' => 'menu', 'type' => Type::string() ],
		];
	}

	public function resolve( $root, $args ) {
		return TermTaxonomy::where( 'taxonomy', 'category' )->get();
	}
}
