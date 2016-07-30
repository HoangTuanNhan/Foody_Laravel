<?php

use App\Models\food;
use App\Repositories\foodRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class foodRepositoryTest extends TestCase
{
    use MakefoodTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var foodRepository
     */
    protected $foodRepo;

    public function setUp()
    {
        parent::setUp();
        $this->foodRepo = App::make(foodRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatefood()
    {
        $food = $this->fakefoodData();
        $createdfood = $this->foodRepo->create($food);
        $createdfood = $createdfood->toArray();
        $this->assertArrayHasKey('id', $createdfood);
        $this->assertNotNull($createdfood['id'], 'Created food must have id specified');
        $this->assertNotNull(food::find($createdfood['id']), 'food with given id must be in DB');
        $this->assertModelData($food, $createdfood);
    }

    /**
     * @test read
     */
    public function testReadfood()
    {
        $food = $this->makefood();
        $dbfood = $this->foodRepo->find($food->id);
        $dbfood = $dbfood->toArray();
        $this->assertModelData($food->toArray(), $dbfood);
    }

    /**
     * @test update
     */
    public function testUpdatefood()
    {
        $food = $this->makefood();
        $fakefood = $this->fakefoodData();
        $updatedfood = $this->foodRepo->update($fakefood, $food->id);
        $this->assertModelData($fakefood, $updatedfood->toArray());
        $dbfood = $this->foodRepo->find($food->id);
        $this->assertModelData($fakefood, $dbfood->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletefood()
    {
        $food = $this->makefood();
        $resp = $this->foodRepo->delete($food->id);
        $this->assertTrue($resp);
        $this->assertNull(food::find($food->id), 'food should not exist in DB');
    }
}
