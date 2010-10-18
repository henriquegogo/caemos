<?
function configMods() {
	global $pName;

	// List mod files in array
	if ($handle = opendir('../mod/')) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$fileList[] = $file;
			}
		}
		closedir($handle);
		sort($fileList);
	}
	$modsList[] = "<ul class='list'>";
	foreach ($fileList as $file) {
		unset($modName, $modDescription);
		include("../mod/$file");
		$fileExplode = explode(".", $file);
		$file = $fileExplode[0];
		// The mods list
		$modsList[] = "<li><b>$modName</b> - $modDescription <p>[MODULE: $file]</p></li>";
	}
	$modsList[] = "</ul>";
	$modsList = implode("", $modsList);

	// Show the return
	return $modsList;
}
?>
