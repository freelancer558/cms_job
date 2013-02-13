<div class="modal hide" id="add_requisition_modal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Send Requisition</h3>
	</div>
	<div class="modal-body">
		@if(empty($chemicals))
			<h1>No chemical</h1>
		@else
		<form method="POST" action="{{ URL::to('/requirements/requisition') }}" id="add_requisition_modal_form">
			<label for="chemical_name">Type Name</label>
			<input type="text" name="chemical_name" id="search_chemical">

			<label for="total">Total</label>
			<input type="text" name="total" id="total">
			<input type="hidden" name="chemical_id" id="chemical_id">
	    </form>
	   @endif
	</div>
	<div class="modal-footer">
		@if(!empty($chemicals))
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    <button type="button" onclick="$('#add_requisition_modal_form').submit();" class="btn btn-primary">Add</a>
    @endif
	</div>
</div>


<script type="text/javascript">
$(document).ready(function(){
    $('#total').blur(function(){
    	var total = parseInt($('.chemical_total').attr('data-total'));
    	if(parseInt($(this).val()) > total){
    		alert('This Chemical remain ' + total);
    		$(this).focus();
    	}
    });
    $.get('/chemicals/search_by_name', function(result){
    	var arr = [];
    	// for(var value in result) arr.push(result[value]+", "+value);
        for(var value in result) {
          arr.push(result[value]);
          $('.modal-body').append('<input type="hidden" name="'+result[value]+'" class="'+result[value]+'" value="'+value+'">')
        }
      $( "#search_chemical" ).autocomplete({
        source: arr,
        select: function( event, ui ) {
        	var chemical_id = $('input.'+result[value].trim()).val();
          console.log(chemical_id);
        	$('#chemical_id').val(chemical_id);
        	$.get('/chemicals/'+chemical_id+'/info', function(result){
        		var $chemical = result.attributes;
        		$('<span class="chemical_total" data-total="'+$chemical.sum+'"> ('+$chemical.sum+')</span>')
        			.appendTo('label[for=total]');
        	}, 'json');
        }
      });
    }, 'json');
});
</script>
