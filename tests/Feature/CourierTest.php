<?php

namespace Tests\Feature;

use App\Models\Courier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourierTest extends TestCase
{
    /**
     * Test pagination dan default sorting (by name).
     */
    public function test_couriers_are_paginated_and_sorted_by_name()
    {
        $response = $this->get('/courier');

        $response->assertStatus(200);

        $response->assertViewHas('couriers', function ($couriers) {
            return $couriers->first()->name === 'Agung Prasetyo'; // Sorted by name (asc)
        });
    }

    /**
     * Test sorting by created_at descending.
     */
    public function test_couriers_can_be_sorted_by_created_date()
    {
        $response = $this->get('/courier?sort_by=created_at&sort_order=desc');

        $response->assertStatus(200);

        $response->assertViewHas('couriers', function ($couriers) {
            return $couriers->first()->name === 'Agung Prasetyo'; // Newest first
        });
    }

    /**
     * Test filter berdasarkan nama.
     */
    public function test_couriers_can_be_filtered_by_name()
    {
        $response = $this->get('/courier?search=budi+agung');

        $response->assertStatus(200);

        $response->assertViewHas('couriers', function ($couriers) {
            return $couriers->contains('name', 'Budiono Hadi Agung');
        });
    }

    /**
     * Test filter berdasarkan level.
     */
    public function test_couriers_can_be_filtered_by_level()
    {
        $response = $this->get('/courier?level=2,3');

        $response->assertStatus(200);

        $response->assertViewHas('couriers', function ($couriers) {
            return $couriers->contains('level', 2) &&
                   $couriers->contains('level', 3);
        });
    }
}
