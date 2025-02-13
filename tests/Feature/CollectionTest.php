<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateCollection(): void
    {
        $collection = collect([1,2,3]);
        $this->assertEquals(3, $collection->count());
        $this->assertEqualsCanonicalizing([1,2,3], $collection->all());
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $collection);
    }
}