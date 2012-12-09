@layout('shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('shared/user_sidebar')
    </div>
    <div class="span9">
        <h1>Tracking</h1>
        <div class="well" style="text-align: center">
        	<table class="table table-striped">
        		<thead>
        			<th></th>
        			<th>Student Code</th>
                    <th>Setup Place</th>
        			<th>Repairing Date</th>
        			<th>Fix Cost</th>
        			<th></th>
        		</thead>
        		<tbody>
	        	@forelse($repairs->results as $repair)
	        	<tr data-repair-id="{{$repair->id}}">
	        		<td></td>
	        		<td>{{ Sentry::user($repair->user_id)->metadata['student_code'] }}</td>
	        		<td>{{ $repair->setup_place }}</td>
	        		<td>{{ $repair->date }}</td>
	        		<td>
	        		
	        		</td>
	        		<td>
		        		<?php $status = StatusRepair::where_repair_id($repair->id)->first(); ?>

	        			@if($status->title == 'fixed')
	        				<span class="label label-success">{{$status->title}}</span>
	        			@elseif($status->title == 'checking')
	        				<span class="label label-warning">{{$status->title}}</span>
	        			@else
	        				<span class="label">{{$status->title}}</span>
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
	
});
</script>
@endsection