@layout('shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('shared/user_sidebar')
    </div>
    <div class="span8">
        <div class="well center">
            <h2>Repairing Form</h2>
            {{ $form->open() }}
                {{ $form->text('name', 'Name', $user['metadata']['first_name'].' '.$user['metadata']['last_name'], array('readonly'=>true)) }}
                {{ $form->text('metadata.student_code', 'Student Code', $user['metadata']['student_code'].' '.$user['metadata']['student_code'], array('readonly'=>true)) }}
                {{ $form->text('date', 'Repair date') }}
                {{ $form->text('setup_place', 'Setup Place') }}
                <div class="control-group">
                    <label for="field_product_serial_no" class="control-label">Serial No.</label>
                    <div class="controls">
                        <input type="text" name="product_seriel_no" id="field_product_serial_no">
                    </div>
                </div>
                <div class="control-group">
                    <label for="field_products" class="control-label">Product</label>
                    <div class="controls">
                        <input type="text" name="product_name" id="field_product_name" readonly="true">
                    </div>
                </div>
                <div class="control-group">
                    <label for="field_product_model" class="control-label">Model</label>
                    <div class="controls">
                        <input type="text" name="product_model" id="field_product_model" readonly="true">
                    </div>
                </div>
                {{ $form->textarea('detail', 'Detail') }}

                <div class="control-group">
                    <div class="controls">
                        <input type="hidden" name="field_product_id" id="field_product_id">
                        {{ $form->submit_primary('Submit') }}
                    </div>
                </div>
            {{ $form->close() }}
        </div>
    </div>
</div>
@endsection

@section("scripts")
<script type="text/javascript">
$(document).ready(function(){
    $('#field_date').datetimepicker({
      dateFormat: 'dd/mm/yy',
    });
    
    $('#field_product_serial_no').blur(function(){
        var product_serial_no = $(this).val();
        if(product_serial_no != ""){
            $.get('/products/'+product_serial_no+'/detail', function(result){
                var $product = result.original;
                // console.log($product);
                $('#field_product_model').val($product.model);
                $('#field_product_name').val($product.name);    
                $('#field_product_id').val($product.id);
            }, 'json');
        }else{
            $('#field_product_model').val('');
            $('#field_product_name').val('');
            $('#field_product_id').val('');
        }
    });
    
    $.get('/products/search_by_serial', function(result){
        $( "#field_product_serial_no" ).autocomplete({
          source: result
        });
    }, 'json');
});
</script>
@endsection