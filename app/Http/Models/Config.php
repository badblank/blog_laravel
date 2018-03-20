<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table='config';//表名
    protected $primaryKey='conf_id';//主键
    public $timestamps=false;//默认更新时间和创建时间，等于false 默认不要
    protected $guarded = [];
}
