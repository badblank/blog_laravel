<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    //GET            admin/config         全部配置项列表
    public function index()
    {
        //$config = (new config)->tree();//还可以把tree()方法变成静态
        $config= Config::orderBy('conf_order','asc')->get();
        foreach ($config as $k=>$v){
            switch ($v->field_type){
                case 'input':
                    $config[$k]->_html='<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $config[$k]->_html='<textarea class="lg" name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    $arr = explode(',',$v->field_value);
                    $str = "";
                    foreach ($arr as $m=>$n){
                        $r = explode('|',$n);
                        $c=($v->conf_content==$r[0]) ? ' checked' : '';
                        $str.='<input type="radio" name="conf_content[]" value="'.$r[0].'"'.$c.'>'.$r[1].' ';
                    }
                    $config[$k]->_html=$str;
                    break;
            }
        }
        return view('admin.config.index')->with('data',$config);
    }

    public function putFile(){
        //echo \Illuminate\Support\Facades\Config::get('web.web_title');
        $config = Config::pluck('conf_content','conf_name')->all();
        $path = base_path().'\config\web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);
    }

    //POST ajax更改排序
    public function changeOrder()
    {
        $input = Input::all();
        $conf = config::find($input['conf_id']);
        $conf->conf_order = $input['conf_order'];
        $re = $conf->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '配置项排序更新成功!'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '配置项排序更新失败，请稍后重试!'
            ];
        }
        return $data;
    }

    //POST ajax更改内容
    public function changeContent()
    {
        $input = Input::all();
        foreach ($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors','配置项更新成功');
    }

    //POST              admin/config  添加提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'conf_name'  => 'required',
            'conf_title' => 'required',
        ];
        $messages = [
            'conf_name.required'  => '配置项名称不能为空！',
            'conf_title.required' => '配置项标题不能为空！',
        ];

        $validator = Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re = config::create($input);
            if($re){
                return redirect('admin/config');
            }else{
                return back()->with('errors','配置项添加有误，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }

        dd(Input::all());
    }

    //GET|HEAD      admin/config/create   添加
    public function create()
    {
        return view('admin.config.add');
    }

    //GET|HEAD      admin/config/{config}
    public function show()
    {

    }

    //PUT|PATCH     admin/config/{config}   编辑提交
    public function update($conf_id)
    {
        $input = Input::except('_token','_method');
        $re = config::where('conf_id',$conf_id)->update($input);
        if($re){
            $this->putFile();
            return redirect('admin/config');
        }else{
            return back()->with('errors','配置项信息更新失败，请稍后重试！');
        }
    }

    //GET|HEAD      admin/config/{config}/edit      编辑
    public function edit($conf_id)
    {
        $field = config::find($conf_id);
        return view('admin.config.edit',compact('field'));
    }

    //DELETE        admin/config/{config}       删除单个配置项
    public function destroy($conf_id)
    {
        $re = config::where('conf_id',$conf_id)->delete();
        if($re){
            $this->putFile();
            $data = [
                'status' => 0,
                'msg'    => '配置项删除成功！'
            ];
        }else{
            $data = [
                'status' =>1,
                'msg'    => '配置项删除失败，请稍后重试！'
            ];
        }
        return $data;
    }

}
