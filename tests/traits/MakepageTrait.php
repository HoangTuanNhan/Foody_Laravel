<?php

use Faker\Factory as Faker;
use App\Models\page;
use App\Repositories\pageRepository;

trait MakepageTrait
{
    /**
     * Create fake instance of page and save it in database
     *
     * @param array $pageFields
     * @return page
     */
    public function makepage($pageFields = [])
    {
        /** @var pageRepository $pageRepo */
        $pageRepo = App::make(pageRepository::class);
        $theme = $this->fakepageData($pageFields);
        return $pageRepo->create($theme);
    }

    /**
     * Get fake instance of page
     *
     * @param array $pageFields
     * @return page
     */
    public function fakepage($pageFields = [])
    {
        return new page($this->fakepageData($pageFields));
    }

    /**
     * Get fake data of page
     *
     * @param array $postFields
     * @return array
     */
    public function fakepageData($pageFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'content' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $pageFields);
    }
}
