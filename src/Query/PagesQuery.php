<?php

namespace LaravelWordpressGraphQL\Query;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use LaravelWordpressGraphQL\Helper\Paginates;
use LaravelWordpressModels\Models\Post;

class PagesQuery extends Query {
    protected $attributes = [
        'name' => 'pages'
    ];

    public function type() {
        return Type::listOf( GraphQL::type( 'Post' ) );
    }

    public function args() {
        return [
            'id'     => [ 'name' => 'id', 'type' => Type::string() ],
            'slug'   => [ 'name' => 'slug', 'type' => Type::string() ],
            'status' => [ 'name' => 'status', 'type' => GraphQL::type( 'PostStatus' ) ],
            Paginates::PAGINATION_KEY => [ 'name' => Paginates::PAGINATION_KEY, 'type' => GraphQL::type('PaginationInput') ],
        ];
    }

    public function resolve( $root, $args = [] ) {
        $post = Post::on('wordpress')->type( 'page' );
        if ( isset( $args['status'] ) ) {
            $post = $post->where( 'post_status', $args['status'] );
        }
        if ( isset( $args['id'] ) ) {
            $post = $post->where( 'ID', $args['id'] );
        } else if ( isset( $args['slug'] ) ) {
            $post = $post->where( 'post_name', $args['slug'] );
        }

        return Paginates::paginate($post, $args);
    }
}