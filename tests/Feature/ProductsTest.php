<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function products_end_point_should_be_accessible(): void
    {
        $this->getJson(route('api.products'))->assertOk();
    }
}
