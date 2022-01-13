<style>
	.select2.select2-container.select2-container--default {
		width: 100% !important;
	}
	.accordion .accordion-header[aria-expanded="true"]{
		box-shadow: 0 2px 6px #891635!important;
		background-color: #891635!important;
	}

</style>
<div class="modal fade" tabindex="-1" role="dialog" id="fire-modal-billing"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Billing Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="uploadBilling" method="post" data-form-valid="saveBilling" onsubmit="return false">
				<div class="modal-body py-0">
					<div class="card my-0 shadow-none">
						<div class="card-body">
							<div class="form-group my-0 py-0">
								<label>Service Name</label>
								<input type="hidden" name="forward_billing" id="forward_billing">
								<input type="hidden" name="billing_patient_id" id="billing_patient_id" >
								<select id="bservice_name" name="bservice_name" class="form-control" onchange="getServiceDescription(this.value)">
									<option value="">No data found</option>
								</select>
							</div>
							
							<div class="form-group my-0 py-0">
								<label>Service Description</label>
								
								<select id="bservice_desc" name="bservice_desc" class="form-control" onchange="getServiceRate(this.value)">
									<option value="">No data found</option>
								</select>
							</div>
							<div class="form-group my-0 py-0">
								<label>Unit</label>
								<input type="number" name="billing_unit" id="billing_unit" value="1" class="form-control">
								
							</div>
							<div class="form-group my-0 py-0">
								<label>Rate</label>
								<input type="hidden" name="billing_service_id" id="billing_service_id" value="1">
								<div id="divBillingRate">
									
									<input type="text" name="billing_rate" class="form-control" id="billing_rate">
								</div>
								
							</div>
							<div class="form-group my-0 py-0">
								<label>Date Service</label>
								<input type="date" name="billing_date" class="form-control" id="billing_date">
								
							</div>
							<div class="form-group my-0 py-0">
								<label>Detail</label>
								<input type="text" name="billing_detail" class="form-control" id="billing_detail">
								
							</div>
							<div class="form-group my-0 py-0">
								<label>File Upload</label>
								<input type="file" name="billing_file[]" class="form-control" id="billing_file">
								
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary mr-1" type="submit">Submit</button>
					<button class="btn btn-secondary" type="reset">Reset</button>
				</div>
			</form>
		</div>
	</div>
</div>
