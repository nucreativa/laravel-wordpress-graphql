<?php

namespace LaravelWordpressGraphQL\Query;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use LaravelWordpressModels\Models\Comment;

class CommentsQuery extends Query {
	protected $attributes = [
		'name' => 'comments'
	];

	public function type() {
		return Type::listOf( GraphQL::type( 'Comment' ) );
	}

	public function args() {
		return [
			'id'      => [ 'name' => 'id', 'type' => Type::string() ],
			'post_id' => [ 'name' => 'post_id', 'type' => Type::string() ],
		];
	}

	public function resolve( $root, $args ) {
		if ( isset( $args['id'] ) ) {
			return Comment::on('wordpress')->where( 'comment_ID', $args['id'] )->get();
		} else if ( isset( $args['post_id'] ) ) {
			return Comment::on('wordpress')->where( 'comment_post_ID', $args['post_id'] )->get();
		} else {
			return Comment::on('wordpress')->all();
		}
	}
}