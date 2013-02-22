@layout('shared/user_header')

@section('content')
<div class="row">
    <div class="span2">
    	<div class="do-not-print">
      	@include('shared/user_sidebar')
      </div>
    </div>
    <div class="span10">
    	<form class="navbar-form pull-right do-not-print" id="search_form" action="/repairs" method="GET">
            <div class="input-prepend input-append">
              <input class="span2" name="text_search" id="" type="text" placeholder="Search by --> ">
              <select class="span2" name="search_by" style="margin:0;">
                    <option value="student_code">Student code</option>
                    <option value="serial_no">Serial no</option>                    
                    <option value="chemical_status">Status</option>                    
                </select>
              <button class="btn" type="submit"><i class="icon icon-search"></i> Search</button>
            </div>
        </form>
        <h1>Product Repairs</h1>
        <div class="well" style="text-align: center">
        	<table class="table table-striped">
        		<thead>
        			<th></th>
        			<th>Student Code</th>
        			<th>Serial no</th>
              <th>Setup Place</th>
        			<th>Repairing Date</th>
        			<th class="do-not-print"></th>
        			<th>Status</th>
        			@if(Sentry::user()->in_group('superuser'))
        				<th>Fix Cost</th>
        			@endif
        		</thead>
        		<tbody>
        		<?php
        			if(!isset($_GET['text_search'])){
        				$product_repairs = $repairs->results;
        			}else{
        				$product_repairs = $repairs;
        			}
        		?>
	        	@forelse($product_repairs as $repair)
	        	<tr data-repair-id="{{$repair->id}}">
	        		<td>
	        			<?php 
	        				$fullname = Sentry::user((int)$repair->user_id)->metadata['first_name'] . ' ' . Sentry::user((int)$repair->user_id)->metadata['last_name']; 
	        				$product_serial = Product::find((int)$repair->product_id)->serial_no;
	        			?>
	        		</td>
	        		<td>{{ Sentry::user((int)$repair->user_id)->metadata['student_code'] }}</td>
	        		<td>{{ $product_serial }}</td>
	        		<td>{{ $repair->setup_place }}</td>
	        		<td>{{ $repair->date }}</td>
	        		<td class="do-not-print">
		        		<?php $status = StatusRepair::where_repair_id($repair->id)->first(); ?>
	        			{{ HTML::link('#', 'Detail', array('class'=>'btn btn-info no-margin', 'style'=>'vertical-align: top;', 'rel' => 'popover', 'data-placement' => 'top',  'data-content' => $repair->detail,  'data-original-title' => 'Details')) }}
	        			{{ HTML::link('/repairs/'.$repair->product_id.'/tracking', 'Tracking', array('class'=>'btn', 'style'=>'vertical-align: top;')) }}
	        			@if($status->title == 'pending')
	        				{{ HTML::link('/repairs/'.$repair->id.'/delete', 'Delete', array('class'=>'btn btn-danger no-margin', 'style'=>'vertical-align: top;')) }}
	        			@endif
	        			@if($status->title == 'fixed')
	        				{{ HTML::link('#', 'Print', array('class'=>'btn no-margin print-btn', 'style'=>'vertical-align: top;', 'data-name' => $fullname, 'data-date' => $repair->date, 'data-product-serial' => $product_serial, 'data-place' => $repair->setup_place, 'data-detail' => $repair->detail)) }}				
	        			@endif
	        		</td>
	        		<td>
	        			@if(Sentry::user()->in_group('superuser') && $repair->fix_cost <= 0)
		        			{{ Form::select('status', $repair_status, array_search($status->title, $repair_status), array('width'=>'50', 'class'=>'do-not-print')) }}
		        		@elseif(Sentry::user()->in_group('teacher') && $repair->fix_cost <= 0)
		        			{{ Form::select('status', $repair_status, array_search($status->title, $repair_status), array('width'=>'50', 'class'=>'do-not-print')) }}
		        		@else
		        			@if($status->title == 'fixed')
		        				<span class="label label-success">{{$status->title}}</span>
		        			@elseif($status->title == 'checking' || $status->title == 'accept')
		        				<span class="label label-warning">{{$status->title}}</span>
		        			@elseif($status->title == 'reject')
		        				<span class="label label-important">{{$status->title}}</span>
		        			@else
		        				<span class="label">{{$status->title}}</span>
		        			@endif
	        			@endif
	        		</td>
	        		@if(Sentry::user()->in_group('superuser'))
	        		<td>
	        			<input type="text" name="fix_cost" class="fix_cost" style="width:50px;vertical-align:top;" readonly="true" value="{{$repair->fix_cost}}">
	        			<input type="text" name="invoice_id" class="invoice_id" style="width:60px;vertical-align:top;" readonly="true" value="{{$repair->invoice_id}}" placeholder="invoice id">
	        			@if($repair->fix_cost <= 0)
	        				<a href="#" class="btn add_fix_cost">Add</a>
	        			@endif
	        		</td>
	        		@endif
	        	</tr>
	        	@empty
	        	<tr>
	        		<td colspan="8">No product repair.</td>
	        	</tr>
	        	@endforelse
        		</tbody>
        	</table>
        	@if(!isset($_GET['text_search']))
        		{{ $repairs->links() }}
        	@endif
        </div>
    </div>
