<?php

namespace Nucreativa\LaravelWordpressGraphQL\Mutation;


use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Nucreativa\LaravelWordpressModels\Models\Comment;

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
		$comment = Comment::on( 'wordpress' )->find( $args['id'] );

		if ( ! $comment ) {
			return null;
		}

		$comment->comment_approved = $args['status'];
		$comment->update();

		return $comment;
	}
}
