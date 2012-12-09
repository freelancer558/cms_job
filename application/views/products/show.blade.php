@layout('/shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('/shared/user_sidebar')
    </div>
    <div class="span9">
        <h1>User Details</h1>
        <div class="well" style="text-align: center">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <td>Data</td>
                        <td>{{ $product->data }}</td>
                    </tr>
                    <tr>
                        <td>Model</td>
                        <td>{{ $product->model }}</td>
                    </tr>
                    <tr>
                        <td>Disburse</td>
                        <td>{{ $product->disburse }}</td>
                    </tr>
                    <tr>
                        <td>Created at</td>
                        <td>{{ $product->created_at }}</td>
                    </tr>
                    @unless(empty($product->photos()->first()->id))
                    <tr>
                        <td>Photo</td>
                        <td>
                        <span class="span4">
                            <img src="<?php echo $product->photos()->first()->location; ?>" class="thumbnail">
                        </span>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <a href="{{URL::to('/products/'.$product->id.'/edit')}}" class="btn btn-primary"><i class="icon icon-white icon-edit"></i> Edit</a>
        </div>
    </div>
</div>
@endsection