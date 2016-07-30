<?php

namespace App\Repositories;

use App\Models\category;
use InfyOm\Generator\Common\BaseRepository;

class categoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'=>'like'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return category::class;
    }
}
