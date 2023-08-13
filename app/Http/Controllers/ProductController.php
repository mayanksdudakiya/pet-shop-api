<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\V1\ListingRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use App\Traits\PaginateAndFilter;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="Products API endpoint"
 * )
 */
class ProductController extends Controller
{
    use PaginateAndFilter;

    /**
    * @OA\Get(
    *     path="/api/v1/products",
    *     tags={"Products"},
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         description="Product page",
    *         required=false,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Parameter(
    *         name="limit",
    *         in="query",
    *         description="Number of products per page",
    *         required=false,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Parameter(
    *         name="sortBy",
    *         in="query",
    *         description="Sort by column",
    *         required=false,
    *         @OA\Schema(type="string")
    *     ),
    *      @OA\Parameter(
    *         name="desc",
    *         in="query",
    *         description="Order product by desc",
    *         required=false,
    *         @OA\Schema(type="boolean")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="OK"
    *     ),
    *     @OA\Response(
    *         response="401",
    *         description="Unauthorized"
    *     ),
    *     @OA\Response(
    *         response="404",
    *         description="Page not found"
    *     ),
    *     @OA\Response(
    *         response="422",
    *         description="Unprocessable Entity"
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Internal server error"
    *     )
    * )
    */
    public function index(ListingRequest $request): JsonResponse
    {
        $query = Product::query();

        $this->applyFilters($query, $request);

        $products = $this->paginateResults($query, $request);

        $productCollection = ProductResource::collection($products);

        return ApiResponse::sendData($productCollection);
    }
}
