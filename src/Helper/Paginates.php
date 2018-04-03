<?php

namespace LaravelWordpressGraphQL\Helper;

use LaravelWordpressGraphQL\Enums\SortTypeEnum;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Pagination helper
 *
 * @author Fanny Irawan Sutawanir (fannyirawans@gmail.com)
 *  _               _     _     _           _       _
 * | |_ ___ ___ ___| |___| |_  |_|___ _____| |_ _ _| |_
 * | '_| -_|_ -| -_| | -_| '_| | | -_|     | . | | |  _|
 * |_,_|___|___|___|_|___|_,_|_| |___|_|_|_|___|___|_|
 *                           |___|
 */
class Paginates {

    const PAGINATION_KEY = 'pagination';
    const DEFAULT_OFFSET = 1;
    const DEFAULT_PAGE = 1;
    const DEFAULT_PERPAGE = 10;

    private function __construct() {
    }

    /**
     * Parsing and initialize value of pagination parameters.
     * Return FALSE is incoming argument is invalid.
     *
     * @param $args array
     *
     * @return array|bool
     */
    public static function parse($args) {
        // if not array, return false
        if(!is_array($args) ) return false;
        // if no pagination index, return false
        if(!isset($args[self::PAGINATION_KEY]) ) return false;
        // if pagination is not array or empty, return false
        if(!(is_array($args[self::PAGINATION_KEY]) && !empty($args[self::PAGINATION_KEY]) ) ) return false;

        $page = @$args[self::PAGINATION_KEY]['page'] ? @$args[self::PAGINATION_KEY]['page'] : self::DEFAULT_PAGE;
        $perPage = @$args[self::PAGINATION_KEY]['per_page'] ? @$args[self::PAGINATION_KEY]['per_page'] : self::DEFAULT_PERPAGE;
        $orderBy = @$args[self::PAGINATION_KEY]['sort_by'] ? @$args[self::PAGINATION_KEY]['sort_by'] : null;
        $orderType = @$args[self::PAGINATION_KEY]['sort_type'] ? @$args[self::PAGINATION_KEY]['sort_type'] : SortTypeEnum::DEFAULT_TYPE;

        return [
            'page' => (int) $page,
            'per_page' => (int) $perPage,
            'sort_by' => $orderBy,
            'sort_type' => $orderType,
        ];
    }

    /**
     * Returns paginate model builder if pagination parameter is valid.
     * Otherwise return non-paginate model collection.
     *
     * @param $builder \Illuminate\Database\Eloquent\Builder
     * @param $args array
     *
     * @return LengthAwarePaginator|Collection
     */
    public static function paginate($builder, $args) {
        $pagination = self::parse($args);
        if($pagination) {
            if(!empty($pagination['sort_by']) ) {
                $builder->orderBy($pagination['sort_by'], $pagination['sort_type']);
            }
            return $builder->paginate($pagination['per_page'], ['*'], '', $pagination['page']);
        }

        return $builder->get();
    }
}