@layout('/shared/user_header')

@section('content')
<div class="row">
    <div class="span3">
        @include('/shared/user_sidebar')
    </div>
    <div class="span9">
        <h1>Edit User</h1>
        <div class="well" style="text-align: center">
        @include('users.form')
        </div>
    </div>
</div>
@endsection