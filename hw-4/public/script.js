function send(id) {
  $.ajax({
    type: "POST",
    url: "?page=backet&func=addajax&id=" + id,
    success: function (data) {
      $('#bac').html(data);
      console.log(data);
    }
  });
}
// Ассинхронное удаление заказа пользователем
function delZakaz(id) {
  $.ajax({
    type: "POST",
    url: "?page=orders&func=del_order&id=" + id,
    success: function (data) {
      $(`#${id}`).html(data);
      
    }
  });
}
// Ассинхронная смена статуса заказа Админом
function changeOrderStatus(id) {
    let $inp = $(`#${id}`).find('input');
    let inpVal = $inp.val();
    console.log(inpVal);
    $.ajax({
    type: "POST",
    url: "?page=orders&func=change_status&id=" + id,
    data:{newStatus : inpVal},
    success: function (data) {
      
      alert(data);
    }
  });
}