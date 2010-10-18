<?
// Call functions
include("functions.php");

// Call the config variables
include("config.php");

// Get the "P" query value
if ($_GET['p']) {
	$pName = $_GET['p'];
	$p = $_GET['p'].'.php';
}
else {
	$p = "home.php";
}

// Call the page variables
include("pag/$p");

// Insert a module in page, if exist
if ($pageModule) {
	$modFiles = explode(",", $pageModule);
	foreach($modFiles as $file) {
		$file = trim($file); // Delete the spaces characters
		if (is_file("mod/$file.php")) {
			include("mod/$file.php");
			$module = $file(); // The $pageModule() function in mod/$pageModule.php file
			$pageContent = str_replace("[MODULE: $file]", $module, $pageContent);
		}
		else {
			echo "Install the module first<br />";
		}
	}
}

// Create the head variable
$pageHead = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<meta name='description' content='$pageDescription'>
	<meta name='keywords' content='$pageKeywords' />
	<title>$siteTitle - $pageTitle</title>
	<link href='thm/$theme/style.css' rel='stylesheet' type='text/css' />
";

// Call the theme file and apply page functions
include("thm/$theme/theme.php");
?>
