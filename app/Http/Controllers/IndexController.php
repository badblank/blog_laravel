<?php
/**
 * Created by PhpStorm.
 * User: DGH
 * Date: 2017/9/24
 * Time: 16:13
 */
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;


class IndexController extends BaseController
{
    public function index(){
        $pdo = DB::connection()->getPdo();
        dd($pdo);
    }
}
