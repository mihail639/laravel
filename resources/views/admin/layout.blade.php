<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.partials.header')
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed">
<div class="wrapper">
  
    @include('admin.partials.navbar')

    @include('admin.partials.left_menu')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
    @include('admin.partials.modals')

    @yield('content')
    
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
<!--button class="btn btn-primary"><i class="fa fa-home"></i> Home</button>
<button class="btn btn-primary"><i class="fa fa-bars"></i> Menu</button>
<button class="btn btn-primary"><i class="fa fa-trash"></i> Trash</button>
<button class="btn btn-primary"><i class="fa fa-close"></i> Close</button>
<button class="btn btn-primary"><i class="fa fa-folder"></i> Folder</button-->
  <!-- Main Footer -->
  @include('admin.partials.footer')

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="/plugins/datatables/jquery.dataTables.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- AdminLTE -->
<!-- SweetAlert2 -->
<script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="/plugins/chart.js/Chart.min.js"></script>
<script src="/dist/js/demo.js"></script>
<script src="/dist/js/pages/dashboard3.js"></script>
<!-- Summernote -->
<script src="../../plugins/summernote/summernote-bs4.min.js"></script>
<script>
  function changeTableCheckbox(element,secondCheckBox,single=''){
    if(single == ''){
      $('#'+secondCheckBox).prop("checked",element.checked);
      $('.table-checkbox').find(':input[type=checkbox]').each(function(){
        this.checked = element.checked;
      })
    } 
    if(element.checked == true){
      $('#delete-all-button').fadeIn();
    } else {
      if($('.table-checkbox').find('input[type=checkbox]:checked').length == 0){
        $('#delete-all-button').fadeOut();
      }
    } 
  }

  function redirectTo(url,appends){
    $('#loader-only').modal();  // loader
    window.location.href = url+appends;
  }

  function serializeForm(formId){   // Собирает инпуты для ajax отправки
    var $data = {};
    var i = 0;
    $('#'+formId).find ('input, textarea, select').each(function() { 
        if($(this).val() == ''){                            // Если есть пусое поле то выводим ошибку
          resultInfo('error','Заполните пожалуйста все поля');
          i = 1;
          return false;
        }
        if(this.type != 'radio'){                           // Для всех кроме чекбоксов
          $data[this.name] = $(this).val();

          console.log(this.name+'='+$(this).val());
        }
        if(this.type == 'radio' && this.checked == true){   // Для чекбоксов
          $data[this.name] = $(this).val();

          console.log(this.name+'='+$(this).val());
        }
    });
    if(i == 1){   // Если есть ошибка
      return false;
    } else {      // Если все норма
      return $data;
    }
  }

  function exportTextarea(id,lang){
    $('#text-'+id+lang).val($('#textarea-'+id+lang).val());
  }

  function resultInfo(method,text) {          // Результат выполнения (уведомление)
      text = '&nbsp;&nbsp;&nbsp;&nbsp;'+text;
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 6000
      });
      Toast.fire({
          type: method,
          title: text
      })
  }   

  $(function () {
    $('#example1').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": true,
      // "columnDefs": [ {
      //       "searchable": false,
      //       "orderable": false,
      //       "ordering": false,
      //       "targets": 0,
      //       // "data": null,
      //       // "defaultContent": "<button>Edit</button>",
      //       "visible": true,
      //   } ],

    });
  });

  function addItem(type='form',id=0,formId,sectionUrl='items',section=''){      // Формы добавления
    var $data;
    if(type == 'insert'){         // Если нужно отправить форму для записи в базу
      $data = serializeForm(formId); // Собирает инпуты для ajax
      if(!$data){               // Если какое то поле не заполнено
        return false;
      }
    } 
    $('#loader-only').modal('show'); 
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      url:'/admin/'+sectionUrl+'/add'+section,
      data:{
        "id":id,
        'type':type,
        'data':$data
      },
      success: function(msg){
        if(msg.success){
          if(type == 'insert'){             // Запись в базу
            $('#loader-only').modal('hide');  // loader
            $('#modal-xl').modal('hide');
            resultInfo('success',msg.result);
          } else {                            // Вывод формы для редактирования
            $('#showContent').html(msg.result);  // Загружает вьюшку формы редактирования
            $('#loader-only').modal('hide');  // loader
            $('#modal-xl').modal();           // Запускает попап редактирования
            $('.modal').css('overflow','auto');
          }  
        } else {                              // Если сервер вернул ошибку
          resultInfo('error',msg.error);
          $('#loader-only').modal('hide');
        }  
      }
    });
  }

  function editItem(type='form',id,formId='',sectionUrl='items',section=''){      // Формы редактирования
    var $data;
    if(type == 'insert'){         // Если нужно отправить форму для записи в базу
      $data = serializeForm(formId); // Собирает инпуты для ajax
      if(!$data){               // Если какое то поле не заполнено
        return false;
      }
    } 
    $('#loader-only').modal('show'); 
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      url:'/admin/'+sectionUrl+'/edit'+section,
      data:{
        "id":id,
        'type':type,
        'data':$data
      },
      success: function(msg){
        if(msg.success){
          if(type == 'insert'){             // Запись в базу
            $('#loader-only').modal('hide');  // loader
            $('#modal-xl').modal('hide');
            resultInfo('success',msg.result);
          } else {                            // Вывод формы для редактирования
            $('#showContent').html(msg.result);  // Загружает вьюшку формы редактирования
            $('#loader-only').modal('hide');  // loader
            $('#modal-xl').modal();           // Запускает попап редактирования
            $('.modal').css('overflow','auto');
          }  
        } else {                              // Если сервер вернул ошибку
          resultInfo('error',msg.error);
          $('#loader-only').modal('hide');
        }  
      }
    });
  }

  function deleteItem(id,sectionUrl='items',section=''){
      $('#loader-only').modal('show'); //$('.spinner-border-'+id).show();
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/admin/'+sectionUrl+'/delete'+section,
        data:{
          "id":id
        },
        success: function(msg){
          if(msg.success){
            resultInfo('success',msg.result);
            $('.table-item-'+id).remove();
          } else {
            resultInfo('error',msg.error);
          }  
          $('#loader-only').modal('hide'); //$('.spinner-border-'+id).hide();
        }
      });
  }

  function deleteChecked(sectionUrl='items',section='',type='',id=0){
    $('#loader-only').modal('show');  // loader
    var $data = [];
    var i = 0;
    $('.table-checkbox').find('input[type=checkbox]:checked').each(function(){
      $data[i] = this.value;
      i++;
    });

    if($data[0]){
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/admin/'+sectionUrl+'/delete-all'+section,
        data:{
          "id":id,
          'type':type,
          'data':$data
        },
        success: function(msg){
          if(msg.success){
            $('#loader-only').modal('hide');  // loader
            resultInfo('success',msg.result);
            for(i=0; $data.length>i; i++){
              $('.table-item-'+$data[i]).remove();
            }
          } else {                              // Если сервер вернул ошибку
            resultInfo('error',msg.error);
            $('#loader-only').modal('hide');
          }
        }    
      });
    } else {
      $('#loader-only').modal('hide');
      resultInfo('error','Отметьте пожалуйста нужные записи');
    }
  }

  function showItem(id,section=''){
    //$('.spinner-border-'+id).show();
    $('#loader-only').modal('show');
    // $.ajax({
    //   headers: {
    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //   },
    //   type:'POST',
    //   url:'/admin/items/show',
    //   data:{
    //     "id":id
    //   },
    //   success: function(msg){
    //     $('#showInfo').html(msg);
    //     resultInfo('success','Ajax successful');
    //     $('.spinner-border-'+id).hide();
    //   }
    // });
  }




