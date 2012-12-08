<div class="well sidebar-nav">
  <h4>Menu</h4>
  <ul class="nav nav-list">
    <!-- <li class="nav-header"><a href="#">Chemicals</a></li> -->
    @if(Sentry::user()->in_group('superuser'))
    	<li class="nav-header">{{HTML::link('/chemicals', 'Chemicals')}}</li>
	    <li class="nav-header">{{HTML::link('/products', 'Products')}}</li>
	    <li class="nav-header">{{HTML::link('/repairs', 'Repairs')}}</li>
	    <li class="nav-header">{{HTML::link('/users', 'Users')}}</li>
	@elseif(Sentry::user()->in_group('teacher'))
		<li class="nav-header">{{ HTML::link('/users/'.Sentry::user()->id, 'Account Informations') }}</li>
		<li class="nav-header">{{HTML::link('/requirements', 'Requisition')}}</li>
		<li class="nav-header">{{HTML::link('/repairs', 'Repairs')}}</li>
	@else
		<li class="nav-header">{{ HTML::link('/users/'.Sentry::user()->id, 'Account Informations') }}</li>
		<li class="nav-header">{{HTML::link('/requirements', 'Requisition')}}</li>
		<li class="nav-header">{{HTML::link('/repairs', 'Repairs')}}</li>
    @endif
  </ul>
</div>