<?php

namespace LaravelWordpressGraphQL\Type;


use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class AttachmentType extends GraphQLType {
	protected $attributes = [
		'name'        => 'Attachment',
		'description' => 'A attachment'
	];

	public function fields() {
		return [
			'id'        => [
				'type'        => Type::nonNull( Type::string() ),
				'description' => 'The id of the attachment'
			],
			'title'     => [
				'type'        => Type::string(),
				'description' => 'The title of the attachment'
			],
			'status'    => [
				'type'        => Type::string(),
				'description' => 'The status of the attachment'
			],
			'date'      => [
				'type'        => Type::string(),
				'description' => 'The date of the attachment'
			],
			'url'       => [
				'type'        => Type::string(),
				'description' => 'The url of the attachment'
			],
			'mime_type' => [
				'type'        => Type::string(),
				'description' => 'The mime type of the attachment'
			],
		];
	}

	protected function resolveIdField( $root, $args ) {
		return $root->ID;
	}

	protected function resolveTitleField( $root, $args ) {
		return $root->post_title;
	}

	protected function resolveStatusField( $root, $args ) {
		return $root->post_status;
	}

	protected function resolveDateField( $root, $args ) {
		return $root->post_date;
	}

	protected function resolveUrlField( $root, $args ) {
		return $root->guid;
	}

	protected function resolveMimeTypeField( $root, $args ) {
		return $root->post_mime_type;
	}
}