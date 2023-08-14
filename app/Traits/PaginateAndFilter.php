<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait PaginateAndFilter
{
    /**
     * @param Builder<\App\Models\Product> $query
     *
     * @return Builder<\App\Models\Product>
    */
    protected function applyFilters(Builder $query, Request $request): Builder
    {
        $sortOrder = $request->input('desc') === 'true' ? 'desc' : 'asc';
        $sortColumn = $request->input('sortBy', 'created_at');

        return $query->orderBy($sortColumn, $sortOrder);
    }

    /**
     * @param Builder<\App\Models\Product> $query
     * @param Request $request
     *
     * @return LengthAwarePaginator<\App\Models\Product>
    */
    protected function paginateResults(Builder $query, Request $request): LengthAwarePaginator
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('limit', 10);

        return $query->paginate(
            $perPage,
            $columns = ['*'],
            $pageName = 'page',
            $page
        );
    }
}
