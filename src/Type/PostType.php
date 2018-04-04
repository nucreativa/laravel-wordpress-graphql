<?php

namespace LaravelWordpressGraphQL\Type;


use Folklore\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use LaravelWordpressGraphQL\Helper\ErtCalculator;

class PostType extends GraphQLType {
	protected $attributes = [
		'name'        => 'Post',
		'description' => 'A post'
	];

	public function fields() {
		return [
			'id'          => [
				'type'        => Type::nonNull( Type::string() ),
				'description' => 'The id of the post'
			],
			'title'       => [
				'type'        => Type::string(),
				'description' => 'The title of the post'
			],
			'content'     => [
				'type'        => Type::string(),
				'description' => 'The content of the post'
			],
			'slug'        => [
				'type'        => Type::string(),
				'description' => 'The slug of the post'
			],
			'status'      => [
				'type'        => GraphQL::type( 'PostStatus' ),
				'description' => 'The status of the post'
			],
			'date'        => [
				'type'        => Type::string(),
				'description' => 'The date of the post'
			],
			'categories'  => [
				'type'        => Type::listOf( GraphQL::type( 'Category' ) ),
				'description' => 'The categories of the post',
			],
			'tags'        => [
				'type'        => Type::listOf( GraphQL::type( 'Tag' ) ),
				'description' => 'The tags of the post',
			],
			'comments'    => [
				'type'        => Type::listOf( GraphQL::type( 'Comment' ) ),
				'description' => 'The comments of the post',
			],
			'attachments' => [
				'type'        => Type::listOf( GraphQL::type( 'Attachment' ) ),
				'description' => 'The attachments of the post',
			],
			'author'      => [
				'type'        => GraphQL::type( 'User' ),
				'description' => 'The author of the post',
			],
            'estimated_read_time' => [
                'type'        => Type::string(),
                'description' => 'Post content estimated reading time',
            ],
		];
	}

	protected function resolveIdField( $root, $args ) {
		return $root->ID;
	}

	protected function resolveTitleField( $root, $args ) {
		return $root->post_title;
	}

	protected function resolveContentField( $root, $args ) {
		return $root->post_content;
	}

	protected function resolveSlugField( $root, $args ) {
		return $root->post_name;
	}

	protected function resolveStatusField( $root, $args ) {
		return $root->post_status;
	}

	protected function resolveDateField( $root, $args ) {
		return $root->post_date;
	}

    protected function resolveEstimatedReadTimeField( $root, $args ) {
        return ErtCalculator::begin($root->post_content)->getMinuteText();
    }

}