<?php namespace app\models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as DB;
use \Datetime;


class UserTbl extends Model {

  public $table = 'user_tbl';

  protected $primaryKey  = 'id';

  protected $dates = ['deleted_at'];


  public $fillable = [
    'role_id',
    'username',
    'password',
    'name',
    'email',
    'phone',
    'address'
  ];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    **/
    public function logins()
    {
        return $this->hasMany(LoginTbl::class,'user_id','id');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    **/
    public function accounts()
    {
        return $this->hasMany(AccountTbl::class,'user_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function userrole()
    {
        return $this->belongsTo(UserRoleTbl::class, 'role_id', 'id');
    }



}
?>
