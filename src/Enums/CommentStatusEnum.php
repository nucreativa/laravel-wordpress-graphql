<?php

namespace LaravelWordpressGraphQL\Enums;


use Folklore\GraphQL\Support\EnumType;

class CommentStatusEnum extends EnumType {
	protected $attributes = [
		'name'        => 'CommentStatusEnum',
		'description' => 'An enum for Comment Status'
	];

	public function values() {
		return [
			'rejected' => '0',
			'approved' => '1'
		];
	}
}
