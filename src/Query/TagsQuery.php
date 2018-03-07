<?php

namespace LaravelWordpressGraphQL\Query;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use LaravelWordpressModels\Models\TermTaxonomy;

class TagsQuery extends Query {
	protected $attributes = [
		'name' => 'tags'
	];

	public function type() {
		return Type::listOf( GraphQL::type( 'Tag' ) );
	}

	public function args() {
		return [
			'id'   => [ 'name' => 'id', 'type' => Type::string() ],
			'name' => [ 'name' => 'name', 'type' => Type::string() ],
			'slug' => [ 'name' => 'slug', 'type' => Type::string() ],
		];
	}

	public function resolve( $root, $args ) {
		return TermTaxonomy::on('wordpress')->where( 'taxonomy', 'post_tag' )->get();
	}
}