@extends('layouts.app')
@section('content')
<style>
   .table_pointer{
   pointer-events: none;
   cursor: default;
   }
</style>
<form>
   {{ csrf_field() }}
<div class="form-group row">
<div class="col-3 col-sm-3 col-md-3">
   </div>
  <div class="col-3 col-sm-3 col-md-3">
    <input name="search_date" id="search_date" type="date" class="form-control" value="">
   </div>
   <div class="col-3 col-sm-3 col-md-3">
      <button id="search_list" class="btn btn-primary">Search by Imported Date</button>
   </div>
</div>
</form>
<div class="main-container" id="main-container">
<div class="main-content">
   <table class="table table-striped table-bordered table-hover" id="myTable">
      <thead>
         <tr>
            <th><input id="select_all" type="checkbox"></th>
            <th>Name</th>
            <th>Dob</th>
            <th>Gender</th>
            <th>Salary</th>
            <th>Designation</th>
            <th></th>
         </tr>
      </thead>
      <tfoot>
         <tr>
            <th colspan="6"></th>
            <th><a href="{{ url('save') }}">Add Employee</a></th>
         </tr>
      </tfoot>
   </table>
</div>
<script type="text/javascript">
   $(document).ready(function(){
   var search_date = $("#search_date").val();
   var dataurl = "list";
   var message = "";
   var rows_selected = [];
   message = "<p class='text-danger'>No Record Found!! </p>";
   var dtablelist = $("#myTable")
     .dataTable({
       sPaginationType: "full_numbers",
       bSearchable: false,
       lengthMenu: [
         [15, 30, 45, 60, 100, 200, 500, -1],
         [15, 30, 45, 60, 100, 200, 500, "All"]
       ],
       iDisplayLength: 10,
       sDom: "Bfrtip",
       bAutoWidth: false,
       autoWidth: true,
       aaSorting: [[0, "desc"]],
       bProcessing: true,
       bServerSide: true,
       sAjaxSource: dataurl,
       fnServerData: function (sSource, aoData, fnCallback) {
         $.ajax({
           dataType: "json",
           type: "GET",
           url: sSource,
           data: aoData,
           success: fnCallback
         });
       },
       oLanguage: {
         sEmptyTable: message
       },
   
       aoColumnDefs: [
         {
           bSortable: false,
           aTargets: [0],
           className: 'select-checkbox',
           checkboxes: {
                 selectRow: true
             }
         }
       ],
       buttons: [ {
             extend: 'excelHtml5',
             text: 'Excel',
             exportOptions: {
                 columns: ':visible:not(.not-exported)',
                 modifier: {
                     selected: true
                 }
             },
             title: 'Data export'
         },
        {
             extend: 'pdfHtml5',
             text: 'PDF',
             exportOptions: {
                 columns: ':visible:not(.not-exported)',
                 modifier: {
                     selected: true
                 }
             },
             title: 'Data export'
         }
     ],
     select: {
         style : "multi",
         selector: 'td:first-child'
     },
     order:[[1,'asc']],
   
       aoColumns: [
         { data: "select" },
         { data: "full_name" },
         { data: "dob" },
         { data: "gender" },
         { data: "salary" },
         { data: "designation" },
         { data: "action" }
       ],
   
   
       fnServerParams: function(aoData) {
         aoData.push({ name: "search_date", value: search_date });
       },
   
       fnRowCallback: function (nRow, aData, iDisplayIndex) {
         var rowId = aData[0];
         var oSettings = dtablelist.fnSettings();
         if($.inArray(rowId, rows_selected) !== -1){
             $(row).find('input[type="checkbox"]').prop('checked', true);
             $(row).addClass('selected');
          }
         return nRow;
       },
   
       fnCreatedRow: function (nRow, aData, iDisplayIndex) {
         var oSettings = dtablelist.fnSettings();
         var tblid = oSettings._iDisplayStart + iDisplayIndex + 1;
         $(nRow).attr("id", "listid_" + tblid);
       }
     })
     .columnFilter({
       sPlaceHolder: "head:after",
   
       aoColumns: [
         { type: null },
         { type: "text" },
         { type: "text" },
         { type: "text" },
         { type: "text" },
         { type: "text" }
       ]
     });
        $(document).off("click", "#search_list");
      $(document).on("click", "#search_list", function() {
      search_date = $("#search_date").val();
      dtablelist.fnDraw();
      return false;
      });
     });
     $(document).off("change", "#select_all");
     $(document).on("change", "#select_all", function(e) {
     $('.select-checkbox').click();
     });
    
</script>
@endsection