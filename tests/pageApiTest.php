<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class pageApiTest extends TestCase
{
    use MakepageTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatepage()
    {
        $page = $this->fakepageData();
        $this->json('POST', '/api/v1/pages', $page);

        $this->assertApiResponse($page);
    }

    /**
     * @test
     */
    public function testReadpage()
    {
        $page = $this->makepage();
        $this->json('GET', '/api/v1/pages/'.$page->id);

        $this->assertApiResponse($page->toArray());
    }

    /**
     * @test
     */
    public function testUpdatepage()
    {
        $page = $this->makepage();
        $editedpage = $this->fakepageData();

        $this->json('PUT', '/api/v1/pages/'.$page->id, $editedpage);

        $this->assertApiResponse($editedpage);
    }

    /**
     * @test
     */
    public function testDeletepage()
    {
        $page = $this->makepage();
        $this->json('DELETE', '/api/v1/pages/'.$page->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/pages/'.$page->id);

        $this->assertResponseStatus(404);
    }
}
