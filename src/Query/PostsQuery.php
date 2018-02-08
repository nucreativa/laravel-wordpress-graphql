<?php

namespace App\GraphQL\Query;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;

class PostsQuery extends Query {
	protected $attributes = [
		'name' => 'posts'
	];

	public function type() {
		return Type::listOf( GraphQL::type( 'Post' ) );
	}

	public function args() {
		return [
			'id'      => [ 'name' => 'id', 'type' => Type::string() ],
			'title'   => [ 'name' => 'title', 'type' => Type::string() ],
			'content' => [ 'name' => 'content', 'type' => Type::string() ],
			'name'    => [ 'name' => 'name', 'type' => Type::string() ],
			'status'  => [ 'name' => 'status', 'type' => Type::string() ],
			'date'    => [ 'name' => 'date', 'type' => Type::string() ],
			'slug'    => [ 'name' => 'slug', 'type' => Type::string() ],
		];
	}
}
