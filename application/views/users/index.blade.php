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
        			<th>Sex</th>
        			<th>Telephone</th>
        		</thead>
        		<tbody>
	        	@forelse($users as $user)
	        	<tr>
	        		<td>{{$user->email}}</td>
	        		@if($user->users_metadata)
		        		<td>{{$user->users_metadata->student_code}}</td>
		        		<td>{{$user->users_metadata->first_name}}</td>
		        		<td>{{$user->users_metadata->last_name}}</td>
		        		<td>{{$user->users_group->sex_type ? "F" : "M"}}</td>
		        		<td>{{$user->users_metadata->telephone}}</td>
		        	@else
		        		<td colspan="5"></td>
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