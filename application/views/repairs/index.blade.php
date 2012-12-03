@layout('shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('shared/user_sidebar')
    </div>
    <div class="span9">
        <h1>Product Repairs</h1>
        <div class="well" style="text-align: center">
        	<table class="table table-striped">
        		<thead>
        			<th></th>
        			<th>Name</th>
        			<th>Product Name</th>
                    <th>Setup Place</th>
        			<th>Repairing Date</th>
        			<th></th>
        			<th></th>
        		</thead>
        		<tbody>
	        	@forelse($repairs->results as $repair)
	        	<tr data-repair-id="{{$repair->id}}">
	        		<td></td>
	        		<td>{{ $repair->name }}</td>
	        		<td>{{ Product::find((int)$repair->product_id)->name }}</td>
	        		<td>{{ $repair->setup_place }}</td>
	        		<td>{{ $repair->date }}</td>
	        		<td>
	        			{{ HTML::link('#', 'Detail', array('class'=>'btn btn-info no-margin', 'style'=>'vertical-align: top;', 'rel' => 'popover', 'data-placement' => 'top',  'data-content' => $repair->detail,  'data-original-title' => 'Details')) }}
	        			{{ HTML::link('/repairs/'.$repair->id.'/delete', 'Delete', array('class'=>'btn btn-danger no-margin', 'style'=>'vertical-align: top;')) }}
	        		</td>
	        		<td>
		        		<?php $status = StatusRepair::where_repair_id($repair->id)->first(); ?>
	        			@if(Sentry::user()->in_group('superuser'))
		        			{{ Form::select('status', $repair_status, array_search($status->title, $repair_status), array('width'=>'50')) }}
		        		@else
		        			@if($status->title == 'fixed')
		        				<span class="label label-success">{{$status->title}}</span>
		        			@elseif($status->title == 'checking')
		        				<span class="label label-warning">{{$status->title}}</span>
		        			@else
		        				<span class="label">{{$status->title}}</span>
		        			@endif
	        			@endif
	        		</td>
	        	</tr>
	        	@empty
	        	<tr>
	        		<td colspan="6">No product repair.</td>
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
	$('select[name=status]').change(function(){
		var status = $(':selected', this).text();
		var repair_id= $(this).closest('tr').attr('data-repair-id');
		$.post('/repairs', {title: status, repair_id: repair_id}, function(result){
			console.log(result);
		})
	});
	$('a[data-confirm]').bind('click', function(e){
        if(confirm($(this).attr('data-confirm'))) return true;
        e.preventDefault();
    });
});
</script>
@endsection