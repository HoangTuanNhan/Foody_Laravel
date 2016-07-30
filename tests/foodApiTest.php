<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class foodApiTest extends TestCase
{
    use MakefoodTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatefood()
    {
        $food = $this->fakefoodData();
        $this->json('POST', '/api/v1/foods', $food);

        $this->assertApiResponse($food);
    }

    /**
     * @test
     */
    public function testReadfood()
    {
        $food = $this->makefood();
        $this->json('GET', '/api/v1/foods/'.$food->id);

        $this->assertApiResponse($food->toArray());
    }

    /**
     * @test
     */
    public function testUpdatefood()
    {
        $food = $this->makefood();
        $editedfood = $this->fakefoodData();

        $this->json('PUT', '/api/v1/foods/'.$food->id, $editedfood);

        $this->assertApiResponse($editedfood);
    }

    /**
     * @test
     */
    public function testDeletefood()
    {
        $food = $this->makefood();
        $this->json('DELETE', '/api/v1/foods/'.$food->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/foods/'.$food->id);

        $this->assertResponseStatus(404);
    }
}
