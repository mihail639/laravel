<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Items;
use App\ItemsCategory;
use App\NewsCategory;
use App\VideoCategory;
use Illuminate\Http\Request;
use Execption;
use View;
use Auth;

class CategoryController extends AdminController
{

    const ONPAGE = 5;

    public function __construct()
    {
        //$this->middleware('auth');
        parent::__construct();
    }
    
    public function index(Request $request){
        // if(Auth::user()->is_admin){
        //     return redirect()->to('/');
        // }
        $section = $request->section;               // параметр который в url
        View::share ( 'currentPage', $section );    // для меню
        $onPage = $this::ONPAGE;
        $search = '';

        $query = $this::category[$section]::whereNotNull('id');   // Выбираем модель согласно url
        
        if($request->onPage){ $onPage = $request->onPage; }
        if($request->search && $request->search != ''){ 
            $search = $request->search; 
            $query->where('id','like','%' . $search . '%');
            $query->orWhere('title_ru','like','%' . $search . '%');
            $query->orWhere('body_ru','like','%' . $search . '%');
        }
        
        $query = $query->paginate($onPage);
        
        return view('admin.category.category',['query'=>$query,'onPage' => $onPage,'search' => $search,'section' => $section]);
    }

    public function show(Request $request){
        $item = $this::category[$section]::find($request->id);
        if($item){
            $result = '<h1>'.$item->body_ru.'</h1>';
        } else {
            $result = 'error';
        }
        return $result; 
    }

    public function add(Request $request){
        $section = $request->section;           // параметр который в url
        $error = '';
        if($request->type == 'form'){       // Возвращаем форму редактирования
            $success = true;
            $result = view('admin.category.category_add',['section'=>$section])->render();
        } else {    // Запись в базу данных
            if($section == 'category_items') { $item = new ItemsCategory; }
            if($section == 'category_news') { $item = new NewsCategory; }
            if($section == 'category_video') { $item = new VideoCategory; }
            foreach ($request->data as $key => $field){
                $item->setAttribute($key, $field);
            }

            if($item->save()){
                $success = true;
                $result = 'Запись успешно добавлена';
            } else {
                $success = false;
                $error = 'Ошибка записи.Не удалось записать данные. Попробуйте еще раз';
            }
        }

        return response()->json([
            'success' => $success,
            'result' => $result,
            'error' =>  $error,
        ]);
    }

    public function edit(Request $request){
        $section = $request->section;           // параметр который в url
        $item = $this::category[$section]::find($request->id);
        $error = '';
        $result = '';
        if($item){
            if($request->type == 'form'){                                               // Возвращаем форму редактирования
                $success = true;
                $result = view('admin.category.category_edit',['item'=>$item,'section'=>$section])->render();
            } else {                                                                    // Запись в базу данных
                foreach ($request->data as $key => $field){
                    $item->setAttribute($key, $field);
                }

                if($item->update()){
                    $success = true;
                    $result = 'Запись обновлена';
                } else {
                    $success = false;
                    $error = 'Ошибка записи.Не удалось записать данные. Попробуйте еще раз';
                }
            }   
        } else {
            $success = false;
            $error = 'Запись не найдена';
        }

        return response()->json([
            'success' => $success,
            'result' => $result,
            'error' =>  $error,
        ]);
    }

    public function delete(Request $request){
        $section = $request->section;           // параметр который в url
        $item = $this::category[$section]::destroy($request->id);
        if($item){
            $success = true;
            $result = 'Запись успешно удалена';
        } else {
            $success = false;
            $result = 'Ошибка удаления записи';
        }

        return response()->json([
            'success' => $success,
            'result' => $result,
        ]);
    }

    public function deleteAll(Request $request){
        $section = $request->section;  
        foreach($request->data as $id){
            $item = $this::category[$section]::destroy($id);
        }    
        if($item){
            $success = true;
            $result = 'Выбранные записи успешно удалены';
        } else {
            $success = false;
            $result = 'Ошибка удаления записи';
        }

        return response()->json([
            'success' => $success,
            'result' => $result,
        ]);
    }
}
