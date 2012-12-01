@layout('layouts/application')

@section('navigation')
@parent
<li><a href="about">About</a></li>
@endsection

@section('content')
    <div class="row">
        <div class="span3 center">            
            <form class="well" method="POST" action="/users/authenticate">
                <label for="email">Email</label>
                <input type="email" placeholder="Your Email Address" name="email" id="email" />
                <label for="password">Password</label>
                <input type="password" placeholder="Your Password" name="password" id="password" />
                <label class="checkbox" for="new_user">
                    <input type="checkbox" name="new_user" id="new_user"> I am a new user
                </label>
                <br />
                <button type="submit" class="btn btn-success">Login or Register</button>
            </form>
        </div>
        
        <div class="span4">
            <!-- <img src="img/phones.png" alt="Instapics!" /> -->
        </div>
    </div>
    
@endsection