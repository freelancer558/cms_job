@layout('/shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('/shared/user_sidebar')
    </div>
    <div class="span9">
        <h1>{{Request::route()->controller}}</h1>
        <div class="well" style="text-align: center">
        	<table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Total</th>
                        <th>Chemical</th>
                        <th>User</th>
                        <th>Requisitions Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($requisitions->results as $requisition)
                <tr data-status-id="{{$requisition->status_requirement->id}}">
                	<td>{{$requisition->id}}</td>
                    <td>{{$requisition->total}}</td>
                    <td>
                    	<?php $chem = Chemical::find($requisition->chemical_id); ?>
                    	{{ $chem->name }}
                    </td>
                    <td>
                    	<?php $user = Sentry::user($requisition->user_id); ?>
                    	{{ $user->metadata['first_name'] }} {{ $user->metadata['last_name'] }}
                    </td>
                    <td>{{$requisition->created_at}}</td>
                    <td>
                    	@if(Sentry::user()->in_group('teacher'))
                    		<?php $status = StatusRequirement::where_requirement_id($requisition->status_requirement->requirement_id)->first(); ?>
	                    	{{ Form::select('status', $status_requirements, array_search($status->name, $status_requirements)) }}
	                    	<a href="/requirements/{{$requisition->id}}/delete" class="btn btn-danger">Delete</a>
                    	@endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6">No Requisitions.</td>
                </tr>
                @endforelse
                </tbody>
            </table>
            {{ $requisitions->links() }}
        </div>
    </div>
</div>
@endsection

@section("scripts")
<script type="text/javascript">
$(document).ready(function(){
	$('select[name=status]').change(function(){
		var status = $(':selected', this).text();
		var status_id= $(this).closest('tr').attr('data-status-id');
		$.post('/requirements/update_status', {title: status, id: status_id}, function(result){
			alert(result);
		})
	});
    $('a[data-confirm]').bind('click', function(e){
        if(confirm($(this).attr('data-confirm'))) return true;
        e.preventDefault();
    });
});
</script>
@endsection