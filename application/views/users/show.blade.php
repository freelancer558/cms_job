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
                        <td>Email</td>
                        <td>{{ $user->get('email') }}</td>
                    </tr>
                    <tr>
                        <td>Student Code</td>
                        <td>{{ $user->get('metadata.student_code') }}</td>
                    </tr>
                    <tr>
                        <td>First Name</td>
                        <td>{{ $user->get('metadata.first_name') }}</td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td>{{ $user->get('metadata.last_name') }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>{{ $user->get('metadata.address') }}</td>
                    </tr>
                    <tr>
                        <td>Sex</td>
                        <td>{{ $user->get('metadata.sex_type') ? "Male" : "Female" }}</td>
                    </tr>
                    <tr>
                        <td>Telephone</td>
                        <td>{{ $user->get('metadata.telephone') }}</td>
                    </tr>
                    <tr>
                        <td>Group</td>
                        <td>{{ $user->groups()[0]["name"] }}</td>
                    </tr>
                </tbody>
            </table>
            <a href="{{URL::to('/users/'.$user->id.'/edit')}}" class="btn btn-primary"><i class="icon icon-white icon-edit"></i> Edit</a>
        </div>
    </div>
</div>
@endsection