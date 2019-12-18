<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body style="text-align: center;margin-top: 50px;">
<form method="post">
	<label>Username</label><br>
	<input type="text" value="<?php echo set_value('username');?>" name="username" maxlength="50" ><br>
	<?php echo form_error('username');?><br>
	<label>Password</label><br>
	<input type="text" value="<?php echo set_value('password');?>" maxlength="16" name="password"><br>
	<?php echo form_error('password');?><br>
	<input type="submit" name="submit">
</form>
</body>
</html>