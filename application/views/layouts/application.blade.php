<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Laravel: A Framework For Web Artisans</title>
		<meta name="viewport" content="width=device-width">
    <?php Asset::add('application', 'css/application.css'); ?>
    <?php Asset::add('jqueryui', 'css/flick/jquery-ui.css') ?>
    
    {{ HTML::style('css/print.css', array('media' => 'print')); }}
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
    <div class="navbar navbar-fixed-top do-not-print">
      <div class="navbar-inner">
        <div class="container">
          {{ HTML::link('/home', 'SCBL', array('class'=>'brand')) }}
          @section('user_navigation')
            @if(Sentry::user()->in_group('superuser'))
              @include('shared.admin_menu')
            @elseif(Sentry::user()->in_group('teacher'))
              <!-- @include('shared.staff_menu') -->
              @include('shared.user_menu')
            @else
              @include('shared.user_menu')
            @endif
          @yield_section
        </div>
      </div>
    </div>
    <div class="container">
      @include('shared.status')
      @yield('content')
      <hr>
      <footer class="do-not-print">
      	<p>&copy; Scientific equipment and chemical management system for Biological laboratory.</p>    
      </footer>
    </div> <!-- /container -->
    
    @section('form_modals')
      @if(Sentry::check() && Request::route()->controller == 'products')
        @include('shared.upload_modal')
      @elseif(Sentry::check() && Request::route()->controller == 'chemicals')
        @include('shared.addtype_modal')
      @elseif(Sentry::check() && !Sentry::user()->in_group('superuser') && Request::route()->controller == 'requirements')
        @include('shared.add_requisition_modal')
      @endif
    @yield_section
  </body>
</html>
