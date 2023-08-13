<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\V1\ListingRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use App\Traits\PaginateAndFilter;

class ProductController extends Controller
{
    use PaginateAndFilter;

    public function index(ListingRequest $request)
    {
        $query = Product::query();

        $this->applyFilters($query, $request);

        $products = $this->paginateResults($query, $request);

        $productCollection = ProductResource::collection($products);

        return ApiResponse::sendData($productCollection);
    }
}
