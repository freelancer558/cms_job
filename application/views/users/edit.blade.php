@layout('/shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('/shared/user_sidebar')
    </div>
    <div class="span9">
        <h1>Edit User</h1>
        <div class="well" style="text-align: center">
        {{ $form->open() }}
	      {{ $form->text('users_metadata.student_code', 'Student Code', $user['metadata']['student_code']) }}
	      @if(Request::route()->controller_action == 'edit')
	            {{ $form->text('email', 'Email', $user->email, array('disabled'=>true)) }}
	      @else
	            {{ $form->text('email', 'Email.req') }}
	      @endif
	      {{ $form->password('password', 'Password.req') }}
	      {{ $form->password('password_confirmation', 'Password Confirmation.req') }}
	      {{ $form->text('users_metadata.first_name', 'First Name', $user['metadata']['first_name']) }}
	      {{ $form->text('users_metadata.last_name', 'Last Name', $user['metadata']['last_name']) }}
	      {{ $form->textarea('users_metadata.address', 'address', $user['metadata']['address']) }}
	      {{ $form->text('users_metadata.telephone', 'Phone No.', $user['metadata']['telephone']) }}
	      {{ $form->select('users_metadata.sex_type', 'Sex', array(0 => 'Male', 1 => 'Female'), $user['metadata']['sex_type']) }}
	      {{ $form->select('group', 'Group', $group, (int)$user->groups()[0]['id']) }}

	      {{ $form->submit_primary('Save') }}
		{{ $form->close() }}
        </div>
    </div>
</div>
@endsection