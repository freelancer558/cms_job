<div class="modal hide" id="add_requisition_modal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Send Requisition</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('/requirements/requisition') }}" id="add_requisition_modal_form">
			<label for="chemical_id">Type Name</label>
			<select name="chemical_id" id="chemical_id">
				@foreach($chemicals as $chemical)
				<option value="{{$chemical->id}}" data-total="{{$chemical->sum}}">{{ $chemical->name }}</option>
				@endforeach
			</select>

			<label for="total">Total</label>
			<input type="text" name="total" id="total">
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#add_requisition_modal_form').submit();" class="btn btn-primary">Add</a>
	</div>
</div>


<script type="text/javascript">
$(document).ready(function(){
    $('#total').blur(function(){
    	var total = parseInt($('#chemical_id :selected').attr('data-total'));
    	if(parseInt($(this).val()) > total){
    		alert('This Chemical remain ' + total);
    		$(this).focus();
    	}
    });
});
</script>
