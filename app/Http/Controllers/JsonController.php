<?php
/**
 * @Des Custom response Json Data
 * Created by dinhbang19@gmail.com.
 * Date: 8/10/2019
 */
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JsonController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function customJson($data,$code=200) {
        return response()->json($data,$code,['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}