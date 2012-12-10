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
                        <th>Student Code</th>
                        <th>Telephone</th>
                        <th>Requisitions Date</th>
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
                            <?php $user = Sentry::user((int)$requirement->user_id); ?>
                        	{{ $user->metadata['student_code'] }}
                        </td>
                        <td>
                            {{ $user->metadata['telephone'] }}
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