</div>
<div class="row print">
	<div class="span10 pagination-centered"><strong>ใบแจ้งซ่อมอุปกรณ์และเครื่องมือวิทยาศาสตร์ ภาควิชาจุลชีววิทยา</strong></div>
	<div class="span10 pagination-centered"><strong>คณะวิทยาศาสตร์ มหาวิทยาลัยขอนแก่น</strong></div>
	<br><br>
	<div class="span10 pagination-right"><strong>ผู้แจ้ง (นาย/นางสาว/อาจารย์) ......................................... วันที่แจ้งซ่อม (ว/ด/ป)...................................</strong></div>
	<div class="span12"><strongชื่ออุปกรณ์/เครื่องมือวิทยาศาสตร์.................................................................... Model ................................></strong></div>
	<div class="span12"><strong>เลขที่ครุภัณฑ์ ........................................... สถานที่ติดตั้งอุปกรณ์/เครื่องมือวิทยาศาสตร์ ......................</strong></div>
	<div class="span12"><strong>ลักษณะอาการที่เสียหาย .......................................................................................................................</strong></div>
	<div class="span12"><strong>..............................................................................................................................................................</strong></div>
	<div class="span12"><strong>..............................................................................................................................................................</strong></div>
	<div class="span12"><strong>..............................................................................................................................................................</strong></div>
	<br><br>
	<div class="span12 pagination-right"><strong>ทราบ &nbsp;&nbsp;&nbsp;&#9633;&nbsp;&nbsp;&nbsp;  แจ้งเวียนอาจารย์ในภาควิชา เพื่อดำเนินการซ่อมต่อไป</strong></div>
	<div class="span4 pagination-right"><strong>แจ้งบริษัทเพื่อดำเนินการซ่อม &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></div>
	<br>
	<div class="span4 pagination-right"><strong>……………………………………………………</strong></div>
	<div class="span6 pagination-right"><strong>(ผศ.ดร.โสภณ บุญลือ/นางนุจนา สีสวยหูต)&nbsp;&nbsp;</strong></div>

	<span class="print-name"></span>
	<span class="print-date"></span>
	<span class="print-product-serial"></span>
	<span class="print-place"></span>
	<span class="print-detail"></span>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

	$('.print-btn').click(function(){
		var name 		= $(this).data('name');
		var pdate 	= $(this).data('date');
		var pserial = $(this).data('product-serial');
		var place 	= $(this).data('place');
		var pdetail = $(this).data('detail');

		$('.print .print-name').text(name);
		$('.print .print-date').text(pdate);
		$('.print .print-product-serial').text(pserial);
		$('.print .print-place').text(place);
		$('.print .print-detail').text(pdetail);

		$('.print').css('display', 'block');
		window.print();
		$('.print').css('display', 'none');
	});

	$('.btn.btn-info').popover();
	$('select :selected').each(function(){
		if($(this).text() == 'fixed') $(this).closest('tr').find('.fix_cost').attr('readonly', false);
	});
	$('select[name=status]').change(function(){
		var status = $(':selected', this).text();
		var repair_id= $(this).closest('tr').attr('data-repair-id');
		if(status == 'fixed'){
			$(this).closest('tr').find('.fix_cost').attr('readonly', false);	
			$(this).closest('tr').find('.invoice_id').attr('readonly', false);	
		}else{
			$(this).closest('tr').find('.fix_cost').attr('readonly', true);	
			$(this).closest('tr').find('.invoice_id').attr('readonly', true);	
		}
		if(status != "fixed"){
			$.post('/repairs', {title: status, repair_id: repair_id, fix_cost: 0, invoice_id: ''}, function(result){
				alert(result);
			});
		}
	});
	$('a[data-confirm]').bind('click', function(e){
        if(confirm($(this).attr('data-confirm'))) return true;
        e.preventDefault();
    });
    $('a.add_fix_cost').click(function(e){
    	e.preventDefault();
    	var fix_cost = $(this).closest('tr').find('.fix_cost').val();
    	var invoice_id = $(this).closest('tr').find('.invoice_id').val();
    	var status = $(this).closest('tr').find('select :selected').text();
    	var repair_id= $(this).closest('tr').attr('data-repair-id');
    	if(status == "fixed" && invoice_id != ""){
	    	$.post('/repairs', {title: status, repair_id: repair_id, fix_cost: fix_cost, invoice_id: invoice_id}, function(result){
				alert(result);
			});
    	}else{
    		alert('Cannot add because status is not fixed or invoice id is empty');
    	}
    });
    
});
</script>
@endsection