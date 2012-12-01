@layout('/layouts/application')

@section('navigation')
	@parent
	<li class="<?php if(Request::route()->controller == 'dashboard') echo 'active';?>">
		{{ HTML::link('/dashboard', 'Dashboard') }}
	</li>
	@if(Sentry::user()->in_group('student'))
		<li class="<?php if(Request::route()->controller_action == 'repairing') echo 'active';?>">{{HTML::link('/users/repairing', 'Repairing')}}</li>
	@endif
	<li>{{HTML::link('/users/logout', 'Logout')}}</li>
@endsection