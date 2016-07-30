<?php

use App\Models\page;
use App\Repositories\pageRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class pageRepositoryTest extends TestCase
{
    use MakepageTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var pageRepository
     */
    protected $pageRepo;

    public function setUp()
    {
        parent::setUp();
        $this->pageRepo = App::make(pageRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatepage()
    {
        $page = $this->fakepageData();
        $createdpage = $this->pageRepo->create($page);
        $createdpage = $createdpage->toArray();
        $this->assertArrayHasKey('id', $createdpage);
        $this->assertNotNull($createdpage['id'], 'Created page must have id specified');
        $this->assertNotNull(page::find($createdpage['id']), 'page with given id must be in DB');
        $this->assertModelData($page, $createdpage);
    }

    /**
     * @test read
     */
    public function testReadpage()
    {
        $page = $this->makepage();
        $dbpage = $this->pageRepo->find($page->id);
        $dbpage = $dbpage->toArray();
        $this->assertModelData($page->toArray(), $dbpage);
    }

    /**
     * @test update
     */
    public function testUpdatepage()
    {
        $page = $this->makepage();
        $fakepage = $this->fakepageData();
        $updatedpage = $this->pageRepo->update($fakepage, $page->id);
        $this->assertModelData($fakepage, $updatedpage->toArray());
        $dbpage = $this->pageRepo->find($page->id);
        $this->assertModelData($fakepage, $dbpage->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletepage()
    {
        $page = $this->makepage();
        $resp = $this->pageRepo->delete($page->id);
        $this->assertTrue($resp);
        $this->assertNull(page::find($page->id), 'page should not exist in DB');
    }
}
