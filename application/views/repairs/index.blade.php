@layout('shared/user_header')

@section('content')
<div class="row">
    <div class="span2">
        @include('shared/user_sidebar')
    </div>
    <div class="span10">
        <h1>Product Repairs</h1>
        <div class="well" style="text-align: center">
        	<table class="table table-striped">
        		<thead>
        			<th></th>
        			<th>Student Code</th>
        			<th>Serial no</th>
                    <th>Setup Place</th>
        			<th>Repairing Date</th>
        			<th></th>
        			<th>Status</th>
        			<th>Fix Cost</th>
        		</thead>
        		<tbody>
	        	@forelse($repairs->results as $repair)
	        	<tr data-repair-id="{{$repair->id}}">
	        		<td></td>
	        		<td>{{ Sentry::user($repair->user_id)->metadata['student_code'] }}</td>
	        		<td>{{ Product::find((int)$repair->product_id)->serial_no }}</td>
	        		<td>{{ $repair->setup_place }}</td>
	        		<td>{{ $repair->date }}</td>
	        		<td>
		        		<?php $status = StatusRepair::where_repair_id($repair->id)->first(); ?>
	        			{{ HTML::link('#', 'Detail', array('class'=>'btn btn-info no-margin', 'style'=>'vertical-align: top;', 'rel' => 'popover', 'data-placement' => 'top',  'data-content' => $repair->detail,  'data-original-title' => 'Details')) }}
	        			{{ HTML::link('/repairs/'.$repair->product_id.'/tracking', 'Tracking', array('class'=>'btn', 'style'=>'vertical-align: top;')) }}
	        			@if($status->title == 'pending')
	        				{{ HTML::link('/repairs/'.$repair->id.'/delete', 'Delete', array('class'=>'btn btn-danger no-margin', 'style'=>'vertical-align: top;')) }}
	        			@endif
	        		</td>
	        		<td>
	        			@if(Sentry::user()->in_group('superuser') && $repair->fix_cost <= 0)
		        			{{ Form::select('status', $repair_status, array_search($status->title, $repair_status), array('width'=>'50')) }}
		        		@elseif(Sentry::user()->in_group('teacher') && $repair->fix_cost <= 0)
		        			{{ Form::select('status', $repair_status, array_search($status->title, $repair_status), array('width'=>'50')) }}
		        		@else
		        			@if($status->title == 'fixed')
		        				<span class="label label-success">{{$status->title}}</span>
		        			@elseif($status->title == 'checking' || $status->title == 'accept')
		        				<span class="label label-warning">{{$status->title}}</span>
		        			@elseif($status->title == 'reject')
		        				<span class="label label-important">{{$status->title}}</span>
		        			@else
		        				<span class="label">{{$status->title}}</span>
		        			@endif
	        			@endif
	        		</td>
	        		<td>
	        			<input type="text" name="fix_cost" class="fix_cost" style="width:50px;vertical-align:top;" readonly="true" value="{{$repair->fix_cost}}">
	        			<a href="#" class="btn add_fix_cost">Add</a>
	        		</td>
	        	</tr>
	        	@empty
	        	<tr>
	        		<td colspan="8">No product repair.</td>
	        	</tr>
	        	@endforelse
        		</tbody>
        	</table>
        	{{ $repairs->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
	$('.btn.btn-info').popover();
	$('select :selected').each(function(){
		if($(this).text() == 'fixed') $(this).closest('tr').find('.fix_cost').attr('readonly', false);
	});
	$('select[name=status]').change(function(){
		var status = $(':selected', this).text();
		var repair_id= $(this).closest('tr').attr('data-repair-id');
		if(status == 'fixed'){
			$(this).closest('tr').find('.fix_cost').attr('readonly', false);	
		}else{
			$(this).closest('tr').find('.fix_cost').attr('readonly', true);	
		}
		if(status != "fixed"){
			$.post('/repairs', {title: status, repair_id: repair_id, fix_cost: 0}, function(result){
				alert(result);
			});
		}
	});
	$('a[data-confirm]').bind('click', function(e){
        if(confirm($(this).attr('data-confirm'))) return true;
        e.preventDefault();
    });
    $('a.add_fix_cost').click(function(e){
    	e.preventDefault();
    	var fix_cost = $(this).closest('tr').find('.fix_cost').val();
    	var status = $(this).closest('tr').find('select :selected').text();
    	var repair_id= $(this).closest('tr').attr('data-repair-id');
    	if(status == "fixed"){
	    	$.post('/repairs', {title: status, repair_id: repair_id, fix_cost: fix_cost}, function(result){
				alert(result);
			});
    	}else{
    		alert('Cannot add because status is not fixed');
    	}
    });
    
});
</script>
@endsection