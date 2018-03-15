<?php

namespace LaravelWordpressGraphQL\Query;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use LaravelWordpressModels\Models\Post;

class PostsQuery extends Query {
	protected $attributes = [
		'name' => 'posts'
	];

	public function type() {
		return Type::listOf( GraphQL::type( 'Post' ) );
	}

	public function args() {
		return [
			'id'     => [ 'name' => 'id', 'type' => Type::string() ],
			'slug'   => [ 'name' => 'slug', 'type' => Type::string() ],
			'status' => [ 'name' => 'status', 'type' => GraphQL::type( 'PostStatus' ) ],
            'categories' => [ 'name' => 'categories', 'type' => Type::string() ]
		];
	}

	public function resolve( $root, $args = [] ) {
		$post = Post::on('wordpress')->type( 'post' );
		if ( isset( $args['status'] ) ) {
			$post = $post->where( 'post_status', $args['status'] );
		}
		if ( isset( $args['id'] ) ) {
			$post = $post->where( 'ID', $args['id'] );
		} else if ( isset( $args['slug'] ) ) {
			$post = $post->where( 'post_name', $args['slug'] );
        } else if ( isset( $args['categories'] ) ) {
            $post = $post->join('term_relationships', 'posts.id', '=', 'term_relationships.object_id')
                        ->join('term_taxonomy', 'term_relationships.term_taxonomy_id', '=', 'term_taxonomy.term_id')
                        ->join('terms', 'terms.term_id', '=', 'term_taxonomy.term_id')
                        ->where('term_taxonomy.taxonomy', '=', 'category')
                        ->where('terms.slug',  '=', $args['categories']);
        }

		return $post->get();
	}
}
