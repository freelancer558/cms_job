@layout('layouts/application')

@section('navigation')
@parent
<li><a href="about">About</a></li>
@endsection

@section('content')
<div class="hero-unit">
    <div class="row">
        <div class="span6">
            <h2>รายงานความก้าวหน้าโครงงาน ครั้งที่ 1</h2>
            <p>ระบบจัดการอุปกรณ์และสารเคมีของปฏิบัติการทางวิทยาศาสตร์ชีวภาพ</p>
            <p>Scientific equipment and chemical management system for Biological laboratory.</p>
            <p>523020666-2 นายสุทธิเกียรติ อึ้งตรงจิตร</p>
            <p>523020676-9 นายอภิชาต     สะตะ</p>
            
            <form class="well" method="POST" action="users/authenticate">
                <label for="email">Email</label>
                <input type="email" placeholder="Your Email Address" name="email" id="email" />
                <label for="password">Password</label>
                <input type="password" placeholder="Your Password" name="password" id="password" />
                <label class="checkbox" for="new_user">
                    <input type="checkbox" name="new_user" id="new_user" checked="checked"> I am a new user
                </label>
                <br />
                <button type="submit" class="btn btn-success">Login or Register</button>
            </form>
        </div>
        
        <div class="span4">
            <img src="img/phones.png" alt="Instapics!" />
        </div>
    </div>
    
    
</div>
@endsection