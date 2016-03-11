<style>
a.result-page {
    display: inline-block;
    padding: 0px 9px;
    margin: 6px;
    border-radius: 3px;
    border: solid 1px #c0c0c0;
    background: #e9e9e9;
    box-shadow: inset 0px 1px 0px rgba(255,255,255, .8), 0px 1px 3px rgba(0,0,0, .1);
    font-size: 1em;
    font-weight: bold;
    text-decoration: none;
    color: #717171;
    text-shadow: 0px 1px 0px rgba(255,255,255, 1);
}

a.result-page:hover, a.result-page.gradient:hover {
    background: #fefefe;
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#FEFEFE), to(#f0f0f0));
    background: -moz-linear-gradient(0% 0% 270deg,#FEFEFE, #f0f0f0);
}

a.result-page.active {
    border: none;
    background: #616161;
    box-shadow: inset 0px 0px 8px rgba(0,0,0, .5), 0px 1px 0px rgba(255,255,255, .8);
    color: #f0f0f0;
    text-shadow: 0px 0px 3px rgba(0,0,0, .5);
}
</style>

<div class="page-title">
	<h2>Notifications</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Reports </li>
		<li class="">Notifications</li>
	</ul>
</div>	<!-- /heading -->
<div class="container-fluid">
		
	
	<?php
		$form = array(
						'class'	=>	'form-horizontal lft-pad-nm',
						'role'	=>	'form',
						'id' => 'searchform'
					);	
		echo form_open('reports/notifications', $form);
	?>
	<div class="row">
		<div class="col-sm-3">
			<div class="form-group">
				<label>Candidate Category</label>
					<?php
						$ctgry_data = 'id="cand_ctgry" class="col-xs-10 col-sm-10 "';				
						echo form_dropdown('cand_ctgry', $cand_category_option, null, $ctgry_data);
					?>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label>Merit Type</label>
				<select id="merit_type" name="merit_type" class="col-xs-11 col-sm-11 ">
					
				</select>
			</div>
		</div>
		
		<div class="col-sm-3">	
			<div class="form-group">
				<label>&nbsp;</label>
				<button type="button" class="btn btn-success download-btn">Notifications</button>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3">
			<div class="form-group">
				<label>Start Rank</label>
				<?php
					$start_rank_data = array(
			              					'name'        	=> 'start_rank',
											'id'          	=> 'start_rank',
											'tabindex'      => '4',
											'class'			=>	'col-xs-10 col-sm-10 input-number'
			            				);

					echo form_input($start_rank_data);
				?>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="form-group">
				<label>End Rank(inclusive)</label>
				<?php
					$end_rank_data = array(
			              					'name'        	=> 'end_rank',
											'id'          	=> 'end_rank',
											'tabindex'      => '5',
											'class'			=>	'col-xs-10 col-sm-10 input-number'
			            				);

					echo form_input($end_rank_data);
				?>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label>Message</label>
				<?php
					$notification_message_data = array(
			              					'name'        	=> 'notification_message',
											'id'          	=> 'notification_message',
											'tabindex'      => '6',
											'rows'      => '3',
											'maxlength' => 100,
											'class'			=>	'col-xs-11 col-sm-11'
			            				);

					echo form_textarea($notification_message_data);
				?>
			</div>
			<label id="characterLeft" style="margin-top: -20px; margin-left: -15px;"></label>
		</div>
	</div>
		
		<?php	
			echo form_close();
		?>
	
	
<?php
	$this->load->view('footer');
?>
<script type="text/javascript">

	$('.input-number').keypress(function (key){
		if(key.charCode==0) return true;
		if(key.charCode<48 || key.charCode>57 )return false;
	});
	$('.input-number').keydown(function (key){
		if(key.charCode==0) return true;
		if(key.charCode<48 || key.charCode>57 )return false;
	});
	$('.input-number-decimal').keyup(function (){
		var $this = $(this);
    	$this.val($this.val().replace(/[^\d.]/g, ''));
	});
	

	//make all the input text box value as upper case
	$(document).on('keyup','input',function() {
		this.value = this.value.toLocaleUpperCase();
	});
	$(document).on('keydown','input',function() {
		this.value = this.value.toLocaleUpperCase();
	});
	$('input').bind('keypress',function(event) {
		if(event.charCode == 39 || event.charCode == 34 || event.charCode == 96 || event.charCode == 126 || event.charCode==42 || event.charCode==37){
			jAlert('This special character not allowd.');
			return false;
		}
	});

	$('#characterLeft').text('100 characters left');
	$('#notification_message').keyup(function () {
	    var max = 100;
	    var len = $(this).val().length;
	    if (len >= max) {
	        $('#characterLeft').text(' you have reached the limit');
	    } else {
	        var ch = max - len;
	        $('#characterLeft').text(ch + ' characters left');
	    }
	});

function loadDropDown(){
	var params = "cand_ctgry="+$("#cand_ctgry").val()+"&type=false";
	$.ajax({
			url: "<?php echo $this->config->base_url();?>results/getmeritlistoption/"+new Date().getTime(),
			type: "post",
			data: params,
			dataType: "json",
			success: function(response){
				PrintMethodOptiondata(response);
			 }
		});	
}

function PrintMethodOptiondata(data){
	$('#merit_type').html('');
	var option_item = "<option value='EMPTY'></option>";
	for(var i=0; i<data.length; i++){
		option_item += '<option value="'+data[i]['sl_no']+'">'+data[i]['description'] +' ('+data[i]['seat_num']+' Seats) </option>';
	}
	$('#merit_type').html(option_item);
}

$(document).on('click','.download-btn',function() {
	if(formValidation()){
		jConfirm(confirmMessageTemplate(), 'PLEASE CONFIRM', function(e) {
			if (e) {
				$('#searchform').submit();	
			}
		})
	}
});	


  function confirmMessageTemplate(){
	var message = 'Would you like to generate the notification with the below information. ';
		message += '\n <b>Start Rank :</b>' +$("#start_rank").val() ;
		message += '\n <b>End Rank :</b>' +$("#end_rank").val() ;
	return message;	
  }
	
  function formValidation(){
		$('.error-msg').remove();
		$('input').removeClass('form-error');
		$('select').removeClass('form-error');
		
		var message = '';
		message += validateAllVariable();
		
		if(message == ''){
			return true;
		}else{
			$('#addeditform').before("<div class='error-msg'></div>");
			//$('.error-msg').html(message);
			jAlert('<b>Your form contains some error. Please check.</b><br/>'+message);
			return false;
		}
		return true;
	}
	
  function validateAllVariable(){
		var msg = '';
			if($("#merit_type").val() == '' || $("#merit_type").val() == 'EMPTY' || $("#merit_type").val() == 'undefined'){
				msg += "<span><i class='fa fa-arrow-right'></i>Please select merit type<br/></span>"; 
				$('#merit_type').addClass('form-error');
			}
			if($("#cand_ctgry").val() == '' || $("#cand_ctgry").val() == 'EMPTY' || $("#cand_ctgry").val() == 'undefined'){
				msg += "<span><i class='fa fa-arrow-right'></i>Please select application category<br/></span>"; 
				$('#cand_ctgry').addClass('form-error');
			}
			if($("#appl_reservation").val() == '' || $("#appl_reservation").val() == 'EMPTY' || $("#appl_reservation").val() == 'undefined'){
				msg += "<span><i class='fa fa-arrow-right'></i>Please select reservation<br/></span>"; 
				$('#appl_reservation').addClass('form-error');
			}
			var flag = true;
			if($("#start_rank").val() == ''){
				msg += "<span><i class='fa fa-arrow-right'></i>Please entered starting rank<br/></span>"; 
				$('#start_rank').addClass('form-error');
				flag = false;
			}
			if($("#end_rank").val() == ''){
				msg += "<span><i class='fa fa-arrow-right'></i>Please entered ending rank<br/></span>"; 
				$('#end_rank').addClass('form-error');
				flag = false;
			}
			
			if(flag && $("#start_rank").val() > $("#end_rank").val()){
				msg += "<span><i class='fa fa-arrow-right'></i>Starting rank can't be greater than ending rank<br/></span>"; 
				$('#start_rank').addClass('form-error');
				$('#end_rank').addClass('form-error');
			}
			
			if($("#notification_message").val() == ''){
				msg += "<span><i class='fa fa-arrow-right'></i>Please entered notification message<br/></span>"; 
				$('#notification_message').addClass('form-error');
			}
		return msg;
	}

$(document).on('change','#cand_ctgry',function() {
	var page = 1;
	loadDropDown();
});	


$("#cand_ctgry").val('EMPTY');

</script>	