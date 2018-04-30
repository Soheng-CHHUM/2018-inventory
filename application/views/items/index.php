<?php
/**
 * This view displays the list of users.
 * @copyright  Copyright (c) 2014-2018 Benjamin BALET
 * @license    http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link       https://github.com/bbalet/skeleton
 * @since      1.0.0
 */
?>

<div id="container">
	<div class="row-fluid">
		<div class="col-12">

<h2><?php echo $title;?></h2>

<?php echo $flashPartialView;?>

<table id="users" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" width="100%">
    <thead>
        <tr>
            <th>Identifier</th>
            <th>Name</th>
            <th>Category</th>
            <th>Material</th>
            <th>Condiction</th>
            <th>Department</th>
            <th>Location</th>
            <th>User</th>
            <th>Owner</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($users as $user):?>
    <tr>
        <td data-order="<?php echo $user['id']; ?>" data-id="<?php echo $user['id'];?>">
            <?php echo $user['id'] ?>&nbsp;
            <a href="#" class="confirm-delete" title="Delete user"><i class="mdi mdi-delete"></i></a>
            <a href="<?php echo base_url();?>users/edit/<?php echo $user['id'] ?>" title="Edit user"><i class="mdi mdi-pencil"></i></a>
        </td>
        <td><!-- <?php echo $user['firstname']; ?> -->Panha Huor</td>
        <td><!-- <?php echo $user['lastname']; ?> -->Air Condictioner</td>
        <td><!-- <?php echo $user['login']; ?> -->Iron</td>
        <td><!-- <a href="mailto:<?php echo $user['email']; ?>"><?php echo $user['email']; ?> </a> -->Broken</td>
        <td><!-- <?php echo $user['roles_list']; ?> -->Admin/ Finance</td>
        <td><!-- <?php echo $user['roles_list']; ?> -->B22</td>
        <td><!-- <?php echo $user['roles_list']; ?> -->Benjamin BALET</td>
        <td><!-- <?php echo $user['roles_list']; ?> -->PNC</td>
    </tr>
<?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row-fluid"><div class="col-12">&nbsp;</div></div>

  <div class="row-fluid">
      <div class="col-12">
        <a href="<?php echo base_url();?>items/create" class="btn btn-primary"><i class="mdi mdi-plus-circle"></i>&nbsp;Create a new item</a>
      </div>
  </div>

</div>

<link href="<?php echo base_url();?>assets/DataTable/DataTables-1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>assets/DataTable//DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/DataTable//DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    //Transform the HTML table in a fancy datatable
    $('#users').dataTable({
        stateSave: true,
    });
    //$("#frmResetPwd").alert();
    //$("#frmConfirmDelete").alert();

    //On showing the confirmation pop-up, add the user id at the end of the delete url action
    /*$('#frmConfirmDelete').on('show', function() {
        var link = "<?php echo base_url();?>users/delete/" + $(this).data('id');
        $("#lnkDeleteUser").attr('href', link);
    });*/

    //Display a modal pop-up so as to confirm if a user has to be deleted or not
    //We build a complex selector because datatable does horrible things on DOM...
    //a simplier selector doesn't work when the delete is on page >1
    $("#users tbody").on('click', '.confirm-delete',  function(){
        var id = $(this).parent().data('id');
				var link = "<?php echo base_url();?>users/delete/" + id;
				$("#lnkDeleteUser").attr('href', link);
        $('#frmConfirmDelete').modal('show');
    });

		$("#users tbody").on('click', '.reset-password',  function(){
        var id = $(this).parent().data('id');
				var link = "<?php echo base_url();?>users/reset/" + id;
				$("#formResetPwd").prop("action", link);
        $('#frmResetPwd').modal('show');
    });

    //Prevent to load always the same content (refreshed each time)
    /*$('#frmConfirmDelete').on('hidden', function() {
        $(this).removeData('modal');
    });
    $('#frmResetPwd').on('hidden', function() {
        $(this).removeData('modal');
    });*/
});
</script>
