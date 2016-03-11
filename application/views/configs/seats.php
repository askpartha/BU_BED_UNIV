
<div class="page-title">
	<h2>Seat Matrix</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Seat Matrix</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 data-content">
			<?php
				if($this->session->flashdata('success')) {
					echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
				} else if($this->session->flashdata('failure')) {
					echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
				}
				
			?>	
			<div class="box">
				<table class="wrl-table btm-mrgn-xs">
					<thead>
						<tr>
							<th style="width:3%;">Sl</th>
							<th style="width:7%;">University</th>
							<th style="width:7%;">Category</th>
							<th style="width:12%;">Method Type</th>
							<th style="width:13%;">Subjects</th>
							<th style="width:10%;">Reservation</th>
							<th style="width:4%;">D.A.</th>
							<th style="">Merit List Description</th>
							<th style="width:7%;">Resv. Seat</th>
							<th style="width:7%;">Ttl Cand</th>
						</tr>
					</thead>
					<tbody id="tbl-content"></tbody>
				</table>
				<div class="paginator pull-right btm-mrgn-sm"></div>
			</div>	<!-- /box -->
		</div>
		
	</div>
</div>

<?php
	$this->load->view('footer');
?>		

<script type="text/javascript">
var seats = '<?php echo json_encode($seats);?>';
var seats_data = jQuery.parseJSON(seats);

$(document).ready(function() {
	printAllSubjects(seats_data);
});	

function printAllSubjects(arr) {
	console.log(arr);
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var cand_category = arr[i].cand_ctgry;
				if(cand_category == 'F') cand_category = 'Freshers';
				else if(cand_category == 'D')cand_category = 'Deputed';
				 
				var is_reservation_pwd = arr[i].pwd;
				if(is_reservation_pwd == '0') is_reservation_pwd = 'No';
				else if(is_reservation_pwd == '1')is_reservation_pwd = 'Yes';
				 
				 
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].cand_univ_name + "</td>";
				s += "<td>" + arr[i].cand_ctgry_name + "</td>";
				s += "<td>" + arr[i].method_name + "</td>";
				s += "<td>" + arr[i].subjects + "</td>";
				s += "<td>" + arr[i].reservation_name + "</td>";
				s += "<td>" + is_reservation_pwd + "</td>";
				s += "<td>" + arr[i].description + "</td>";
				s += "<td>" + arr[i].seat_num + "</td>";
				s += "<td>" + arr[i].count + "</td>";
				
				/*
				s += "<td class='text-center'>"
								s += "<a href='javascript:void(0);' id='edit_" + i + "' class='btn btn-primary btn-xs edit-record'>Edit</a>&nbsp;&nbsp;";
								s += "<a href='javascript:void(0);' id='del_" + i + "' class='btn btn-danger btn-xs delete-record'>Delete</a>";
								s += "</td>";*/
				
				s += "</tr>";
			}
		}else {
	
		s += '<tr><td colspan="100%"><h3 class="top-mrgn-sm btm-mrgn-sm">No data available</h3></td></tr>';
	}
	$('#tbl-content').html(s);
}

//edit record
$(document).on('click','.edit-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	$('.addedit-label').html('Edit Seat Matrix');

	$('#cand_ctgry').val(seats_data[index].cand_ctgry);
	$('#method_type').val(seats_data[index].method_type);
	$('#reservation_code').val(seats_data[index].reservation_code);
	$('#is_reservation_pwd').val(seats_data[index].is_reservation_pwd);
	$('#num_seat').val(seats_data[index].num_seat);
	$('#record_id').val(seats_data[index].sm_id);

	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var sm_id = seats_data[index].sm_id;
	var params = "id="+sm_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/delseat/"+new Date().getTime();
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>configs/loadseats",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													printAllSubjects(response);
													seats_data = response;
													
													$('.action-message').remove();
													$('<div>').attr({
													    class: 'alert alert-success action-message'
													}).html('Record deleted succesfully').prependTo('.data-content');
					
												 }
							});
						
						
						
			    	}
			    }
			});    		
		}
	});	
	
});	

//cancel action
$(document).on('click','.cancel-btn',function() {
	$('.addedit-label').html('Create Seat Matrix');
	$('#form_action').val('add');
	
	$('#method_type').val('EMPTY');
	$('#is_reservation_pwd').val('0');
	$('#reservation_code').val('');
	$('#cand_ctgry').val('EMPTY');
	$('#num_seat').val('');
	
	$('#record_id').val(0);
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	$('select').removeClass('form-error');
	
	var cand_ctgry  		= $('#cand_ctgry').val();
	var method_type 		= $('#method_type').val();
	var reservation_code 	= $('#reservation_code').val();
	var num_seat 			= $('#num_seat').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(cand_ctgry == 'EMPTY') {
		error = true;
		$('#cand_ctgry').addClass('form-error');
	}
	if(method_type == 'EMPTY') {
		error = true;
		$('#method_type').addClass('form-error');
	}
	if(reservation_code == 'EMPTY' ||  reservation_code == '' ) {
		error = true;
		$('#reservation_code').addClass('form-error');
	}	
	if(num_seat == '') {
		error = true;
		$('#num_seat').addClass('form-error');
	}
	
	if(error) {
		$('#addeditform').before("<div class='error-msg'></div>");
		$('.error-msg').html(msg);
		return false;
	} else {
		$('#addeditform').submit();
	}
});	
</script>