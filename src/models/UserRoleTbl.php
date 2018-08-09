<?php namespace app\models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as DB;
use \Datetime;
use app\models\LoginTbl;


class UserRoleTbl extends Model {

  public $table = 'user_role_tbl';

  protected $primaryKey  = 'id';

  protected $dates = ['deleted_at'];


  public $fillable = [
    'code',
    'name',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   **/
   public function users()
    {
        return $this->hasMany(UserTbl::class,'role_id','id');
    }



}
?>
