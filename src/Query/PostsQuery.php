<?php

namespace LaravelWordpressGraphQL\Query;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use LaravelWordpressGraphQL\Helper\Paginates;
use LaravelWordpressModels\Models\Post;

class PostsQuery extends Query {

    const DEFAULT_SORTBY = 'post_date';

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
            'categories' => [ 'name' => 'categories', 'type' => Type::string() ],
            'tags' => [ 'name' => 'tags', 'type' => Type::string() ],
            Paginates::PAGINATION_KEY => [ 'name' => Paginates::PAGINATION_KEY, 'type' => GraphQL::type('PaginationInput') ],
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
        } else if ( isset( $args['tags'] ) ) {
            $post = $post->join('term_relationships', 'posts.id', '=', 'term_relationships.object_id')
                ->join('term_taxonomy', 'term_relationships.term_taxonomy_id', '=', 'term_taxonomy.term_id')
                ->join('terms', 'terms.term_id', '=', 'term_taxonomy.term_id')
                ->where('term_taxonomy.taxonomy', '=', 'post_tag')
                ->where('terms.slug',  '=', $args['tags']);
        }

        $orderBy = @$args[Paginates::PAGINATION_KEY]['sort_by'] ? @$args['pagination']['sort_by'] : self::DEFAULT_SORTBY;
        $args[Paginates::PAGINATION_KEY]['sort_by'] = $orderBy;

        return Paginates::paginate($post, $args);
    }
}
