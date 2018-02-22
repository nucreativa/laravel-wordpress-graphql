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
			'id'     => [ 'name' => 'id', 'type' => Type::string() ],
			'slug'   => [ 'name' => 'slug', 'type' => Type::string() ],
			'status' => [ 'name' => 'status', 'type' => GraphQL::type( 'PostStatus' ) ]
		];
	}

	public function resolve( $root, $args = [] ) {
		$post = Post::type( 'post' );
		if ( isset( $args['status'] ) ) {
			$post = $post->where( 'post_status', $args['status'] );
		}
		if ( isset( $args['id'] ) ) {
			$post = $post->where( 'ID', $args['id'] );
		} else if ( isset( $args['slug'] ) ) {
			$post = $post->where( 'post_name', $args['slug'] );
		}

		return $post->get();
	}
}
