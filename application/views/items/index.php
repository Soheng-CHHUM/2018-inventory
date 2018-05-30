<style> 
.dt-buttons .buttons-colvis{
  background:#007bff;
  color: #fff;
  border: 1px solid #9990;
  border-radius: 2px;
}
.dt-buttons>.buttons-colvis:hover{
  background:#0872e4 !important;
  color: #fff;
  border: 1px solid #6660  !important;
  border-radius: 2px;
}
.dt-button-collection .dt-button{
  border: 1px solid #6660  !important;
  border-radius: 3px !important;
}
.dt-button-collection .dt-button:hover{
  background: #007bff !important;
  color: #fff !important;
  border-radius: 2px !important;
}
.badge{
  padding: 5px;
}
</style>
<br>
<div id="container">
	<div class="row-fluid">
		<div class="col-12">
      <div class="row">
        <div class="col-10">
          <h2><?php echo $title;?></h2>
        </div>
        <div class="col-2">
          <!-- this use for validate on user login into system if they take a role as user or admin -->
          <?php  
          $role =$this->session->Role;
          if( $role==1 || $role==8)
          {
            ?>
            <a href="<?php echo base_url();?>items/create" class="btn btn-primary float-right"><i class="mdi mdi-plus-circle"></i>&nbsp;Create a new item</a>
            <?php 
          } 
          ?>
        </div>
      </div>
    </div><br>
    <div class="container-fluid"><?php echo $flashPartialView;?></div>
    <div class="alert alert-info" style="display: none;"></div>
    <div class="table-responsive">
      <table id="items" cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover display" width="100%">
        <colgroup>
          <col span="1" style="background-color:#eff3f7;">
        </colgroup>
        <thead>
          <tr>
            <th class="permanent">Identifier</th>
            <th>Name</th>
            <th>Category</th>
            <th>Material</th>
            <th>Condition</th>
            <th>Department</th>
            <th>Location</th>
            <th>User</th>
            <th>Owner</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="showdata">
          <!-- it will show data into tbody by ajax below -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="row-fluid">
  <div class="col-12">
    <?php 
    $role =$this->session->Role;
    if( $role==1 || $role==8)
    {
      ?>
      <a href="<?php echo base_url();?>items/export" class="btn btn-primary"><i class="mdi mdi-file-excel"></i>&nbsp;Export this list</a>
      <?php 
    }
    ?>
    &nbsp;
  </div>
</div>

<!--modal for delete an item it will alert when click on delete icon -->
<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure that you want to delete this item</p>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-primary" id="delete-comfirm">Yes</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>


<!-- modal for view detail of each item when click on eye icon -->
<div id="viewDetailModal" class="modal hide fade " tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Item detail:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-light">
        <table width="100%" class="table table-hover table-sm">
          <colgroup>
            <col span="1" style="background-color:#eff3f7;">
          </colgroup>
          <tbody id="frm_view">

            <!-- for show data detail from controller -->

          </tbody>
        </table>
      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
      </div>     
    </div>
  </div>
</div>

</div>

<link href="<?php echo base_url();?>assets/DataTable/DataTables-1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- columns visibility and reorder datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.4.1/css/colReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<!-- fixcolumns -->
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.dataTables.min.css">


