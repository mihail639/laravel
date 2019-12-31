<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use View;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // const ITEMS_MAP = [
    //     'title_ru','body_ru',
    // ];
    const category = [
        'category_items'=>'App\ItemsCategory',
        'category_news'=>'App\NewsCategory',
        'category_video'=>'App\VideoCategory',
    ];
    
    public $pagesTitle = array(
        'items' => 'Товары',
        'category_items' => 'Категории товаров',
        'news' => 'Новости',
        'category_news'=>'Категории новостей',
        'category_video'=>'Категории видео',
    );
    public $currentPage = 'main';

    public function __construct()
    {
        //$this->middleware('auth');
        View::share ( ['pagesTitle' => $this->pagesTitle,'currentPage' => $this->currentPage] );
    }
    
    public function index(Request $request){
    	return view('admin.index');
    }

    public function category(){
    	print 'category page';
    }
}
