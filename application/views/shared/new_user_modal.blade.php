<div class="modal hide" id="import_user_modal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Import New User</h3>
	</div>
	<div class="modal-body">
		{{ $form->open() }}
		{{ $form->close() }}
	</div>
	<div class="modal-footer">
		{{ HTML::link('#', 'Cancel', array('class' => 'btn', 'data-dismiss' => 'modal')) }}
		{{ $form->submit('Save', '', 'btn btn-primary'); }}
	</div>
</div>