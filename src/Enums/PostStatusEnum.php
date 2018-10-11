<?php

namespace Nucreativa\LaravelWordpressGraphQL\Enums;


use Folklore\GraphQL\Support\EnumType;

class PostStatusEnum extends EnumType {
	protected $attributes = [
		'name'        => 'PostStatusEnum',
		'description' => 'An enum for Post Status'
	];

	public function values() {
		return [
			'trash'     => 'trash',
			'autodraft' => 'auto-draft',
			'draft'     => 'draft',
			'publish'   => 'publish'
		];
	}
}
