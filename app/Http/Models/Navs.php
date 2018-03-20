<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Navs extends Model
{
    //
    protected $table='navs';//表名
    protected $primaryKey='nav_id';//主键
    public $timestamps=false;//默认更新时间和创建时间，等于false 默认不要
    protected $guarded = [];
}
