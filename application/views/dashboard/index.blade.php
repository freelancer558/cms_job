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
                        <th>Date of manufacture</th>
                        <th>Expire Date</th>
                        <th>Add Date</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($chemicals->results as $chemical)
                <tr>
                    <td></td>
                    <td>{{$chemical->name}}</td>
                    <td>{{$chemical->sum}}</td>
                    <td>{{$chemical->exp}}</td>
                    <td>{{$chemical->mfd}}</td>
                    <td>{{$chemical->created_at}}</td>
                    <?php $chemical_type = ChemicalType::find($chemical->chemicals_chemical_type()->first()->chemical_type_id); ?>
                    <td>{{$chemical_type->title}}</td>
                    <td>
                    <!-- @if($user->in_group('superuser'))                        
                        {{ HTML::link('chemicals/'.$chemical->id.'/edit', 'Edit ') }} |
                        {{ HTML::link('chemicals/'.$chemical->id.'/delete', 'Delete', array('data-confirm'=>'Do you want to delete?'))}}
                    @endif -->
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

        <h3>Chemical is low</h3>
        <div class="well" style="text-align: center">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Total</th>
                        <th>Date of manufacture</th>
                        <th>Expire Date</th>
                        <th>Add Date</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($chemicals_is_low->results as $chemical)
                <tr>
                    <td></td>
                    <td>{{$chemical->name}}</td>
                    <td>{{$chemical->sum}}</td>
                    <td>{{$chemical->exp}}</td>
                    <td>{{$chemical->mfd}}</td>
                    <td>{{$chemical->created_at}}</td>
                    <?php $chemical_type = ChemicalType::find($chemical->chemicals_chemical_type()->first()->chemical_type_id); ?>
                    <td>{{$chemical_type->title}}</td>
                    <td>
                    <!-- @if($user->in_group('superuser'))                        
                        {{ HTML::link('chemicals/'.$chemical->id.'/edit', 'Edit ') }} |
                        {{ HTML::link('chemicals/'.$chemical->id.'/delete', 'Delete', array('data-confirm'=>'Do you want to delete?'))}}
                    @endif -->
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">No Chemical.</td>
                </tr>
                @endforelse
                </tbody>
            </table>
            {{ $chemicals_is_low->links() }}
        </div>
    </div>
</div>
@endsection