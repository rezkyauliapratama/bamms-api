<?php namespace app\models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Model;

class TransferTbl extends Model {

  use SoftDeletes;
  protected $dates = ['deleted_at'];

  public $table = 'TransferTbl';

  protected $primaryKey  = 'id';

  public $fillable = [
    'from_account',
    'to_account',
    'amount'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function fromAccounts()
  {
      return $this->belongsTo(AccountTbl::class, 'account_number', 'from_account');
  }


  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   **/
  public function toAccounts()
  {
      return $this->belongsTo(AccountTbl::class, 'account_number', 'to_account');
  }


}
?>
