@layout('shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('shared/user_sidebar')
    </div>
    <div class="span9">
        <h3>Chemical order by date expire</h3>
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
                <?php $index = 1; ?>
                @forelse($chemicals->results as $chemical)
                <tr>
                  <?php if($chemical->show){ ?>
                    <td></td>
                    <td>{{$chemical->name}}</td>
                    <td>{{$chemical->sum}}</td>
                    <?php $cm_type = ChemicalsChemicalType::find($chemical->id); ?>
                    <?php $chemical_type = ChemicalType::find($cm_type->chemical_type_id); ?>
                    <td>{{$chemical_type->title}}</td>
                    <td>@if($index<=5)<span class="label label-important">{{$chemical->exp}}</span>@endif</td>
                    <td>{{$chemical->mfd}}</td>
                    <td>{{$chemical->created_at}}</td>
                    <td>
                    @if($user->in_group('superuser'))                        
                      {{ HTML::link('chemicals/'.$chemical->id.'/hide', 'Delete', array('data-confirm'=>'Do you want to delete?'))}}
                    @endif
                    </td>
                  <?php } ?>
                </tr>
                <?php $index++ ?>
                @empty
                <tr>
                    <td colspan="7">No Chemical.</td>
                </tr>
                @endforelse
                </tbody>
            </table>
            {{ $chemicals->links() }}
        </div>

        <h3>Chemical is low</h3>
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
                <?php $index = 1 ?>
                @forelse($chemicals_is_low->results as $chemical)
                <tr>
                    <td></td>
                    <td>{{$chemical->name}}</td>
                    <td>
                      @if($index<=5)
                        <span class="label label-important">{{$chemical->sum}}</span>
                      @else
                        {{$chemical->sum}}
                      @endif
                    </td>
                    <?php $cm_type = ChemicalsChemicalType::find($chemical->id); ?>
                    <?php $chemical_type = ChemicalType::find($cm_type->chemical_type_id); ?>
                    <td>{{$chemical_type->title}}</td>
                    <td>{{$chemical->exp}}</td>
                    <td>{{$chemical->mfd}}</td>
                    <td>{{$chemical->created_at}}</td>
                    <td>
                    @if($user->in_group('superuser'))                        
                      {{ HTML::link('chemicals/'.$chemical->id.'/hide', 'Delete', array('data-confirm'=>'Do you want to delete?'))}}
                    @endif
                    </td>
                </tr>
                <?php $index++; ?>
                @empty
                <tr>
                    <td colspan="7">No Chemical.</td>
                </tr>7
                @endforelse
                </tbody>
            </table>
            {{ $chemicals_is_low->links() }}
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