<script type="text/javascript" src="<?php echo base_url();?>assets/DataTable//DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/DataTable//DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<!-- columns visibility and reorder datatable -->
<script src="https://cdn.datatables.net/colreorder/1.4.1/js/dataTables.colReorder.min.js"></script>
<!-- fixed columns -->
<script src="https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){

  // to make column reorder in table list item 
  var t = $('#items').DataTable({
    order:[] ,
    colReorder: true,
    responsive: true,
    'ajax':
    {
      'type': 'GET',
      'url':'<?php echo base_url();?>items/showAllitems', //access to controller for get data from database 
      'dataType':'json'
    },
      "colReorder":
      {
        fixedColumnsLeft:1,
      },
      "dom":"Bfrtip",
      stateSave: true,
      "buttons":
      [{
        extend:'colvis',
        columns:':not(.permanent)'
      }]
  });
  showAllitems(); //call function to use 

  // showAllitems function get data from database in skeleton_items show in table 
  function showAllitems()
  {
    // show spin waiting for the result by ajax 
    $("#showdata").html('<tr> <td class="text-center text-info"colspan="10"><i class="mdi mdi-cached mdi-spin mdi-24px"></i> Loading...</td></tr>');
    $.ajax({
      type: 'ajax',
      url: '<?php echo base_url();?>items/showAllitems',
      async: true,
      dataType: 'json',
      success: function(data){
        t.clear().draw(); //this funciton is for make a result don't have dupplicate result 
        var n = 1; //variable for count number 
        var i;
        var status="";
        for(i=0; i<data.length; i++) //validate for status available 
        { 
          if (data[i].status=='0') 
          {
            status='<span class="badge badge-success">Available</span>';
            <?php $role =$this->session->Role; ?>
            t.row.add( [
              data[i].itemcodeid+
              '&nbsp;<?php  
              if( $role==1 || $role==8){
                  ?><a href="<?php echo base_url() ?>items/edit/'+data[i].iditem+'" class="item-edit" dataid="'+data[i].iditem+'" data-toggle="tooltip" title="Edit item"><i class="mdi mdi-pencil"></i></a>'+
                  '<a href="#" class="item-delete text-danger" dataid="'+data[i].iditem+'"><i class="mdi mdi-delete" data-toggle="tooltip" title="Delete item"></i></a> <?php } ?>'+
                  '&nbsp;<a href="#" class="item-view" dataid="'+data[i].iditem+'" data-toggle="tooltip" title="Show item detail"><i class="mdi mdi-eye text-primary"></i></a>'+
                  '&nbsp;<a href="<?php echo base_url();?>items/borrower/'+data[i].iditem+'" class="item" dataid="'+data[i].iditem+'"><i class="mdi mdi-basket-fill" id="borrow" data-toggle="tooltip" title="Borrow"></i></a>',

                  data[i].item,data[i].cat,data[i].mat,data[i].condition,data[i].depat,data[i].locat,data[i].nameuser,data[i].owner,status
              ] ).draw( false );
              n++;

          }else if(data[i].status =='1'){ //validate for status borrowed  
          
            status='<span class="badge badge-warning">Borrowed</span>';
            <?php $role =$this->session->Role; ?>
              t.row.add( [
                data[i].itemcodeid+
                '&nbsp;<?php  
                if( $role==1 || $role==8){
                 ?><a href="<?php echo base_url() ?>items/edit/'+data[i].iditem+'" class="item-edit" dataid="'+data[i].iditem+'" data-toggle="tooltip" title="Edit item"><i class="mdi mdi-pencil"></i></a>'+
                 '<a href="#" class="item-delete text-danger" dataid="'+data[i].iditem+'"><i class="mdi mdi-delete" data-toggle="tooltip" title="Delete item"></i></a> <?php } ?>'+
                 '&nbsp;<a href="#" class="item-view" dataid="'+data[i].iditem+'" data-toggle="tooltip" title="Show item detail"><i class="mdi mdi-eye text-primary"></i></a>'+
                 '&nbsp; <?php  
                 if( $role==1 || $role==8){
                   ?> <a href="<?php echo base_url();?>items/returnItem/'+data[i].iditem+'" class="item" dataid="'+data[i].iditem+'"><i class="mdi mdi-redo-variant" id="return" data-toggle="tooltip" title="Return"></i></a><?php } ?>',

                   //display the data that get from database to table tbody 

                   data[i].item,data[i].cat,data[i].mat,data[i].condition,data[i].depat,data[i].locat,data[i].nameuser,data[i].owner,status
                   ] ).draw( false );
              n++; //count number on id 
          }else { //validate for status late 

            <?php $role =$this->session->Role; if( $role==1 || $role==8){?> //validate role if normal user will not display late status 
              status='<span class="badge badge-danger">Late</span>';
              <?php }else{ ?> //for normal user will display borrowed status instead of late status 
                status='<span class="badge badge-warning">Borrowed</span>';
              <?php } ?>

              t.row.add( [
                data[i].itemcodeid+
                '&nbsp;<?php  
                if( $role==1 || $role==8){
                 ?><a href="<?php echo base_url() ?>items/edit/'+data[i].iditem+'" class="item-edit" dataid="'+data[i].iditem+'" data-toggle="tooltip" title="Edit item"><i class="mdi mdi-pencil"></i></a>'+
                 '<a href="#" class="item-delete text-danger" dataid="'+data[i].iditem+'"><i class="mdi mdi-delete" data-toggle="tooltip" title="Delete item"></i></a> <?php } ?>'+
                 '&nbsp;<a href="#" class="item-view" dataid="'+data[i].iditem+'" data-toggle="tooltip" title="Show item detail"><i class="mdi mdi-eye text-primary"></i></a>'+
                 '&nbsp; <?php  
                 if( $role==1 || $role==8){
                   ?> <a href="<?php echo base_url();?>items/returnItem/'+data[i].iditem+'" class="item" dataid="'+data[i].iditem+'"><i class="mdi mdi-redo-variant" id="return" data-toggle="tooltip" title="Return"></i></a><?php } ?>',

                   data[i].item,data[i].cat,data[i].mat,data[i].condition,data[i].depat,data[i].locat,data[i].nameuser,data[i].owner,status
                   ] ).draw( false );
              n++;
          }

        }
      },
      error: function()
      {
        alert('Could not get Data from Database');
      }
    });
  }

  //  Combine btn onclick OK with key Enter when delete  
  $('#deleteModal').keypress(function(e){
    if(e.which === 13){//Enter key pressed
      e.preventDefault();
      $('#delete-comfirm').click();//Trigger search button click event
    }
  });

  // delete item by ajax when click on icon delete 
  $('#showdata').on('click', '.item-delete', function(){
    var id = $(this).attr('dataid');
    $('#deleteModal').data('id', id).modal('show');
  });

  // load modal confirmation when click delete icon 
  $("#delete-comfirm").on('click',function(){
    var id = $('#deleteModal').data('id');
    $.ajax({
      url: "<?php echo base_url() ?>items/deleteItems", // access to controller to delete from database 
      type: "POST",
      data: {iditem: id},
      dataType: "json",
      success: function(data){
        $('#deleteModal').modal('hide');
        //alert message when delete successfully 
        $('.alert-info').html('Item was deleted successfully').fadeIn().delay(4000).fadeOut('slow'); 
        showAllitems();
      },
      error: function(){
        $('#deleteModal').modal('hide');
        alert("Error delete! this item is has relationship with another...");
      }
    });
  });

  // load modal for show the detail an item when click on eye icon to show detail of each item that clicked 
  $('#showdata').on('click', '.item-view', function(){
    var id = $(this).attr('dataid');
    $.ajax({
     type: 'POST',
     data: {iditem: id},
     url: '<?php echo base_url();?>/items/showDetailItem', //access to controller to get all the detail item from database 
     async: true,
     dataType: 'json',
     success: function(data){
      // alert('success');
      $('#frm_view').html(data);
      $('#viewDetailModal').modal('show');
    },
    error: function(){
     alert('Could not get any data from Database');
   }
  });
  });

});
</script>
