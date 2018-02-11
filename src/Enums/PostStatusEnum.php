<?php

namespace LaravelWordpressGraphQL\Enums;


use Folklore\GraphQL\Support\EnumType;

class PostStatusEnum extends EnumType
{
    protected $attributes = [
        'name' => 'PostStatusEnum',
        'description' => 'An enum for Post Status'
    ];

    public function values() {
        return [
        	'trash' => 'trash',
        	'draft' => 'draft',
	        'publish' => 'publish'
        ];
    }
}
