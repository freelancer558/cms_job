{{ $form->open() }}

      {{ $form->text('name', 'Name', ' ') }}
      {{ $form->text('sum', 'Total') }}
      {{ $form->select('chemical_types', 'Chemical Type', $chemical_types, false, array('style'=>'width:220px;')) }}
      {{ $form->text('mfd', 'Date of manufacture') }}
      {{ $form->text('exp', 'Expire Date') }}
      <!-- {{ $form->file('photo', "Photo") }} -->
      {{ $form->submit_primary('Save') }}
{{ $form->close() }}

@section("scripts")
<script type="text/javascript">
$(document).ready(function(){
    $('#field_mfd').datetimepicker({
      dateFormat: 'yy-mm-dd',
    });
    $('#field_exp').datetimepicker({
      dateFormat: 'yy-mm-dd',
    });
});
</script>
@endsection