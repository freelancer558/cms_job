@layout('/layouts/application')

@section('navigation')
	@parent
	<li class="<?php if(Request::route()->controller_action == 'repairing') echo 'active';?>">{{HTML::link('/users/repairing', 'Repairing')}}</li>
	<li><a href="/users/logout">Logout</a></li>
@endsection