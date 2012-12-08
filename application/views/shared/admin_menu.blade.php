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
        @if(Sentry::user()->in_group('student') || Sentry::user()->in_group('teacher'))
          <li class="<?php if(Request::route()->controller_action == 'repairing') echo 'active';?>">{{HTML::link('/users/repairing', 'Repairing')}}</li>
        @endif
        <li>{{HTML::link('/users/logout', 'Logout')}}</li>
      @endunless
    </ul>
  </div><!--/.nav-collapse -->
  @section('post_navigation')
    @if(Request::route()->controller == 'users')
      @include('shared.import_user')
    @elseif(Request::route()->controller == 'products')
      @include('shared.import_product')
    @elseif(Request::route()->controller == 'chemicals')
      @include('shared.import_chemical')
    @endif
  @yield_section
@endsection