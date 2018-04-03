<?php

namespace LaravelWordpressGraphQL\Mutation;


use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use LaravelWordpressModels\Models\Post;

class UpdateStatusPostMutation extends Mutation {
	protected $attributes = [
		'name'        => 'UpdateStatusPostMutation',
		'description' => 'A mutation'
	];

	public function type() {
		return GraphQL::type( 'Post' );
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
				'type'  => GraphQL::type( 'PostStatus' ),
				'rules' => [ 'required' ]
			]
		];
	}

	public function resolve( $root, $args, $context, ResolveInfo $info ) {
		$post = Post::on( 'wordpress' )->type( 'post' )
		            ->where( 'id', $args['id'] )
		            ->first();

		if ( ! $post ) {
			return null;
		}

		$post->post_status = $args['status'];
		$post->update();

		return $post;
	}
}
