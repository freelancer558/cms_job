@layout('layouts/application')

@section('navigation')
@parent
<li><a href="about">About</a></li>
@endsection

@section('content')
<div class="hero-unit">
    <div class="row">
        <div class="span6 center">
            <h2>Repairing Form</h2>
            {{ $form->open() }}
                {{ $form->text('name', 'Name', $user['metadata']['first_name'].' '.$user['metadata']['last_name'], array('readonly'=>true)) }}
                {{ $form->text('date', 'Repair date') }}
                {{ $form->text('setup_place', 'Setup Place') }}
                <div class="control-group">
                    <label for="field_products" class="control-label">Product</label>
                    <div class="controls">
                        <select name="product" id="field_products">
                            <option selected="selected" value="">---Select product---</option>
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{ $product->name }}</option>                    
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label for="field_product_model" class="control-label">Model</label>
                    <div class="controls">
                        <input type="text" name="product_model" id="field_product_model" readonly="true">
                    </div>
                </div>
                <div class="control-group">
                    <label for="field_product_serial_no" class="control-label">Serial No.</label>
                    <div class="controls">
                        <input type="text" name="product_seriel_no" id="field_product_serial_no" readonly="true">
                    </div>
                </div>
                {{ $form->textarea('detail', 'Detail') }}

                <div class="control-group">
                    <div class="controls">
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
    $('#field_products').change(function(e){
        var product_id = $(this).val();
        if(product_id != 0){
            $.get('/products/'+product_id+'/detail', function(result){
                var $product = result.original;
                // console.log($product);
                $('#field_product_model').val($product.model);
                $('#field_product_serial_no').val($product.serial_no);    
            }, 'json');
        }else{
            $('#field_product_model').val('');
            $('#field_product_seriel_no').val('');
        }
    });
});
</script>
@endsection