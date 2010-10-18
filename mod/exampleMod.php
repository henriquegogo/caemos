<? // MOD
$modName = "Example Module";
$modDescription = "An example module that do nothing.";

function exampleMod() {
	global $pName;

  $return = "Your page name are $pName";

	// Show the return
	return $return;
}
?>
