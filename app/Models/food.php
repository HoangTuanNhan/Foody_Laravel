<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="food",
 *      required={name, image, category_id, content, author},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="image",
 *          description="image",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="category_id",
 *          description="category_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="content",
 *          description="content",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="author",
 *          description="author",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class food extends Model {

    use SoftDeletes;

    public $table = 'foods';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'name',
        'image',
        'category_id',
        'content',
        'author'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'category_id' => 'integer',
        'content' => 'string',
        'author' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
//    public static $rules = [
//        'name' => 'required',
//        'image' => 'required',
//        'category_id' => 'required',
//        'content' => 'required',
//        'author' => 'required'
//    ];
    public static function rules() {
        switch (\Request::method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'name' => 'required|max:100',
                        'image' => 'required|max:1000|image',
                        'category_id' => 'required',
                        'content' => 'required',
                        'author' => 'required'
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name' => 'required|max:100',
                        'image' => 'max:1000|image',
                        'category_id' => 'required',
                        'content' => 'required',
                        'author' => 'required'
                    ];
                }
            default:break;
        }
    }

    public function category() {
        return $this->belongsTo('App\Models\category');
    }

    public function user() {
        return $this->belongsTo('App\Models\user','author','id');
    }

}
