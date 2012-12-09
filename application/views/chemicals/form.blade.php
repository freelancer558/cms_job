{{ $form->open() }}

      {{ $form->text('name', 'Name', ' ') }}
      {{ $form->text('sum', 'Total') }}
      {{ $form->text('mfd', 'Date of manufacture') }}
      {{ $form->text('exp', 'Expire Date') }}
      {{ $form->select('chemical_types', 'Chemical Type', $chemical_types, false, array('style'=>'width:220px;')) }}
      <!-- {{ $form->file('photo', "Photo") }} -->
      {{ $form->submit_primary('Save') }}
{{ $form->close() }}

@section("scripts")
<script type="text/javascript">
$(document).ready(function(){
    $('#field_mfd').datetimepicker({
      dateFormat: 'dd/mm/yy',
    });
    $('#field_exp').datetimepicker({
      dateFormat: 'dd/mm/yy',
    });
});
</script>
@endsection