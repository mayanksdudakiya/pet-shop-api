<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait PaginateAndFilter
{
    protected function applyFilters(Builder $query, Request $request): Builder
    {
        $sortOrder = $request->input('desc', false) ? 'desc' : 'asc';
        $sortColumn = $request->input('sortBy', 'created_at');

        return $query->orderBy($sortColumn, $sortOrder);
    }

    protected function paginateResults(Builder $query, Request $request): LengthAwarePaginator
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('limit', 10);

        return $query->paginate(
            $perPage = 15,
            $columns = ['*'],
            $pageName = 'page',
            $page
        );
    }
}