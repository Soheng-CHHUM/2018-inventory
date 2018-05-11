<?php
/**
 * This view displays the list of users.
 * @copyright  Copyright (c) 2014-2018 Benjamin BALET
 * @license    http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link       https://github.com/bbalet/skeleton
 * @since      1.0.0
 */
?>
<!-- this is location layout -->
<div id="container" class="container">
  <div class="row-fluid">
    <div class="col-12">
      <h2><?php echo $title;?></h2>
      <div class="alert alert-success" style="display: none;"></div>
      <table id="location" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" width="100%">
        <thead>
          <tr>
            <th>ID</th>
            <th>Location</th>
          </tr>
        </thead>
        <tbody id="showdata">

        </tbody>
      </table>
    </div>
  </div>
  <div class="row-fluid"><div class="col-12">&nbsp;</div></div>
  <!-- create new owner -->
  <?php $validateUser = $this->session->fullname;
  if ($validateUser == 'Admin') {
    ?>
    <div class="container">
      <div class="row-fluid">
        <div class="col-12">
          <button type="button" class="btn btn-primary add-location" id="add-location">
            <i class="mdi mdi-plus-circle"></i>&nbsp;Create Location
          </button>
        </div>
      </div>
    </div>
    <?php } ?>

    <!-- create -->
    <div id="frmConfirmAdd" class="modal hide fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create Location</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="frm_create">
              <div class="form-inline">
                <label for="">location: </label> &nbsp;<input type="text" class="form-control" name="create_location">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-primary create" id="create">OK</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>

    <!-- delete -->
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
            <p>Are you sure that you want to delete this location?</p>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-primary" id="delete-comfirm">Yes</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>

    <!-- edit -->
    <div id="frmConfirmEdit" class="modal hide fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Location</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="frm_edit">

          </form>
          <div class="modal-footer">
            <a href="#" class="btn btn-primary " id="update">OK</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
    <link href="<?php echo base_url();?>assets/DataTable/DataTables-1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url();?>assets/DataTable//DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/DataTable//DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        var t = $('#location').DataTable();
        showAlllocat();

// showAll location function get owner data to table 
function showAlllocat()
{
  $.ajax({
    type: 'ajax',
    url: '<?php echo base_url();?>/locations/showAlllocat',
    async: true,
    dataType: 'json',
    success: function(data){
      t.clear().draw();
      var n = 1;
      var i;
      for(i=0; i<data.length; i++){
        t.row.add( [
          <?php $validateUser = $this->session->fullname;
          if ($validateUser == 'Admin') {
            ?>
            '<a href="#" class="item-edit" dataid="'+data[i].idlocation+'"><i class="mdi mdi-pencil"></i></a>'+
            '<a href="#" class="item-delete" dataid="'+data[i].idlocation+'"><i class="mdi mdi-delete"></i></a>'
          <?php } ?>
            +n,
            data[i].location
            ] ).draw( false );
        n++;
      }
    },
    error: function(){
      alert('Could not get Data from Database');
    }
  });
}

// create_location with ajax
$("#add-location").click(function(){
  $('#frmConfirmAdd').modal('show');
});
// save new location button even
$("#create").click(function(){
  var locationName = $('input[name=create_location]');
  var result = '';
  if(locationName.val()==''){
    locationName.parent().parent().addClass('has-error');
  }else{
    locationName.parent().parent().removeClass('has-error');
    result +='1';
  }
  if (result=='1') {
    $.ajax({
      url: "<?php echo base_url()?>locations/create",
      type: "POST",
      data: $('#frm_create').serialize(),
      dataType: 'json',
      success: function(data){
        if(data.status){
          $('#frm_create')[0].reset();
          $('#frmConfirmAdd').modal('hide');
          $('.alert-success').html('Location add successfully').fadeIn().delay(4000).fadeOut('slow');
          showAlllocat();
        }
      },
      error: function(){
        alert("Error ...");
      }
    });
  }
});

// delete locatiom by ajax
$('#showdata').on('click', '.item-delete', function(){
  var id = $(this).attr('dataid');
  $('#deleteModal').data('id', id).modal('show');
});

// comfirm delete button
$("#delete-comfirm").on('click',function(){
  var id = $('#deleteModal').data('id');
  $.ajax({
    url: "<?php echo base_url() ?>locations/deletelocat",
    type: "POST",
    data: {idlocation: id},
    dataType: "json",
    success: function(data){
      $('#deleteModal').modal('hide');
      $('.alert-success').html('Location Delete Successfully').fadeIn().delay(4000).fadeOut('slow');
      showAlllocat();
    },
    error: function(){
      alert("Error....This location have relationshipe with another field...");
      $('#deleteModal').modal('hide');
    }
  });
});


// update location modal pop up by ajax
$('#showdata').on('click', '.item-edit', function(){
  var id = $(this).attr('dataid');
  $.ajax({
    type: 'POST',
    data: {idlocation: id},
    url: '<?php echo base_url();?>/locations/showEditlocat',
    async: true,
    dataType: 'json',
    success: function(data){
      $('#frm_edit').html(data);
      $('#frmConfirmEdit').modal('show');
    },
    error: function(){
      alert('Could not get any data from Database');
    }
  });
});

// save update button 
$("#update").click(function(){
  var id = $('#frmConfirmEdit').data('id');
  var locationName = $('input[name=update_location]');
  var result = '';
  if(locationName.val()==''){
    locationName.parent().parent().addClass('has-error');
  }else{
    locationName.parent().parent().removeClass('has-error');
    result +='1';
  }
  if (result=='1') {
    $.ajax({
      url: "<?php echo base_url()?>locations/update",
      type: "POST",
      data: $('#frm_edit').serialize(),
      dataType: 'json',
      success: function(data){
        if(data.status){
          $('#frm_edit')[0].reset();
          $('#frmConfirmEdit').modal('hide');
          $('.alert-success').html('Location Update Successfully').fadeIn().delay(4000).fadeOut('slow');
          showAlllocat();
          // alert('success');
        }
      },
      error: function(){
        alert("Error update! this field has relationship with another field...");
        $('#frmConfirmEdit').modal('hide');
      }
    });
  }
});    

});
</script>
