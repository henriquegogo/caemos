<?
// Create the "itens" function
function listPages($category, $normal, $active) {
	$normal = strtr($normal, '#', '$');
	$active = strtr($active, '#', '$');
	global $p;
	// List a page directory files in a array
	if ($handle = opendir('pag/')) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$fileList[] = str_replace('.php', '', $file);
			}
		}
		closedir($handle);
		sort($fileList);
	}
	foreach($fileList as $file) {
		unset($pageImage);
		include("pag/$file.php");
		unset($pageContent, $pageKeywords); // We don't need this variables in this time
		if ($category == $pageCategory) {
			$itemUrl = "?p=$file";
			$itemDescription = $pageDescription;
			$itemTitle = $pageTitle;
			$itemImage = "img/$pageImage";
			if ($p == $file.'.php') {
				eval("\$item = \"$active\";");
			}
			else {
				eval("\$item = \"$normal\";");
			}
			$itens[$pageOrder] = $item;
		}
	}
	// Show item by item from $itens array, in order, resorting the order array, if exist broken numbers
	ksort($itens);
	foreach ($itens as $valor) {
		$itensOrdened[] = $valor;
	}
	for($i = 0; $i <= count($itensOrdened); $i++){
		echo($itensOrdened[$i]);
	}
	echo "\n";
}

// Function to load theme modules
function module($file) {
	if (is_file("mod/$file.php")) {
		if (!function_exists("$file")) { // If the module dont was loaded
			include("mod/$file.php");
		}
		return $file();
	}
	else {
		echo "Install the module first";
	}
}
?>