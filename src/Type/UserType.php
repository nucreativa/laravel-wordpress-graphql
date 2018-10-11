<?php

namespace Nucreativa\LaravelWordpressGraphQL\Type;


use Folklore\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType {

    const GRAVATAR_BASE_URL = 'https://secure.gravatar.com/avatar';

	protected $attributes = [
		'name'        => 'User',
		'description' => 'A user'
	];

	public function fields() {
		return [
			'id'       => [
				'type'        => Type::nonNull( Type::string() ),
				'description' => 'The id of the user'
			],
			'username' => [
				'type'        => Type::string(),
				'description' => 'The username of the user'
			],
			'name'     => [
				'type'        => Type::string(),
				'description' => 'The name of the user'
			],
			'email'    => [
				'type'        => Type::string(),
				'description' => 'The email of the user'
			],
			'status'   => [
				'type'        => Type::string(),
				'description' => 'The status of the user'
			],
			'posts'    => [
				'type'        => Type::listOf( GraphQL::type( 'Post' ) ),
				'description' => 'The posts of the user',
			],
			'comments' => [
				'type'        => Type::listOf( GraphQL::type( 'Comment' ) ),
				'description' => 'The comments of the user',
			],
            'image_url' => [
                'type'        => Type::string(),
                'description' => 'The image of the user'
            ]
		];
	}

	protected function resolveIdField( $root, $args ) {
		return $root->ID;
	}

	protected function resolveUsernameField( $root, $args ) {
		return $root->user_login;
	}

	protected function resolveNameField( $root, $args ) {
		return $root->user_nicename;
	}

	protected function resolveEmailField( $root, $args ) {
		return $root->user_email;
	}

	protected function resolveStatusField( $root, $args ) {
		return $root->user_status;
	}

	protected function resolveImageUrlField($root, $args) {
	    // Currently only handle gravatar image url
        return self::GRAVATAR_BASE_URL.'/'.md5($root->user_email);
    }
}