@section('user_navigation')
  <div class="nav-collapse">
    <ul class="nav">
      @unless(Sentry::check())
        <li class="<?php if(Request::route()->controller_action == 'index') echo 'active';?>"><a href="/home">Home</a></li>
        <li class="<?php if(Request::route()->controller_action == 'login') echo 'active';?>">{{HTML::link('/users/login', 'Login')}}</li>
      @else
        <li class="<?php if(Request::route()->controller == 'dashboard') echo 'active';?>">
          {{ HTML::link('/dashboard', 'Dashboard') }}
        </li>          
        <li class="<?php if(Request::route()->controller_action == 'repairing') echo 'active';?>">{{HTML::link('/users/repairing', 'Repairing')}}</li>
        <li>{{HTML::link('/users/logout', 'Logout')}}</li>
      @endunless
    </ul>
  </div><!--/.nav-collapse -->
@endsection