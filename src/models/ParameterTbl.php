<?php namespace app\models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Capsule\Manager as DB;
use \Datetime;


class ParameterTbl extends Model {

  public $table = 'parameter_tbl';

  protected $primaryKey  = 'parameter_id';

  protected $dates = ['deleted_at'];


  public $fillable = [
    'category_id',
    'parent_id',
    'code',
    'name',
    'description'
  ];


}
?>
