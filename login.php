<?php include_once "header.php"; ?>
<script type="text/javascript">
	$('.fb-login .fb-login-button').hide();
</script>
<div class="container">
	<div class="row">
		<div class="col-md-12 welcome-msg">
			<h3>You cannot procede without user profile.</h3>
			<h4>Sign in with Facebook</h4>
			<div>
				<div class="fb-login-button" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="true"></div>
			</div>
		</div>
	</div>
</div>
<?php include_once "footer.php"; ?>