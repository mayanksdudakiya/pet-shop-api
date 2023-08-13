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

    /** @test */
    public function products_can_be_listed_with_paginated_data(): void
    {
        Product::factory(15)->create();

        $this->getJson(route('api.products'))
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    'category_uuid',
                    'title',
                    'uuid',
                    'price',
                    'metadata',
                    'category',
                    'brand',
                ]
            ])
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('current_page', 1)
            ->assertJsonPath('total', 15)
            ->assertJsonPath('last_page', 2);
    }
}
