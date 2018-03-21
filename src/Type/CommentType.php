<?php

namespace LaravelWordpressGraphQL\Type;


use Folklore\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CommentType extends GraphQLType {
	protected $attributes = [
		'name'        => 'Comment',
		'description' => 'A comment'
	];

	public function fields() {
		return [
			'id'           => [
				'type'        => Type::nonNull( Type::string() ),
				'description' => 'The id of the comment'
			],
			'post_id'      => [
				'type'        => Type::nonNull( Type::string() ),
				'description' => 'The id of the comment'
			],
			'author_name'  => [
				'type'        => Type::string(),
				'description' => 'The name of the author'
			],
			'author_email' => [
				'type'        => Type::string(),
				'description' => 'The email of the author'
			],
			'author_url'   => [
				'type'        => Type::string(),
				'description' => 'The url of the author'
			],
			'content'      => [
				'type'        => Type::string(),
				'description' => 'The content of the comment'
			],
			'status'       => [
				'type'        => GraphQL::type( 'CommentStatus' ),
				'description' => 'The status of the comment'
			],
			'date'         => [
				'type'        => Type::string(),
				'description' => 'The date of the comment'
			],
			'post'         => [
				'type'        => GraphQL::type( 'Post' ),
				'description' => 'The post of the comment',
			],
			'commentator'  => [
				'type'        => GraphQL::type( 'User' ),
				'description' => 'The author of the comment',
			],
			'child'        => [
				'type'        => Type::listOf( GraphQL::type( 'Comment' ) ),
				'description' => 'The child of the comment',
			],
		];
	}

	protected function resolveIdField( $root, $args ) {
		return $root->comment_ID;
	}

	protected function resolvePostIdField( $root, $args ) {
		return $root->comment_post_ID;
	}

	protected function resolveAuthorNameField( $root, $args ) {
		return $root->comment_author;
	}

	protected function resolveAuthorEmailField( $root, $args ) {
		return $root->comment_author_email;
	}

	protected function resolveAuthorUrlField( $root, $args ) {
		return $root->comment_author_url;
	}

	protected function resolveContentField( $root, $args ) {
		return $root->comment_content;
	}

	protected function resolveStatusField( $root, $args ) {
		return $root->comment_approved;
	}

	protected function resolveDateField( $root, $args ) {
		return $root->comment_date;
	}
}