@layout('/shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('/shared/user_sidebar')
    </div>
    <div class="span9">
        <h1>Users</h1>
        <div class="well" style="text-align: center">
        	<table class="table table-striped">
        		<thead>
        			<th>Email</th>
        			<th>Student Code</th>
        			<th>First Name</th>
        			<th>Last Name</th>
                    <th>Telephone</th>
        			<th></th>
        		</thead>
        		<tbody>
	        	@forelse($users as $user)
	        	<tr>
	        		<td>{{$user->email}}</td>
	        		@if($user->users_metadata)
		        		<td>{{$user->users_metadata->student_code}}</td>
		        		<td>{{$user->users_metadata->first_name}}</td>
		        		<td>{{$user->users_metadata->last_name}}</td>
		        		<td>{{$user->users_metadata->telephone}}</td>
                        <td>
                            {{ HTML::link('users/'.$user->id, 'Info ') }}|
                            {{ $has_access ? HTML::link('users/'.$user->id.'/delete', 'Delete', array('data-confirm'=>'Do you want to delete?')) : "" }}
                        </td>
                    @else
                        <td colspan="4"></td>
                        <td>
                            {{ HTML::link('users/'.$user->id, 'Info ') }} | 
                            {{ HTML::link('users/'.$user->id.'/delete', 'Delete', array('data-confirm'=>'Do you want to delete?')) }}
                        </td>
		        	@endif
	        	</tr>
	        	@empty
	        	<tr>
	        		<td colspan="6">No user</td>
	        	</tr>
	        	@endforelse
        		</tbody>
        	</table>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<script type="text/javascript">
$(document).ready(function(){
    $('a[data-confirm]').bind('click', function(e){
        if(confirm($(this).attr('data-confirm'))) return true;
        e.preventDefault();
    });
});
</script>
@endsection