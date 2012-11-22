{{ $form->open() }}
      {{ $form->text('metadata.student_code', 'Student Code') }}
      {{ $form->text('email', 'Email.req') }}
      {{ $form->password('password', 'Password.req') }}
      {{ $form->password('password_confirmation', 'Password Confirmation.req') }}
      {{ $form->text('metadata.first_name', 'First Name') }}
      {{ $form->text('metadata.last_name', 'Last Name') }}
      {{ $form->textarea('metadata.address', 'address') }}
      {{ $form->text('metadata.telephone', 'Phone No.') }}
      {{ $form->select('metadata.sex_type', 'Sex', array(0 => 'Male', 1 => 'Female')) }}
      {{ $form->select('group', 'Group', $group) }}

      {{ $form->submit_primary('Save') }}
{{ $form->close() }}