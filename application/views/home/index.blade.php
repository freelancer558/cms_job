@layout('layouts/application')

@section('navigation')
@parent
<li><a href="about">About</a></li>
@endsection

@section('content')
<div class="hero-unit">
    <div class="row">
        <div class="span6 center">
            <h2>รายงานความก้าวหน้าโครงงาน ครั้งที่ 1</h2>
            <p>ระบบจัดการอุปกรณ์และสารเคมีของปฏิบัติการทางวิทยาศาสตร์ชีวภาพ</p>
            <p>Scientific equipment and chemical management system for Biological laboratory.</p>
            <p>523020666-2 นายสุทธิเกียรติ อึ้งตรงจิตร</p>
            <p>523020676-9 นายอภิชาต     สะตะ</p>
        </div>
        
        <div class="span4">
            <!-- <img src="img/phones.png" alt="Instapics!" /> -->
        </div>
    </div>
    
    
</div>
@endsection