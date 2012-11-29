@layout('/shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('/shared/user_sidebar')
    </div>
    <div class="span9">
        <h1>Products</h1>
        <div class="well" style="text-align: center">
        	<table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Model</th>
                        <th>Data</th>
                        <th>Total</th>
                        <th>Disburse</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                <tr>
                    <td></td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->model}}</td>
                    <td>{{$product->data}}</td>
                    <td>{{$product->sum}}</td>
                    <td>{{$product->disburse}}</td>
                    <td>{{$product->created_at}}</td>
                    <td>
                        {{ HTML::link('products/'.$product->id, 'Info ') }}|
                        {{ $has_access ? HTML::link('products/'.$product->id.'/delete', 'Delete', array('data-confirm'=>'Do you want to delete?')) : "" }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">No Product.</td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<script type="text/javascript">
$(document).ready(function(){
    $('a[data-confirm]').bind('click', function(e){
        if(confirm($(this).attr('data-confirm'))) return true;
        e.preventDefault();
    });
});
</script>
@endsection