<?php

namespace LaravelWordpressGraphQL\Query;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use LaravelWordpressModels\Models\User;

class UsersQuery extends Query {
	protected $attributes = [
		'name' => 'users'
	];

	public function type() {
		return Type::listOf( GraphQL::type( 'User' ) );
	}

	public function args() {
		return [
			'id'   => [ 'name' => 'id', 'type' => Type::string() ],
			'username' => [ 'name' => 'username', 'type' => Type::string() ],
			'email' => [ 'name' => 'email', 'type' => Type::string() ],
		];
	}

	public function resolve( $root, $args ) {

		if ( isset( $args['id'] ) ) {
			return Post::type( 'post' )->where( 'ID', $args['id'] )->get();
		} else if ( isset( $args['username'] ) ) {
			return User::where( 'user_login', $args['username'] )->get();
		} else if ( isset( $args['email'] ) ) {
			return User::where( 'user_email', $args['email'] )->get();
		} else {
			return User::all();
		}
	}
}
