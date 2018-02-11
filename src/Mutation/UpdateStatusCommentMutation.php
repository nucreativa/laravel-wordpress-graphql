<?php

namespace LaravelWordpressGraphQL\Mutation;


use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use LaravelWordpressModels\Models\Comment;

class UpdateStatusCommentMutation extends Mutation {
	protected $attributes = [
		'name'        => 'UpdateStatusCommentMutation',
		'description' => 'A mutation'
	];

	public function type() {
		return GraphQL::type( 'Comment' );
	}

	public function args() {
		return [
			'id'     => [
				'name'  => 'id',
				'type'  => Type::string(),
				'rules' => [ 'required' ]
			],
			'status' => [
				'name'  => 'status',
				'type'  => GraphQL::type( 'CommentStatus' ),
				'rules' => [ 'required' ]
			]
		];
	}

	public function resolve( $root, $args, $context, ResolveInfo $info ) {
		$comment = Comment::find( $args['id']);

		if ( ! $comment ) {
			return null;
		}

		$comment->comment_approved = $args['status'];
		$comment->update();

		return $comment;
	}
}
