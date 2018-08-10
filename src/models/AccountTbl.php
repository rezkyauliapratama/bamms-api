<?php namespace app\models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Model;

class AccountTbl extends Model {

  use SoftDeletes;
  protected $dates = ['deleted_at'];

  public $table = 'account_tbl';

  protected $primaryKey  = 'id';

  public $fillable = [
    'user_id',
    'type',
    'account_number',
    'balance',
    'description'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function user()
  {
      return $this->belongsTo(UserTbl::class, 'user_id', 'id');
  }


  /**
  * @return \Illuminate\Database\Eloquent\Relations\HasMany
  **/
  public function transactions()
  {
      return $this->hasMany(TransactionTbl::class,'account_id','id');
  }


}
?>
