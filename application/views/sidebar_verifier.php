<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
        	<i class="fa fa-child"></i> User Management
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
	    <div class="panel-body">
			<ul class="nav nav-list">
				<li><?php echo anchor('users/changepass', 'Change Password', 'title="Change Password"');?></li>
			</ul>
		</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
</div><!-- /panel panel-default -->

<div class="panel panel-default">
	<div class="panel-heading">
  		<h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
	        	<i class="fa fa-graduation-cap"></i> Admissions
	        </a>
  		</h4>
	</div>
	<div id="collapseTwo" class="panel-collapse collapse">
    	<div class="panel-body">
			<ul class="nav nav-list">
				<li><?php echo anchor('students/application', 'Application', 'title="Application"');?></li>
				<li><?php echo anchor('admissions/confirmpayment', 'Payment Update', 'title="Payment Update"');?></li>
				<li><?php echo anchor('admissions/revokepayment', 'Payment Revoke', 'title="Payment Revoke"');?></li>
			</ul>
		</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
</div><!-- /panel panel-default -->

<div class="panel panel-default">
	<div class="panel-heading">
  		<h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
	        	<i class="fa fa-bar-chart-o"></i> Reports
	        </a>
  		</h4>
	</div>
	<div id="collapseThree" class="panel-collapse collapse">
    	<div class="panel-body">
			<ul class="nav nav-list">
				<li><?php echo anchor('reports/payments', 'Payment Confirmation', 'title="Payment Confirmation"');?></li>
			</ul>
		</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
</div><!-- /panel panel-default -->															