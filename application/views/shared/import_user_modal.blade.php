<div class="modal hide" id="import_user_modal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Import New User</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('photo/upload') }}" id="upload_modal_form" enctype="multipart/form-data" class="no-margin">
			<span class="span3 pull-right no-margin no-padding">
				<label for="student_code">Email</label>
				<input type="text" placeholder="Email" name="email" id="email">	

				<label for="student_code">Password</label>
				<input type="text" name="password" id="password">	

				<label for="student_code">Password Confirmation</label>
				<input type="text" name="password_confirmation" id="password_confirmation">	

				<label for="photo">Photo</label>
	    	<input type="file" placeholder="Choose a photo to upload" name="photo" id="photo" />
			</span>

			<span class="span2 no-padding no-margin">
				<label for="student_code">Student Code</label>
				<input type="text" placeholder="student code" name="student_code" id="student_code">	

				<label for="student_code">First Name</label>
				<input type="text" placeholder="First Name" name="first_name" id="first_name">	

				<label for="student_code">Last Name</label>
				<input type="text" placeholder="Last Name" name="last_name" id="last_name">	
			</span>			
			<div class="clearfix"></div>
			<label for="student_code">Address</label>
			<textarea placeholder="You address" name="address" id="address" class="span5"></textarea>

			<label for="sex_type">Sex</label>
			<select name="sex_type" id="sex_type">
				<option value="0">Male</option>
				<option value="1">Femal</option>
			</select>

			<label for="student_code">Telephone</label>
			<input type="text" placeholder="Telephone" name="telephone" id="telephone">	
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#upload_modal_form').submit();" class="btn btn-primary">Upload Instapic</a>
	</div>
</div>