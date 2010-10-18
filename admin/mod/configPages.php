<?
function configPages() {
	global $pName;

	// List page files and category in array
	if ($handle = opendir('../pag/')) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$fileList[] = $file;
			}
		}
		closedir($handle);
		sort($fileList);
	}
	foreach ($fileList as $file) {
		unset($pageImage);
		include("../pag/$file");
		// The category
		$categoryList[] = $pageCategory;
		// The pages list
		$pagesList[] = "<li><a href=\"?p=$pName&q=$file\"><b>$pageTitle</b> - $pageDescription</a></li>";
	}
	// Remove duplicated category
	$categoryListUnique = array_unique($categoryList);

	// PAGE EDIT
	if ($_GET['q']) {
		$q = $_GET['q'];
		$phpOrNot = explode(".", $q);
		if ($phpOrNot[1] != "php") {
			$q = "$q.php";
		}

		if (!is_file("../pag/$q.php") && !is_file("../pag/$q")) {
			// Set the page variables
			$pageTitle = 'New page';
			$pageModule = '';
			$pageImage = '';
			$pageContent = 'A new page';
			$pageCategory = '';
			$pageOrder = '';
			$pageDescription = 'A new page';
			$pageKeywords = '';
		
			// Open the page file and write data
			$fp = fopen("../pag/$q", "w");
			fwrite($fp, '<? // PAGE
$pageTitle = "'.$pageTitle.'";
$pageModule = "'.$pageModule.'";
$pageImage = "'.$pageImage.'";
$pageContent = "'.$pageContent.'";
$pageCategory = "'.$pageCategory.'";
$pageOrder = "'.$pageOrder.'";
$pageDescription = "'.$pageDescription.'";
$pageKeywords = "'.$pageKeywords.'";
?>');
			fclose($fp);
		}
		
		// Get the POST query value exist
		elseif ($_POST) {
			// If "Delete page" value exist
			if ($_POST['delete']) {
				$file = $_POST['delete'];
				unlink("../pag/$file");
				echo "<script type='text/javascript'>location.href='?p=".$pName."'</script>";
				break;
			}

			// Set the old $pageOrder to compare
			include("../pag/$q");
			$pageOrderOld = $pageOrder;

			// Set variables to write
			$pageTitle = $_POST['pageTitle'];
			$pageModule = $_POST['pageModule'];
			$pageImage = $_POST['pageImage'];
			$pageContent = $_POST['pageContent'];
			$pageCategory = $_POST['pageCategory'];
			$pageOrder = $_POST['pageOrder'];
			$pageDescription = $_POST['pageDescription'];
			$pageKeywords = $_POST['pageKeywords'];

			$msgDisplay = "block"; // To show the submit message
			
			// Open the page file and rewrite data
			$fp = fopen("../pag/$q", "w");
			fwrite($fp, '<? // PAGE
$pageTitle = "'.$pageTitle.'";
$pageModule = "'.$pageModule.'";
$pageImage = "'.$pageImage.'";
$pageContent = "'.$pageContent.'";
$pageCategory = "'.$pageCategory.'";
$pageOrder = "'.$pageOrder.'";
$pageDescription = "'.$pageDescription.'";
$pageKeywords = "'.$pageKeywords.'";
?>');
			fclose($fp);
			
			// If pageOrder was changed...
			if ($pageOrderOld != $pageOrder) {
				configPages_order();
			}
			echo "<script type='text/javascript'>location.href='?p=".$pName."&q=".$q."'</script>";
			break;
		}
		else {
			// Call the page variables
			include("../pag/$q");
			
			$msgDisplay = "none";
		}

		// Create select options
		foreach($categoryListUnique as $category) {
			if ($category == $pageCategory) {
				$categoryListOptions[] = "<option value='$category' selected='selected'>$category</option>";
			}
			else {
				$categoryListOptions[] = "<option value='$category'>$category</option>";
			}
		}
		$categoryListOptions = implode("", $categoryListOptions);
		
		// Show the return
		return "
		<script type='text/javascript' src='plugins/tiny_mce/tiny_mce.js'></script>
		<script type='text/javascript'>
		tinyMCE.init({
			// General options
			mode : 'textareas',
			theme : 'advanced',
			language: 'en',
			plugins : 'safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,template',

			// Theme options
			theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,|,justifyleft,justifyright,formatselect,styleselect,|,bullist,numlist,|,link,image,media,|,code,preview',
			theme_advanced_buttons2 : '',
			theme_advanced_buttons3 : '',
			theme_advanced_toolbar_location : 'top',
			theme_advanced_toolbar_align : 'left',
			theme_advanced_statusbar_location : 'bottom',
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : 'plugins/tiny_mce/style.css',

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : 'lists/template_list.js',
			external_link_list_url : 'lists/link_list.js',
			external_image_list_url : 'lists/image_list.js',
			media_external_list_url : 'lists/media_list.js',

			// Replace values for the template plugin
			template_replace_values : {
				username : 'Some User',
				staffid : '991234'
			}
		});
		function addCategory() {
			document.getElementById(\"newCategory\").disabled=false;
			document.getElementById(\"newCategory\").style.display=\"block\";
			document.getElementById(\"selectCategory\").style.display=\"none\";
			document.getElementById(\"linkAddCategory\").style.display=\"none\";
		}
		function deletePage() {
			document.getElementById(\"delete\").disabled=false;
			document.config.submit();
		}
		</script>
		<style>
		#config span.msg {
			display: $msgDisplay;
			color: green;
		}
		</style>
		<form id='config' name='config' action='' method='post'>
			<input type='hidden' name='p' value='".$pName."' />
			<input type='hidden' id='delete' name='delete' value='".$q."' disabled='disabled' />
			<p><label style='width: 100px'>Title:</label>
			<input type='text' name='pageTitle' value='".$pageTitle."' /></p>
			<p><label style='width: 100px'>Modules:</label>
			<input type='text' name='pageModule' value='".$pageModule."' /> <small style='color: red'>* Separate by commas</small></p>
			<p><label style='width: 100px'>Icon:</label>
			<input type='text' name='pageImage' value='".$pageImage."' /></p>
			<p><label style='width: 100px'>Content:</label><br />
			<textarea name='pageContent'>".$pageContent."</textarea><br />
			<small style='margin-left: 100px; color: red'>* To insert a module, write: [MODULE: module_name] </small></p>
			<p><label style='width: 100px'>Category:</label>
			<select id='selectCategory' name='pageCategory'>
				".$categoryListOptions."
			</select>
			<input type='text' id='newCategory' name='pageCategory' value='".$pageImage."' disabled='disabled' style='display: none' />
			<a href='javascript:addCategory()' id='linkAddCategory'><small>create new</small></a></p>
			<p><label style='width: 100px'>Order:</label>
			<input type='text' name='pageOrder' value='".$pageOrder."' /></p>
			<p><label style='width: 100px'>Description:</label>
			<input type='text' name='pageDescription' value='".$pageDescription."' /></p>
			<p><label style='width: 100px'>Tags:</label>
			<input type='text' name='pageKeywords' value='".$pageKeywords."' /> <small style='color: red'>* Separate by commas</small></p>
			<label style='width: 100px'><input type='submit' value='OK' /></label>
			<span class='msg'>Changed with success!</span>
			<input style='float: right' type='button' onclick='deletePage()' value='Delete page' />
			</form>";
	}

	// PAGES LIST
	else {
		// Organize page list by category
		foreach ($categoryListUnique as $category) {
			$pagesListComplete[] = "\n<ul class='list'><h1><small>$category</small></h1>";
			for($i = 0; $i <= count($pagesList); $i++){
				if ($categoryList[$i] == $category) {
					$pagesListComplete[] = $pagesList[$i];
				}
			}
			$pagesListComplete[] = "</ul>";
		}
		$pagesListComplete = implode("\n", $pagesListComplete);
		// Show the return
		return "
		<form id='config' action='' method='get'>
			<input type='hidden' name='p' value='".$pName."' />
			<p><label style='width: 100px'>New page:</label>
			<input type='text' name='q' /> <input type='submit' value='Create' /><br />
			<label style='width: 100px'>&nbsp</label>
			<small style='color: red'>* Without spaces and accents</small></p>
		</form>
		".$pagesListComplete;
	}
}

// FUNCTION THAT ORGANIZE THE PAGES ORDER AND REWRITE FILES WITH CORRECT ORDER
function configPages_order() {
	global $categoryListUnique;

	// List page files in array
	if ($handle = opendir('../pag/')) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$fileList[] = $file;
			}
		}
		closedir($handle);
		sort($fileList);
	}
	foreach ($fileList as $file) {
		include("../pag/$file");
		$orderList[$file] = $pageOrder;
	}
	
	// Reorganize the order, eliminating repetitions on numbers
	asort($orderList);
	$orderList = array_combine(range(1, count($orderList)), array_keys($orderList));
	
	// Rewrite $pageOrder data file by file
	foreach ($orderList as $key=>$value) {
		include("../pag/$value");

		// Open the page file and rewrite data
		$fp = fopen("../pag/$value", "w");
		fwrite($fp, '<? // PAGE
$pageTitle = "'.$pageTitle.'";
$pageModule = "'.$pageModule.'";
$pageImage = "'.$pageImage.'";
$pageContent = "'.$pageContent.'";
$pageCategory = "'.$pageCategory.'";
$pageOrder = "'.$key.'";
$pageDescription = "'.$pageDescription.'";
$pageKeywords = "'.$pageKeywords.'";
?>');
		fclose($fp);
	}
}
?>
