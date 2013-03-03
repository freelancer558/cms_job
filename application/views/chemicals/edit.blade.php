@layout('/shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('/shared/user_sidebar')
    </div>
    <div class="span9">
        <h1>Edit Chemical</h1>
        <div class="well" style="text-align: center">
        {{ $form->open() }}

	      {{ $form->text('name', 'Name', $chemical->name) }}
	      {{ $form->text('sum', 'Total', $chemical->sum) }}
	      {{ $form->text('mfd', 'Date of manufacture', $chemical->mfd) }}
	      {{ $form->text('exp', 'Expire Date', $chemical->exp) }}
	      {{ $form->select('chemical_types', 'Chemical Type', $chemical_types, $chemical->chemicals_chemical_type()->first()->chemical_type_id, array('style'=>'width:220px;')) }}
          {{ $form->text('minimum', 'Minimum for notification') }}
	      {{ $form->submit_primary('Update') }}
		{{ $form->close() }}
	</script>
	@endsection
        </div>
    </div>
</div>
@endsection

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