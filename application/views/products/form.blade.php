{{ $form->open() }}

      {{ $form->text('name', 'Name') }}
      {{ $form->text('sum', 'Total') }}
      {{ $form->textarea('data', 'Data') }}
      {{ $form->text('model', 'Model') }}
      {{ $form->text('disburse', 'Disburse') }}
      <!-- {{ $form->file('picture', "Picture") }} -->
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