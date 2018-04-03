<?php

namespace LaravelWordpressGraphQL\Query;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use LaravelWordpressGraphQL\Helper\Paginates;
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
            Paginates::PAGINATION_KEY => [ 'name' => Paginates::PAGINATION_KEY, 'type' => GraphQL::type('PaginationInput') ],
		];
	}

	public function resolve( $root, $args ) {
		if ( isset( $args['id'] ) ) {
			$builder = Comment::on('wordpress')->where( 'comment_ID', $args['id'] );
		} else if ( isset( $args['post_id'] ) ) {
			$builder = Comment::on('wordpress')->where( 'comment_post_ID', $args['post_id'] );
		} else {
			$builder = Comment::on('wordpress');
		}

        return Paginates::paginate($builder, $args);
	}
}