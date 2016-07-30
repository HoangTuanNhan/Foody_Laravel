<?php

namespace App\Repositories;

use App\Models\food;
use InfyOm\Generator\Common\BaseRepository;

class foodRepository extends BaseRepository
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
        return food::class;
    }
}
