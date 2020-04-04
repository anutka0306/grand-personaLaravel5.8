<?php

namespace App\Http\Controllers\Admin;

use App\Categories as Categories;
use App\Http\Controllers\NewsController;
use App\News as News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public  function index(){
        return view('admin.index');
    }
    public function create(Request $request){
        if($request->isMethod('post')){
            $newsData = \Illuminate\Support\Facades\File::get(base_path() .'/storage/data/news.json');
            $newsData = json_decode($newsData, true);
            $next_id = end($newsData);
            $next_id = $next_id['id']+1;
           $inputData = $request->except(['_token']);
            $inputData['id'] = $next_id;
            array_push($newsData, $inputData);
            \Illuminate\Support\Facades\File::put(base_path() .'/storage/data/news.json', json_encode($newsData, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
            return $inputData;
           //dd($request->except(['_token']));
            //return redirect()->route('admin.create');
        }
        return view('admin.create',
        [
            'categories'=>Categories::getCategories()
        ]);
    }
}
