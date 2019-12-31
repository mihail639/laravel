<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-info">
              <div class="card-header">
                <h3 class="card-title">
                  HTML5 Bootstrap
                  <small>Простой и быстрый</small>
                </h3>
                <!-- tools box -->
                <div class="card-tools">
                  <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip"
                          title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <!--button type="button" class="btn btn-tool btn-sm" data-card-widget="remove" data-toggle="tooltip"
                          title="Remove">
                    <i class="fas fa-times"></i></button-->
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pad">
                <div class="mb-3">

                  <form id="editForm-{{ $item->id }}">
                    <div class="col-md-12">
                      <div class="row ">
                        <div class="col-sm-12 col-md-6 col-lg-4 pl-0 form-group">
                          <label>Наименование</label>
                          <input type="text" name="title_ru" value="{{ $item->title_ru }}" class="form-control" placeholder="Наименование">
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 pl-0 form-group">
                          <label>Видимость</label>
                          <div class="col-md-12 row">
                            <div class="custom-control custom-radio col-sm-6 col-md-6 col-lg-6">
                              <input class="custom-control-input" type="radio" id="customRadio1" name="see" value="1"
                              @if($item->see == 1)
                                checked
                              @endif
                              >
                              <label for="customRadio1" class="custom-control-label">Да</label>
                            </div>
                            <div class="custom-control custom-radio col-sm-6 col-md-6 col-lg-6">
                              <input class="custom-control-input" type="radio" id="customRadio2" name="see"  value="0" 
                              @if($item->see == 0)
                                checked
                              @endif  
                              >
                              <label for="customRadio2" class="custom-control-label">Нет</label>
                            </div>
                          </div>  
                        </div>
                      </div>


                      <textarea name="body_ru" id="text-{{ $item->id }}-ru" class="d-none">{{ $item->body_ru }}</textarea>
                    </div>
                  </form>
                  
                    <textarea class="textarea" placeholder="Place some text here"
                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" id="textarea-{{ $item->id }}-ru">{{ $item->body_ru }}
                    </textarea>
                </div>
                <p class="text-sm mb-0">
                  <!--button type="button" class="btn btn-success" onclick="editItem('insert',{{ $item->id }},'editForm-{{ $item->id }}')">Сохранить изменения</button-->
                  <button class="save-button action-buttons mt-2" onclick="editItem('insert',{{ $item->id }},'editForm-{{ $item->id }}','category','/{{ $section }}')">
                    Сохранить изменения
                  </button>
                </p>
              </div>
  

          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>


    <script>
      $(function () {
          $('.textarea').summernote({
            callbacks: {
              onKeyup: function(e) {
                exportTextarea({{ $item->id }}+'-','ru');
              }
            }
          })
      })
    </script>