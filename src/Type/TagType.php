<?php

namespace Nucreativa\LaravelWordpressGraphQL\Type;


use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class TagType extends GraphQLType {
	protected $attributes = [
		'name'        => 'Tag',
		'description' => 'A tag'
	];

	public function fields() {
		return [
			'id'   => [
				'type'        => Type::string(),
				'description' => 'The id of the tag'
			],
			'name' => [
				'type'        => Type::string(),
				'description' => 'The name of the tag'
			],
			'slug' => [
				'type'        => Type::string(),
				'description' => 'The slug of the tag'
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