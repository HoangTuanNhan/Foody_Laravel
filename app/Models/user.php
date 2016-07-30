<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="user",
 *      required={name, avatar, email, password, is_admin},
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
 *          property="avatar",
 *          description="avatar",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="password",
 *          description="password",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="is_admin",
 *          description="is_admin",
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
class user extends Model
{
    use SoftDeletes;

    public $table = 'users';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'avatar',
        'email',
        'password',
        'is_admin'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'avatar' => 'string',
        'email' => 'string',
        'password' => 'string',
        'is_admin' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
//    public static $rules = [
//        'name' => 'required',
//        'avatar' => 'required',
//        'email' => 'required',
//        'password' => 'required',
//        'is_admin' => 'required'
//    ];
    public static function rules(){
         switch (\Request::method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'name' => 'required|max:100',
                        'email' => 'required',
                        'avatar' => 'required|max:1000|image',
                        'password' => 'required',
                        'is_admin' => 'required'
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name' => 'required|max:100',
                        'email' => 'required',
                        'avatar' => 'max:1000|image',
                        'password' => 'required',
                        'is_admin' => 'required'
                    ];
                }
            default:break;
        }
    }
    public function food()
    {
        return $this->hasMany('App\Models\food');
    }
}
