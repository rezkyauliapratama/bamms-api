<?php namespace app\models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Model;

class TransactionTbl extends Model {

  use SoftDeletes;
  protected $dates = ['deleted_at'];

  public $table = 'activity_detail_tbl';

  protected $primaryKey  = 'id';

  public $fillable = [
    'account_id',
    'type',
    'date',
    'name',
    'amount'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function Account()
  {
      return $this->belongsTo(AccountTbl::class, 'account_id', 'id');
  }


}
?>
