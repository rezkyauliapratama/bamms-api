<?php namespace app\models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Model;

class LoginTbl extends Model {

  use SoftDeletes;
  protected $dates = ['deleted_at'];

  public $table = 'login_tbl';

  protected $primaryKey  = 'id';

  public $fillable = [
    'user_id',
    'user_key',
    'token',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function user()
  {
      return $this->belongsTo(UserTbl::class, 'user_id', 'id');
  }


}
?>
