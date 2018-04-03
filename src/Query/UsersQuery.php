<?php

namespace LaravelWordpressGraphQL\Query;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use LaravelWordpressGraphQL\Helper\Paginates;
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
			'id'                      => [ 'name' => 'id', 'type' => Type::string() ],
			'username'                => [ 'name' => 'username', 'type' => Type::string() ],
			'email'                   => [ 'name' => 'email', 'type' => Type::string() ],
			Paginates::PAGINATION_KEY => [
				'name' => Paginates::PAGINATION_KEY,
				'type' => GraphQL::type( 'PaginationInput' )
			],
		];
	}

	public function resolve( $root, $args ) {

		if ( isset( $args['id'] ) ) {
			$builder = User::on( 'wordpress' )->type( 'post' )->where( 'ID', $args['id'] );
		} else if ( isset( $args['username'] ) ) {
			$builder = User::on( 'wordpress' )->where( 'user_login', $args['username'] );
		} else if ( isset( $args['email'] ) ) {
			$builder = User::on( 'wordpress' )->where( 'user_email', $args['email'] );
		} else {
			$builder = User::on( 'wordpress' );
		}

		return Paginates::paginate( $builder, $args );
	}
}
