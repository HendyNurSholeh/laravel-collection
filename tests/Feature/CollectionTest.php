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

    // prepend, pull put
    public function testPrependPullPut(): void
    {
        $collection = collect([1,2,3]);
        $collection->prepend(0);
        $this->assertEquals(0, $collection->first());
        $this->assertEquals(4, $collection->count());
        $this->assertEquals(0, $collection->pull(0));
        $this->assertEquals(3, $collection->count());
        $collection->put(0, 1);
        $this->assertEquals(1, $collection->first());
    }

    // mapping
    public function testMapping(): void
    {
        $collection = collect([1,2,3]);
        $collection = $collection->map(function ($item, $key) {
            return $item * 2;
        });
        $this->assertEqualsCanonicalizing([2,4,6], $collection->all());
    }

    // mapInto
    public function testMapInto(): void
    {
        $collection = collect([1,2,3]);
        $collection = $collection->mapInto(\stdClass::class);
        $this->assertInstanceOf(\stdClass::class, $collection->first());
    }
}