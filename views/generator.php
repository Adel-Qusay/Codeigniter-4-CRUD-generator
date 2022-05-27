<?php include_once 'include/header.php'; ?>

<?php include_once 'include/navbar.php'; ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card" id="card">
				<div class="card-header">
					<h4 class="text-center"><?= $title ?></h4>
				</div>
				<div class="card-body">

					<div class="col-md-10 offset-md-1 mb-4 text-center" id="generate-msg">
						<?php
						if (!empty($_SESSION["error"])) {
							echo $_SESSION["error"];
							unset($_SESSION["error"]);
						}
						?>
					</div>

					<form id="generate-form" action="srv.php" method="POST">
						<div class="row">
							<div class="col-md-4" hidden>
								<div class="form-group">
									<label for="crudLang" class="form-label">CRUD language: <span class="text-danger">*</span></label>
									<select class="form-control" name="crudLang" id="crudLang" required>
										<!-- <option value="" selected>-- Select --</option>
									  <option value="en">English</option>
									  <option value="ar">Arabic</option> -->
										<option value="new" selected>New Features</option>
									</select>
								</div>
							</div>
							<div class="col-md-6" >
								<div class="form-group">
									<label for="database" class="form-label">1. Select Database: <span class="text-danger">*</span></label>
									<select class="form-control" name="database" id="database" required>
										<option value="" selected>-- Select --</option>
										<?php
										foreach ($databases as $database) {
											echo '<option value="' . $database . '">' . $database . '</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="table" class="form-label">2. Select Table: <span class="text-danger">*</span></label>
									<select class="form-control" name="table" id="table" required disabled>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="crudName" class="form-label">3. Edit CRUD Name: <span class="text-danger">*</span></label>
									<input type="text" name="crudName" id="crudName" class="form-control" placeholder="" maxlength="50" required disabled>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="crudTitle" class="form-label">4. Edit CRUD Title: <span class="text-danger">*</span></label>
									<input type="text" name="crudTitle" id="crudTitle" class="form-control" placeholder="" maxlength="50" required disabled>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="primaryKey" class="form-label">Primary key: <span style="font-size:10px" class="text-primary"> You must define the primary key for each table</span><span class="text-danger">*</span></label>
									<select class="form-control" name="primaryKey" id="primaryKey" readonly required>
									</select>
								</div>
							</div>
						</div>
						<div id="fields" class="mt-4">
						</div>
						<div class="form-group row mt-2">
							<div class="col-sm-6 offset-sm-3">
								<input type="hidden" name="act" id="act" class="form-control" value="generate">
								<button type="submit" id="generate-btn" class="btn btn-block btn-primary"><i class="fa fa-codepen"></i> Generate</button>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-8 offset-md-2">
							<div id="response" class="mt-2">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php include_once 'include/footer.php'; ?>
<script src="<?= BASE_URL ?>/assets/dist/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= BASE_URL ?>/assets/dist/jquery/jquery-ui.min.js"></script>
<script src="<?= BASE_URL ?>/assets/dist/popper/popper.min.js"></script>
<script src="<?= BASE_URL ?>/assets/dist/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= BASE_URL ?>/assets/dist/jquery-validation/jquery.validate.min.js"></script>

<script>
	$(document)
		.ready(
			function() {
				$.validator.setDefaults({
					highlight: function(element) {
						$(element).addClass('is-invalid').removeClass('is-valid');
					},
					unhighlight: function(element) {
						$(element).removeClass('is-invalid').addClass('is-valid');
					},

					errorElement: 'div ',
					errorClass: 'invalid-feedback',
					errorPlacement: function(error, element) {
						if (element.parent('.input-group').length) {
							error.insertAfter(element.parent());
						} else if ($(element).is('.select')) {
							element.next().after(error);

						} else if (element.hasClass('select2')) {
							//error.insertAfter(element);
							error.insertAfter(element.next());
						} else if (element.hasClass('selectpicker')) {
							error.insertAfter(element.next());
						} else {
							error.insertAfter(element);
						}
					},
					submitHandler: function(form) {
						var data = $("#generate-form").serializeArray();

						$.ajax({

							type: 'POST',
							url: 'srv.php',
							data: data,
							beforeSend: function() {
								$("#generate-btn").html('<i class="fa fa-spinner fa-spin"></i>');
							},
							success: function(response) {
								var re = JSON.parse(response);
								if (re.success == true) {
									$('#response').html('<div class="alert alert-success text-center" role="alert">' + re.message + '</div>');
									$("#generate-btn").html('<i class="fa fa-codepen"></i> Generate');
								} else {
									$('#response').html('<div class="alert alert-danger text-center" role="alert">' + re.message + '</div>');
									$("#generate-btn").html('<i class="fa fa-codepen"></i> Generate');
								}
							}
						});

						return false;
					}
				});

				// Base Form Class
				$('#generate-form').validate();

			});

	$("#database").change(function() {
		var database = $(this).val();
		$("#table").removeClass('is-invalid').removeClass('is-valid');
		$("#table").val('');
		$('#fields').html('');
		$('#primaryKey').html('');

		if (database == '') {
			$("#table").prop("disabled", true);
			$("#table").val('');
			$('#fields').html('');
			$('#primaryKey').html('');
			if ($("#crudName").is(':disabled')) $("#crudName").prop("disabled", true);
			if ($("#crudTitle").is(':disabled')) $("#crudTitle").prop("disabled", true);
			$("#crudName").val('');
			$("#crudTitle").val('');
		} else {
			if ($("#table").is(':disabled')) $("#table").prop("disabled", false);
			$.ajax({
				url: "srv.php",
				data: {
					'act': 'getTablesByDatabase',
					'database': database
				},
				type: "POST",
				beforeSend: function() {
					if (!$("#table").is(':disabled')) $("#table").prop("disabled", true);
				},
				success: function(response) {
					if ($("#table").is(':disabled')) $("#table").prop("disabled", false);
					$("#table").html(response);
				}
			});
		}
	});

	$("#table").change(function() {
		var database = $('#database').val();
		var table = $(this).val();
		$("#primaryKey").removeClass('is-invalid').removeClass('is-valid');
		$('#primaryKey').html('');
		if (table == '') {
			$('#primaryKey').html('');
			if ($("#crudName").is(':disabled')) $("#crudName").prop("disabled", true);
			if ($("#crudTitle").is(':disabled')) $("#crudTitle").prop("disabled", true);
			$("#crudName").val('');
			$("#crudTitle").val('');
		} else {
			if ($("#crudName").is(':disabled')) $("#crudName").prop("disabled", false);
			if ($("#crudTitle").is(':disabled')) $("#crudTitle").prop("disabled", false);
			$("#crudName").val(table);
			$("#crudTitle").val(table);
			$.ajax({
				url: "srv.php",
				data: {
					'act': 'getPrimaryColumnsByTable',
					'database': database,
					'table': table
				},
				type: "POST",
				beforeSend: function() {},
				success: function(response) {
					$("#primaryKey").html(response);
				}
			});
		}
	});

	function sortableArrayAlert() {
		sortableArray = $('li').toArray();
	}

	$("#table").change(function() {
		var database = $('#database').val();
		var table = $(this).val();
		$("#fields").html('');
		if (table == '') {
			$("#fields").html('');
		} else {
			$.ajax({
				url: "srv.php",
				data: {
					'act': 'getColumnsByTable',
					'database': database,
					'table': table
				},
				type: "POST",
				beforeSend: function() {
					$('#fields').html('');
				},
				success: function(response) {
					$('#fields').html(response);
					sortableArrayAlert();
					$('ul').sortable();
					$('a').click(function(e) {
						e.preventDefault();
						$(this).parent().parent().parent().parent().remove().then(sortableArrayAlert());
					});
				}
			});
		}
	});
</script>
</body>

</html>