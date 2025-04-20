<?php
ob_start();
session_start();
include ("../_init.php");

// Redirect, If user is not logged in
if (!is_loggedin()) {
  redirect(root_url() . '/index.php?redirect_to=' . url());
}

// Redirect, If User has not Read Permission
if (user_group_id() != 1 && !has_permission('access', 'read_sell_list')) {
  redirect(root_url() . '/'.ADMINDIRNAME.'/dashboard.php');
}

// Set Document Title
$document->setTitle(trans('title_invoice'));

// Add Script
$document->addScript('../assets/itsolution24/angular/modals/InstallmentPaymentModal.js');
$document->addScript('../assets/itsolution24/angular/modals/InstallmentViewModal.js');
$document->addScript('../assets/itsolution24/angular/controllers/InvoiceController.js');

// SIDEBAR COLLAPSE
$document->setBodyClass('sidebar-collapse');

// Include Header and Footer
include("header.php"); 
include ("left_sidebar.php");
?>

<!-- Content Wrapper Start -->
<div class="content-wrapper" ng-controller="InvoiceController">
	
	<!-- Content Header Start -->
	<section class="content-header">
		<?php include ("../_inc/template/partials/apply_filter.php"); ?>
		<h1>
		    <?php echo trans('text_sell_list_title'); ?>
		    <small>
		    	<?php echo store('name'); ?>
		    </small>
		</h1>
	  	<ol class="breadcrumb">
		    <li>
		    	<a href="dashboard.php">
		    		<i class="fa fa-dashboard"></i> 
		    		<?php echo trans('text_dashboard'); ?>
		    	</a>
		    </li>
		    <li class="active">
		    	<?php echo trans('text_sell_list_title'); ?>
		    </li>
	 	 </ol>
	</section>
	<!-- Content Header End -->

	<!-- Content Start -->
	<section class="content">

		<?php if(DEMO) : ?>
	    <div class="box">
	      <div class="box-body">
	        <div class="alert alert-info mb-0">
	          <p><span class="fa fa-fw fa-info-circle"></span> <?php echo $demo_text; ?></p>
	        </div>
	      </div>
	    </div>
	    <?php endif; ?>
	    
		<div class="row">
		    <div class="col-xs-12">
		      	<div class="box box-info">
		      		<div class="box-header">
				        <h3 class="box-title">
				        	<?php echo trans('text_invoices'); ?>
				        </h3>
				        <div class="pull-right">
									<!-- filepath: c:\xampp\htdocs\posmoderno\admin\invoice.php -->
					<div class="row">
						<!-- Columna para los filtros de fecha -->
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label for="startDate" class="control-label">
									<?php echo trans('text_start_date'); ?>
								</label>
								<input type="date" id="startDate" name="startDate" class="form-control" 
									   ng-model="filter.startDate" 
									   ng-change="applyFilter()"
									   ng-init="filter.startDate = todayDate"
									   value="<?php echo isset($request->get['startDate']) ? $request->get['startDate'] : ''; ?>">
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label for="endDate" class="control-label">
									<?php echo trans('text_end_date'); ?>
								</label>
								<input type="date" id="endDate" name="endDate" class="form-control" 
									   ng-model="filter.endDate" 
									   ng-change="applyFilter()"
									   ng-init="filter.endDate = todayDate"
									   value="<?php echo isset($request->get['endDate']) ? $request->get['endDate'] : ''; ?>">
							</div>
						</div>
					</div>
					
					<div class="row">
						<!-- Columna para el selector de cliente -->
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label for="customer_id" class="control-label">
									<?php echo trans('text_select_customer'); ?>
								</label>
								<div class="input-group">
									<div class="input-group-addon no-print">
										<i class="fa fa-users" id="addIcon" style="font-size: 1.2em;"></i>
									</div>
									<select id="customer_id" class="form-control" name="customer_id">
										<option value=""><?php echo trans('text_select'); ?></option>
										<?php foreach (get_customers() as $the_customer) : ?>
											<option value="<?php echo $the_customer['customer_id']; ?>">
												<?php echo $the_customer['customer_name']; ?>
											</option>
										<?php endforeach; ?>
									</select>
									<div class="input-group-addon no-print">
										<i class="fa fa-search" id="addIcon" style="font-size: 1.2em;"></i>
									</div>
								</div>
							</div>
						</div>
					
						<!-- Columna para el botón de filtro -->
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label class="control-label">
									<?php echo trans('text_filter_options'); ?>
								</label>
								<div class=" input-group btn-group">
									<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
										<span class="fa fa-fw fa-filter"></span> 
										<?php if (isset($request->get['type'])) : ?>
											<?php echo trans('text_' . $request->get['type']); ?>
										<?php else : ?>
											<?php echo trans('button_filter'); ?>
										<?php endif; ?>
										&nbsp;<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a href="invoice.php<?php echo $query_string ? $query_string . '&' : '?'; ?>">
												<?php echo trans('button_today_invoice'); ?>
											</a>
										</li>
										<li>
											<a href="invoice.php<?php echo $query_string ? $query_string . '&' : '?'; ?>type=all_invoice">
												<?php echo trans('button_all_invoice'); ?>
											</a>
										</li>
										<li>
											<a href="invoice.php<?php echo $query_string ? $query_string . '&' : '?'; ?>type=due">
												<?php echo trans('button_due_invoice'); ?>
											</a>
										</li>
										<li>
											<a href="invoice.php<?php echo $query_string ? $query_string . '&' : '?'; ?>type=all_due">
												<?php echo trans('button_all_due_invoice'); ?>
											</a>
										</li>
										<li>
											<a href="invoice.php<?php echo $query_string ? $query_string . '&' : '?'; ?>type=paid">
												<?php echo trans('button_paid_invoice'); ?>
											</a>
										</li>
										<li>
											<a href="invoice.php<?php echo $query_string ? $query_string . '&' : '?'; ?>type=inactive">
												<?php echo trans('button_inactive_invoice'); ?>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
			            </div>
				     </div>
			      	<div class='box-body'>  
						<div class="table-responsive"> 
						<?php
				            $hide_colums = "";
				            if (user_group_id() != 1) {
				            	if (! has_permission('access', 'sell_payment')) {
				                $hide_colums .= "4,";
				              }
				              if (! has_permission('access', 'create_sell_return')) {
				                $hide_colums .= "5,";
				              }
				               if (! has_permission('access', 'read_sell_invoice')) {
				                $hide_colums .= "6,";
				              }
				              if (! has_permission('access', 'update_sell_invoice_info')) {
				                $hide_colums .= "7,";
				              }
				              if (! has_permission('access', 'delete_sell_invoice')) {
				                $hide_colums .= "8,";
				              }
				            }
				          ?>  

						  <table id="invoice-invoice-list"  class="table table-bordered table-striped table-hover" data-hide-colums="<?php echo $hide_colums; ?>">
						    <thead>
						      	<tr class="bg-gray">
							        <th class="w-20">
							        	<?php echo trans('label_invoice_id'); ?>
							        </th>
							        <th class="w-20">
							        	<?php echo trans('label_datetime'); ?>
							        </th>
							        <th class="w-20">
							        	<?php echo trans('label_customer_name'); ?>
							        </th>
							        <th class="w-7">
							        	<?php echo trans('label_status'); ?>
							        </th>
							        <th class="w-7">
							        	<?php echo trans('label_pay'); ?>
							        </th>
							        <th class="w-7">
							        	<?php echo trans('label_return'); ?>
							        </th>
							        <th class="w-7">
							        	<?php echo trans('label_view'); ?>
							        </th>
							        <th class="w-7">
							        	<?php echo trans('label_edit'); ?>
							        </th>
							        <th class="w-7">
							        	<?php echo trans('label_delete'); ?>
							        </th>
						      	</tr>
						    </thead>
						     <tfoot>
			               		<tr class="bg-gray">
							        <th class="w-20">
							        	<?php echo trans('label_invoice_id'); ?>
							        </th>
							        <th class="w-20">
							        	<?php echo trans('label_datetime'); ?>
							        </th>
							        <th class="w-20">
							        	<?php echo trans('label_customer_name'); ?>
							        </th>
							        <th class="w-7">
							        	<?php echo trans('label_status'); ?>
							        </th>
							        <th class="w-7">
							        	<?php echo trans('label_pay'); ?>
							        </th>
							        <th class="w-7">
							        	<?php echo trans('label_return'); ?>
							        </th>
							        <th class="w-7">
							        	<?php echo trans('label_view'); ?>
							        </th>
							        <th class="w-7">
							        	<?php echo trans('label_edit'); ?>
							        </th>
							        <th class="w-7">
							        	<?php echo trans('label_delete'); ?>
							        </th>
			               		</tr>
		            		</tfoot>
						  </table>
						</div>  
			  		</div>
		      	</div>
		    </div>
	    </div>
	</section>
	<!-- Content End -->
</div>
<!-- Content Wrapper End -->

<?php include ("footer.php"); ?>