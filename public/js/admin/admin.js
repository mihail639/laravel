function resultInfo(method,text) {
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

function editItem(id){
  $('.spinner-border-'+id).show();
  $('#modal-xl-'+id).modal();
  $('.spinner-border-'+id).hide();
}
function deleteItem(id){
  $('.spinner-border-'+id).show();

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:'/admin/items/delete',
    data:{
      "id":id
    },
    success: function(msg){
      resultInfo('success','Ajax successful');
      $('.spinner-border-'+id).hide();
    }
  });
   resultInfo('success','Запись учпешно уо удалена Запись учпешно удалена');
  $('.spinner-border-'+id).hide();
}

function showItem(id){
  $('.spinner-border-'+id).show();
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:'/admin/items/show',
    data:{
      "id":id
    },
    success: function(msg){
      $('#showInfo').html(msg);
      resultInfo('success','Ajax successful');
      $('.spinner-border-'+id).hide();
    }
  });
}