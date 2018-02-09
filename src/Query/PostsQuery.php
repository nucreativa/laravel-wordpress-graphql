<?php

namespace LaravelWordpressGraphQL\Query;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use LaravelWordpressModels\Models\Post;

class PostsQuery extends Query {
	protected $attributes = [
		'name' => 'posts'
	];

	public function type() {
		return Type::listOf( GraphQL::type( 'Post' ) );
	}

	public function args() {
		return [
			'id'   => [ 'name' => 'id', 'type' => Type::string() ],
			'slug' => [ 'name' => 'slug', 'type' => Type::string() ],
		];
	}

	public function resolve( $root, $args = [] ) {
		if ( isset( $args['id'] ) ) {
			return Post::type( 'post' )->where( 'ID', $args['id'] )->get();
		} else if ( isset( $args['slug'] ) ) {
			return Post::type( 'post' )->where( 'post_name', $args['slug'] )->get();
		} else {
			return Post::type( 'post' )->get();
		}
	}
}
