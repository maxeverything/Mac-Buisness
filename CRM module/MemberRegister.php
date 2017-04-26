<?php
include '../Function/product.php';
$result_Category = product::getCategory();
include '../Main/header.php';
?>
<div class="row">
	<script>
		$(document).ready(function() {
			$('#btnAdd').click(function(e) {
				var str = $('#frmRegister').serialize();
				$('.lblCategory').each(function() {
					str += '&category[]=' + $(this).attr("dir");
				});
				alert(str);
				e.preventDefault();
				if (confirm('Confirm to Register?')) {
					$.ajax({
						type : "POST",
						url : "hrefPrefCat.php?RegisterMember=",
						data : str,
						success : function(msg) {
							if (msg == '') {
								alert('The Register successful');
								location.reload();
							} else {
								//alert('Unable to add');
								alert(msg);
							}
						}
					});
				}
			});
			$('#frmCategory').submit(function(e) {
				e.preventDefault();
				$categoryId = $('#CategoryID').val();
				$category=$('#CategoryID :selected').text();
				alert($category+$categoryId);
				var valid = true;
				$('.lblCategory').each(function() {
					if ($(this).text() == $category) {
						valid = false;
					}
				});
				if (valid == true) {
					var display = '<div class="row">';
					display += '<div class="small-12 large-12 columns rowColor">';
					display += '<div class="small-4 large-4  columns lblCategory" id="lblCategory" dir='+$categoryId+'>';
					display += $category;
					display += '</div>';
					display += '<div class="small-4 large-4  columns" >';
					display += '</div>';
					display += '<div class="small-2 large-2  columns">';
					display += '<a id="btnDeleteColor" class="btnDeleteColor" href=" " dir="0">&#215;</a></div></div></div>';
					$('#clear').append(display);
				} else {
					alert('The Category already exits');
				}
			});
			$('#frmRegister').submit(function(e) {
				e.preventDefault();
				$('#p2').show();
				$('#p1').removeClass('active');
				$('#p2').addClass('active');
			});
			$("#clear").on('click', '.btnDeleteColor', function(e) {
			e.preventDefault();
			if (confirm('Confirm to delete?')) {
				$(this).parent().parent().parent().remove();
			}
		});
		});
	</script>
	<div class="section-container auto" data-section>
		<section class="section" id="p1">
			<h5 class="title"><a href="#panel1">Contact Us</a></h5>
			<div class="content" data-slug="panel1">
				<form class="custom" data-abide method="post" data-invalid="" id="frmRegister">
					<fieldset>
						<legend>
							Member Registration Form
						</legend>

						<div class="row">
							<div class="large-12 column">
								<div class="row">
									<div class="large-12 columns">
										<label for="email">User name</label>
										<input type="text" id="name" placeholder="user name" name="name" required>

									</div>
								</div>

								<div class="row">
									<div class="large-12 columns">
										<label for="email">Email</label>
										<input type="email" id="email" placeholder="youremail@mail.com" name="email" required>

									</div>
								</div>
								<div class="row">
									<div class="large-12 columns">
										<label for="password">Password <small>required</small></label>
										<input type="password" id="password" placeholder="Fill in Password" name="password" required>

									</div>
								</div>

								<div class="large-3 large-centered columns">
									<button id="submitRegister" type="submit" name="submit_member_reg" class="medium button green">
										Next
									</button>
								</div>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</section>
		<section class="section" id="p2">
			<h5 class="title"><a href="#panel2">FeedBack</a></h5>
			<div class="content" data-slug="panel2">

				<div class="row">
					<div class="large-12 small-12 columns">
						<fieldset>
							<legend>
								Product Preferring(Optional)
							</legend>
							<form id="frmCategory">
								<div class="row" id="DivAddColor">
									<div class="small-12 large-5  columns">
										<label for="CategoryID">Category</label>
										<select id="CategoryID" name="CategoryID" class="medium" required>
											<option value="">Category</option>
											<?php

while($row_Category=mysql_fetch_array($result_Category, MYSQL_ASSOC)){
											?>
											<option value="<?php echo $row_Category['categoryID'] ?>"> <?php echo $row_Category['categoryName'] ?> </option>
											<?php
											}
											?>
										</select>

									</div>
									<div class="small-12 large-2  columns">
										<button id="btnAddCategory" name="btnAddCategory" class="medium button green">
											Add
										</button>
									</div>
								</div>
							</form>
							<div id="row">
								<div class="small-12 large-12  columns">
									<div class="small-4 large-4  columns">
										<p>
											Color
										</p>
									</div>
									<div class="small-4 large-4  columns">
									</div>
									<div class="small-2 large-2  columns">
										<p>
											Delete
										</p>

									</div>
								</div>
							</div>

							<div id="clear">

							</div>
							<div class="row">
								<div class="large-12 small-centered columns" id="colorNext">
									<button id="btnAdd" name="btnAdd" class="medium button green">
										Submit
									</button>
								</div>
							</div>
						</fieldset>
					</div>
				</div>

			</div>
		</section>
	</div>

</div>
<?php
include '../Main/footer.php';
?>