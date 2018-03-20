<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table='category';//表名
    protected $primaryKey='cate_id';//主键
    public $timestamps=false;//默认更新时间和创建时间，等于false 默认不要
    protected $guarded = [];

    public function tree(){
        $categorys = $this->orderBy('cate_order','asc')->get();
//        dd($categorys);
        return $this->getTree($categorys,'cate_name','cate_id','cate_pid',0);
    }

    public function getTree($data,$field_name,$field_id = 'id' ,$field_pid = 'pid',$pid = 0)
    {
        $arr = array();
        foreach ($data as $k=>$v){
            if($v->$field_pid==0){
                $data[$k]['_'.$field_name] = $data[$k][$field_name];
                $arr[]= $data[$k];
                foreach ($data as $kk=>$vv){
                    if($vv->$field_pid == $v->$field_id){
                        $data[$kk]['_'.$field_name] = '├──'.$data[$kk][$field_name];
                        $arr[] = $data[$kk];
                    }
                }
            }
        }
        return $arr;
    }
}
