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

    // test fpreach
    public function testForEach(): void
    {
        $collection = collect([1,2,3]);
        $collection->each(function ($item, $key) {
            $this->assertIsInt($item);
            $this->assertEquals($key+1, $item);
        });
    }
    // manual
    public function testManualForEach(): void
    {
        $collection = collect([1,2,3]);
        foreach ($collection as $item) {
            $this->assertIsInt($item);
        }
    }

    // push, pop
    public function testPushPop(): void
    {
        $collection = collect([1,2,3]);
        $collection->push(4);
        $this->assertEquals(4, $collection->pop());
        $this->assertEquals(3, $collection->count());
        $this->assertEquals(3, $collection->last());
    }
}