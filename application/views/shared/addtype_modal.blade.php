<div class="modal hide" id="addtype_modal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>New Type</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('/chemicals/addtype') }}" id="addtype_modal_form">
			<label for="name">Type Name</label>
			<input type="text" name="name" >
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#addtype_modal_form').submit();" class="btn btn-primary">Add</a>
	</div>
</div>