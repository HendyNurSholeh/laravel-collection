<?php

namespace Tests\Feature;

use App\Data\Person;
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
    public function testMapInto2(): void
    {
        $collection = collect(["hendy", "joko"]);
        $result = $collection->mapInto(Person::class);
        $resultMapInto = $collection->map(function ($item) {
            return new Person($item);
        });
        
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Person::class, $result->first());
        $this->assertEquals(new Person("hendy"), $result->first());
        $this->assertEquals([new Person("hendy"), new Person("joko")], $result->all());
        


        $this->assertEquals($result->all(), $resultMapInto->all());

        $this->assertCount(2, $resultMapInto);
        $this->assertInstanceOf(Person::class, $resultMapInto->first());
        $this->assertEquals(new Person("hendy"), $resultMapInto->first());
        $this->assertEquals([new Person("hendy"), new Person("joko")], $resultMapInto->all());
    }

    // test map spread
    public function testMapSpread(): void
    {
        $collection = collect([['hendy', 'nur'], ['joko', 'santoso']]);
        $collection = $collection->mapSpread(function ($firstName, $lastName) { // update second parameter
            return new Person($firstName . ' ' . $lastName); // return both first and last names
        });
        $this->assertEqualsCanonicalizing([new Person('hendy nur'), new Person('joko santoso')], $collection->all()); // update expected value
        
        $this->assertCount(2, $collection);
        $this->assertInstanceOf(Person::class, $collection->first());
        $this->assertEquals(new Person('hendy nur'), $collection->first());
        $this->assertEquals(new Person('joko santoso'), $collection->last());
    }

    // test map to group
    public function testMapToGroups(): void
    {
        $collection = collect([['name' => 'hendy', 'age' => 20], ['name' => 'joko', 'age' => 30], ['name' => 'santoso', 'age' => 30]]);
        $collection = $collection->mapToGroups(function ($item, $key) {
            return [$item['age'] => $item['name']];
        });
        $this->assertEqualsCanonicalizing([20 => ['hendy'], 30 => ['joko', 'santoso']], $collection->all());
    }
    
    
}