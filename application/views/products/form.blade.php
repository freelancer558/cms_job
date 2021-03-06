{{ $form->open_for_files() }}

      {{ $form->text('name', 'Name') }}
      {{ $form->textarea('data', 'Data') }}
      {{ $form->text('serial_no', 'Serial No.') }}
      {{ $form->text('model', 'Model') }}
      {{ $form->text('disburse', 'Disburse') }}
      {{ $form->file('photo', "Photo") }}
      {{ $form->submit_primary('Save') }}
{{ $form->close() }}

@section("scripts")
<script type="text/javascript">
$(document).ready(function(){
  $('#field_disburse').datetimepicker({
    dateFormat: 'dd/mm/yy',
  });    
});
</script>
@endsection