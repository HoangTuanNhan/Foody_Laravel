<?php

use Faker\Factory as Faker;
use App\Models\food;
use App\Repositories\foodRepository;

trait MakefoodTrait
{
    /**
     * Create fake instance of food and save it in database
     *
     * @param array $foodFields
     * @return food
     */
    public function makefood($foodFields = [])
    {
        /** @var foodRepository $foodRepo */
        $foodRepo = App::make(foodRepository::class);
        $theme = $this->fakefoodData($foodFields);
        return $foodRepo->create($theme);
    }

    /**
     * Get fake instance of food
     *
     * @param array $foodFields
     * @return food
     */
    public function fakefood($foodFields = [])
    {
        return new food($this->fakefoodData($foodFields));
    }

    /**
     * Get fake data of food
     *
     * @param array $postFields
     * @return array
     */
    public function fakefoodData($foodFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'image' => $fake->word,
            'category_id' => $fake->randomDigitNotNull,
            'content' => $fake->text,
            'author' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $foodFields);
    }
}