// function editItem(event,id,type='form'){      // Формы редактирования   //$('.spinner-border-'+id).show();
//     var data = ''; 
//     if(type == 'edit'){         // Если нужно отправить форму для записи в базу
//       data = serializeForm('editForm-'+id); // Собирает инпуты для ajax
//       if(!data){               // Если какое то поле не заполнено
//         return false;
//       }
//     } 
//     $('#loader-only').modal('show'); 
//     var res = ajaxRequest('/admin/items/edit','POST',id,data,type);
//     console.log(res);
//     if(result){
//       if(type == 'edit'){             // Запись в базу
//         $('#loader-only').modal('hide');  // loader
//         $('#modal-xl').modal('hide');
//         resultInfo('success',result.result);
//       } else {                            // Вывод формы для редактирования
//         $('#showContent').html(result.result);  // Загружает вьюшку формы редактирования
//         $('#loader-only').modal('hide');  // loader
//         $('#modal-xl').modal();           // Запускает попап редактирования
//         $('.modal').css('overflow','auto');
//       }
//     }    
//   }

//   function ajaxRequest(url,requestType,id=0,data='',type=''){
//     $.ajax({
//         headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type:requestType,
//         url:url,
//         data:{
//           "id":id,
//           'type':type,
//           'data':data
//         },
//         success: function(result){
//           if(result.success){
//             return result;
//           } else {                              // Если сервер вернул ошибку
//             resultInfo('error',result.error);
//             $('#loader-only').modal('hide');
//           }
//         }
//       });
//   }



  
</script>
</body>
</html>
