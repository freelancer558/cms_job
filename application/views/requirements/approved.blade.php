@layout('/shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('/shared/user_sidebar')
    </div>
    <div class="span9">
        <h1>{{Request::route()->controller}}</h1>
        <div class="well" style="text-align: center">
        	<table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Total</th>
                        <th>Chemical</th>
                        <th>User</th>
                        <th>Requisitions Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($requisitions->results as $requisition => $requirement)
                    <tr>
                    	<td>{{$requirement->id}}</td>
                        <td>{{$requirement->requirement->total}}</td>
                        <td>
                        	<?php $chem = Chemical::find($requirement->requirement->chemical_id); ?>
                        	{{ $chem->name }}
                        </td>
                        <td>                        
                            <?php $user = Sentry::user($requirement->requirement->user_id); ?>
                        	{{ $user->metadata['first_name'] }} {{ $user->metadata['last_name'] }}
                        </td>
                        <td>{{$requirement->requirement->created_at}}</td>
                        <td>                    		
	                    	<span class="label label-success">
                                {{$requirement->name}}
                            </span>
                        </td>

                    </tr>
                @empty
                <tr>
                    <td colspan="6">No Requisitions.</td>
                </tr>
                @endforelse
                </tbody>
            </table>
            {{ $requisitions->links() }}
        </div>
    </div>
</div>
@endsection