@layout('/shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('/shared/user_sidebar')
    </div>
    <div class="span9">
        <form class="navbar-form pull-right" id="chemical_search_form" action="/chemicals" method="GET">
            <div class="input-prepend input-append">
              <input class="span2" name="text_search" id="search_product_serial_no" type="text" placeholder="Search by --> ">
              <select class="span2" name="search_by" style="margin:0;">
                    <option value="requesting_chemical">ขื่อผู้ส่งคำร้อง</option>
                    <option value="chemical_name">ชื่อสารเคมี</option>
                </select>
              <button class="btn" type="submit"><i class="icon icon-search"></i> Search</button>
            </div>
        </form>
        <h1>Chemicals</h1>
        <div class="well" style="text-align: center">
        	<table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Total</th>
                        <th>Type</th>
                        <th>Date of manufacture</th>
                        <th>Expire Date</th>
                        <th>Add Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($chemicals->results as $chemical)
                <tr>
                    <td></td>
                    <td>{{$chemical->name}}</td>
                    <td>{{$chemical->sum}}</td>
                    <?php $chemical_type = ChemicalType::find($chemical->chemicals_chemical_type()->first()->chemical_type_id); ?>
                    <td>{{$chemical_type->title}}</td>
                    <td>{{$chemical->exp}}</td>
                    <td>{{$chemical->mfd}}</td>
                    <td>{{$chemical->created_at}}</td>
                    <td>
                    @if($user->in_group('superuser'))                        
                        {{ HTML::link('chemicals/'.$chemical->id.'/edit', 'Edit ') }} |
                        {{ HTML::link('chemicals/'.$chemical->id.'/delete', 'Delete', array('data-confirm'=>'Do you want to delete?'))}}
                    @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">No Chemical.</td>
                </tr>
                @endforelse
                </tbody>
            </table>
            {{ $chemicals->links() }}
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