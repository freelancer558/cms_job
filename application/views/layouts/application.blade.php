<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Laravel: A Framework For Web Artisans</title>
		<meta name="viewport" content="width=device-width">
    <?php Asset::add('application', 'css/application.css'); ?>
    <?php Asset::add('jqueryui', 'css/flick/jquery-ui.css') ?>
    {{ Asset::container('bootstrapper')->styles() }}
    {{ Asset::styles() }}
		@yield('styles')

    <?php Asset::add('jqueryui', 'js/jquery-ui-min.js') ?>
    <?php Asset::add('datetimerpicker', 'js/datetimepicker.js') ?>
    {{ Asset::container('bootstrapper')->scripts() }}
		{{ Asset::scripts() }}
		@yield('scripts')
  </head>
  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="home">SCBL</a>
          <div class="nav-collapse">
              <ul class="nav">
                  @section('navigation')
                  @unless(Sentry::check())
                    <li class="<?php if(Request::route()->controller_action == 'index') echo 'active';?>"><a href="/home">Home</a></li>
                    <li class="<?php if(Request::route()->controller_action == 'login') echo 'active';?>">{{HTML::link('/users/login', 'Login')}}</li>
                  @endunless
                  @yield_section
              </ul>
          </div><!--/.nav-collapse -->
          @section('post_navigation')
          @if(isset($user) && Sentry::user()->in_group('superuser'))
            @include('shared.import_user')
          @elseif(Request::route()->controller == 'products' && Sentry::user()->in_group('superuser'))
            @include('shared.import_product')
          @endif
          @yield_section
        </div>
      </div>
    </div>

    <div class="container">
      @include('shared.status')
      @yield('content')
      <hr>
      <footer>
      	<p>&copy; Scientific equipment and chemical management system for Biological laboratory.</p>    
      </footer>
    </div> <!-- /container -->
    
    @section('form_modals')
    @if(Sentry::check() && Request::route()->controller == 'products')
      @include('shared.upload_modal')
    @endif
    @yield_section
  </body>
</html>
