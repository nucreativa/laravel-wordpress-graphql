<?php

namespace LaravelWordpressGraphQL\Type;


use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CategoryType extends GraphQLType {
	protected $attributes = [
		'name'        => 'Category',
		'description' => 'A category'
	];

	public function fields() {
		return [
			'id'   => [
				'type'        => Type::string(),
				'description' => 'The id of the category'
			],
			'name' => [
				'type'        => Type::string(),
				'description' => 'The name of the category'
			],
			'slug' => [
				'type'        => Type::string(),
				'description' => 'The slug of the category'
			]
		];
	}

	protected function resolveIdField( $root, $args ) {
		return @$root->term ? $root->term->term_id : $root->term_id;
	}

	protected function resolveNameField( $root, $args ) {
		return @$root->term ? $root->term->name : $root->name;
	}

	protected function resolveSlugField( $root, $args ) {
		return @$root->term ? $root->term->slug : $root->slug;
	}
}