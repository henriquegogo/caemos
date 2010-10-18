<?
function configSite() {
	// This page name
	global $pName;

	// Get the POST query value exist
	if ($_POST) {
		$pass = $_POST['pass'];
		$email = $_POST['email'];
		$siteTitle = $_POST['siteTitle'];
		$theme = $_POST['theme'];
		$language = $_POST['language'];

		$msgDisplay = "block"; // To show the submit message
		
		// Open the config file and rewrite data
		$fp = fopen("../config.php", "w");
		fwrite($fp, '<? // CONFIGURATION
$pass = \''.$pass.'\';
$email = \''.$email.'\';
$siteTitle = \''.$siteTitle.'\';
$theme = \''.$theme.'\';
$language = \''.$language.'\';
?>');
		fclose($fp);
	}
	else {
		// Call the config variables
		include("../config.php");
		$msgDisplay = "none";
	}
	
	// List themes in a array
	if ($handle = opendir('../thm/')) {
		while (false !== ($thm = readdir($handle))) {
			if ($thm != "." && $thm != "..") {
				$themeList[] = $thm;
			}
		}
		closedir($handle);
		sort($themeList);
	}
	foreach($themeList as $thm) {
		if ($thm == $theme) {
			$themeSelect[] = "<option value='$thm' selected='selected'>$thm</option>";
		}
		else {
			$themeSelect[] = "<option value='$thm'>$thm</option>";
		}
	}
	$themeSelect = implode("", $themeSelect);
	
	// Show the return
	return "
	<style>
	#config span.msg {
		display: $msgDisplay;
		color: green;
	}
	</style>
	<form id='config' action='' method='post'>
		<input type='hidden' name='p' value='".$pName."' />
		<p><label style='width: 100px'>Password:</label>
		<input type='password' name='pass' value='".$pass."' /></p>
		<p><label style='width: 100px'>Email:</label>
		<input type='text' name='email' value='".$email."' /></p>
		<p><label style='width: 100px'>Website title:</label>
		<input type='text' name='siteTitle' value='".$siteTitle."' /></p>
		<p><label style='width: 100px'>Theme:</label>
		<select name='theme'>
			".$themeSelect."
		</select></p>
		<p style='display: none'><label style='width: 100px'>Language:</label>
		<input type='text' name='language' value='".$language."' /></p>
		<label style='width: 100px'><input type='submit' value='OK' /></label>
		<span class='msg'>Changed with success!</span>
	</form>";
}
?>
