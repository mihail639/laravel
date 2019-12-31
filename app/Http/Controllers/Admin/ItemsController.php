<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Items;
use Illuminate\Http\Request;
use Execption;
use View;

class ItemsController extends AdminController
{
    const ONPAGE = 5;

    public function __construct()
    {
        //$this->middleware('auth');
        parent::__construct();
    }
    
    public function index(Request $request){
        $onPage = $this::ONPAGE;
        View::share ( 'currentPage', 'items' );    // для меню
        $search = '';
        $query = Items::whereNotNull('id');
        if($request->onPage){ $onPage = $request->onPage; }
        if($request->search && $request->search != ''){ 
            $search = $request->search; 
            $query->where('id','like','%' . $search . '%');
            $query->orWhere('title_ru','like','%' . $search . '%');
            $query->orWhere('teaser_ru','like','%' . $search . '%');
            $query->orWhere('body_ru','like','%' . $search . '%');
        }
    	
        $query = $query->paginate($onPage);
    	
        return view('admin.items.items',['query'=>$query,'onPage' => $onPage,'search' => $search]);
    }

    public function show(Request $request){
    	$item = Items::find($request->id);
    	if($item){
    		$result = '<h1>'.$item->body_ru.'</h1>';
    	} else {
    		$result = 'error';
    	}
    	return $result;	
    }

    public function add(Request $request){
        $error = '';
        if($request->type == 'form'){       // Возвращаем форму редактирования
            $success = true;
            $result = view('admin.items.item_add')->render();
        } else {    // Запись в базу данных
            $item = new Items;
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
        $item = Items::find($request->id);
        $error = '';
        $result = '';
        if($item){
            if($request->type == 'form'){                                               // Возвращаем форму редактирования
                $success = true;
                $result = view('admin.items.item_edit',['item'=>$item])->render();
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
        $item = Items::destroy($request->id);
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
        foreach($request->data as $id){
            $item = Items::destroy($id);
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
