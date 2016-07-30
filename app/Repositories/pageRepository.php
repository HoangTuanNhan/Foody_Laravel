<?php

namespace App\Repositories;

use App\Models\page;
use InfyOm\Generator\Common\BaseRepository;

class pageRepository extends BaseRepository
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
        return page::class;
    }
}
