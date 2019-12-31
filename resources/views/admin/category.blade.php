@extends('admin.layout')

@section('content')
  <div id="inner-content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{ $pagesTitle[$section] }}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item active">{{ $pagesTitle[$section] }}</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-12">
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    @if($query->total())
                      Количество записей - {{ $query->total() }}
                    @else
                      @if($search == '')
                        Записей нет, <a onclick="addItem('form','','','category','/{{ $section }}');" href="#">добавить запись</a>
                      @else
                        По вашему запросу не найдено ни одной записи
                      @endif  
                    @endif
                  </h3>
                <div id="showInfo"></div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                  <div class="row">
                    <div class="col-sm-12 col-md-4">
                      <div class="dataTables_length" id="example1_length">
                        <label>Показать по 
                          <select name="example1_length" aria-controls="example1" class="custom-select custom-select-sm form-control form-control-sm" onchange="redirectTo('{{ url()->current() }}','?onPage='+this.value)">
                            <option value="5" @if($onPage == 5) selected @endif>5</option>
                            <option value="10" @if($onPage == 10) selected @endif>10</option>
                            <option value="25" @if($onPage == 25) selected @endif>25</option>
                            <option value="50" @if($onPage == 50) selected @endif>50</option>
                            <option value="100" @if($onPage == 100) selected @endif>100</option>
                          </select> записей
                        </label>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <div id="example1_filter" class="text-center">
                        <button class="add-button action-buttons" onclick="addItem('form','','','category','/{{ $section }}');">
                          Добавить запись
                        </button>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <!--div id="example1_filter" class="dataTables_filter">
                        <label>Поиск:
                          <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="example1">
                        </label>
                      </div-->
                      <div class="input-group input-group-sm">
                        <input type="text" class="form-control search" value="{{ $search }}">
                        <span class="input-group-append">
                          <button type="button" class="btn btn-info btn-flat" onclick="redirectTo('{{ url()->current() }}','?onPage='+{{ $onPage }}+'&search='+$('.search').val())">Искать</button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                          <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: auto;">
                            Id
                          </th>
                          <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: auto;">
                            Наименование
                          </th>
                          <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: auto;">
                            Видимость
                          </th>
                          <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: auto;">
                            Дата создания
                          </th>
                          <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: auto;">
                            Дата изменения
                          </th>
                          <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: auto;">
                            Действие
                          </th>
                        </tr>
                  </thead>
                  <tbody>
                    @foreach($query as $item)
                      <tr role="row" class="odd table-item-{{ $item->id }}">
                        <td class="sorting_1">{{ $item->id }}</td>
                        <td class="sorting_1">{{ $item->title_ru }}</td>
                        <td> @if($item->see == 1) Видно @else Не видно @endif </td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td>
                          <button class="edit-button action-buttons" onclick="editItem('form',{{ $item->id }},'','category','/{{ $section }}');"></button>
                          <button class="delete-button action-buttons" onclick="deleteItem({{ $item->id }},'category','/{{ $section }}');"></button>
                          <!--button class="info-button action-buttons" onclick="showItem({{ $item->id }});"></button-->
                          <div class="spinner-border spinner-border-{{ $item->id }}  text-success" role="status" style="display:none;">
                            <span class="sr-only">Loading...</span>
                          </div>
                          
                        </td>
                      </tr>
                    @endforeach  
                  </tbody>
                  <tfoot>
                    <tr>
                      <th rowspan="1" colspan="1">
                        Id
                      </th>
                      <th rowspan="1" colspan="1">
                        Наименование
                      </th>
                      <th rowspan="1" colspan="1">
                        Видимость
                      </th>
                      <th rowspan="1" colspan="1">
                        Дата создания
                      </th>
                      <th rowspan="1" colspan="1">
                        Дата изменения
                      </th>
                      <th rowspan="1" colspan="1">
                        Действие
                      </th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-5">
                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                    Страница {{ $query->currentPage() }} 
                    @if($query->total() && $query->total() > $onPage) из 
                      {{ ceil($query->total()/$onPage) }} страниц 
                    @endif
                </div>
              </div>

              <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                  {{ $query->appends(['onPage' => $onPage,'search' => $search])->render() }}
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>







          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
  </div>
@endsection