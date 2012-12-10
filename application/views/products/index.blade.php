@layout('/shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('/shared/user_sidebar')
    </div>
    <div class="span9">
        <form class="navbar-form pull-right" action="/products" method="GET">
            <div class="input-append">
              <input class="span2" name="serial_no" id="search_product_serial_no" type="text" placeholder="Search by Serial number">
              <button class="btn" type="submit"><i class="icon icon-search"></i> Search</button>
            </div>
        </form>
        <h1>Products</h1>
        <div class="well" style="text-align: center">
        	<table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Serial no</th>
                        <th>Model</th>
                        <th>Disburse</th>
                        <th>Created at</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($products->results as $product)
                <tr>
                    <td></td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->serial_no}}</td>
                    <td>{{$product->model}}</td>
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
            {{ $products->links() }}
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
    $.get('/products/search_by_serial', function(result){
        $( "#search_product_serial_no" ).autocomplete({
          source: result
        });
    }, 'json');
});
</script>
@endsection