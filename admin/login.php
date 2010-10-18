<?
session_start();

if($_SESSION['user'] && $_SESSION['user']) {

}
else if($_POST["user"] == "admin" && $_POST["password"] == "admin") {
	$_SESSION['user'] = $_POST["user"];
	$_SESSION['password']   = $_POST["password"];
}
else {
	if($_POST["user"] || $_POST["password"]) {
		$menssage = "User or password are incorrect";
	}
?>
<body style="font-family: Arial, sans-serif;">

<div style="margin: 0 auto; width: 300px;">
<h1 style="text-transform: capitalize;">Admin <?= $siteTitle ?></h1>
<form method="POST" style="font-size: 13px; color: #333333">
	<label for="usuario"><b>User:</b></label><br />
	<input type="text" name="user" /><br />
	<label for="senha"><b>Password:</b></label><br />
	<input type="password" name="password" /> <input type="submit" value="OK" />
	<p style="color: red"><?= $menssage ?></p>
</form>
</div>

</body>
<?
exit();
}
?>
