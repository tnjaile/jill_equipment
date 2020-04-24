$(function () {
  $("#time_sort").sortable({
    opacity: 0.6,
    cursor: "move",
    start: function () {
      $("#time_sort_save_msg").empty();
    } ,
    update: function () {
      var order = $(this).sortable("serialize");
      $.post("equipmentTime_ajax.php?op=time_sort", order, function(theResponse){
        $("#time_sort_save_msg").html(theResponse);
      });
    }
  });
});
function change_enable(tsn,w){
  $.post("equipmentTime_ajax.php", {op: 'change_enable',tsn: tsn, week: w },
  function(data) {
    $('#'+tsn+'_'+w).attr('src',data);
  });
}