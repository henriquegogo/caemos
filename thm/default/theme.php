<? $themeTitle = 'Example Theme'; ?>
<? $themeDescription = 'A basic theme to show how create a theme'; ?>
<? $themeAuthor = 'Henrique Gogó'; ?>
<? $themeContact = 'http://www.gogs.com.br'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?=$pageHead;?>
</head>

<body>

<div id="top">
<div id="gog">
	<h1><?=$siteTitle?></h1>
	<ul id="menu">
     		<? listPages("menu", "<li><img src='#itemImage' title='#itemDescription' /> <a href='#itemUrl' title='#itemDescription'>#itemTitle</a></li>", "<li><img src='#itemImage' title='#itemDescription' /> <a href='#itemUrl' class='active' title='#itemDescription'>#itemTitle</a></li>") ?>
	</ul>
</div> <!-- Fim de gog -->
</div> <!-- Fim de topo -->

<div id="body">
	<div id="content">
		<h1><img src="img/<?=$pageImage?>" /> <?=$pageTitle?></h1>
  		<h3><?=$pageDescription?></h3>
		<?=$pageContent?>
	</div> <!-- Fim de conteudo -->
	<div id="side">
		<ul>
     			<li><img src="thm/<?=$theme?>/img/voltar.png" /> <a href="javascript:history.go(-1)">Back</a></li>
     			<li><img src="thm/<?=$theme?>/img/admin.png" /> <a href="admin/" target="_blank">Administrator</a></li>
		</ul>
	</div> <!-- Fim de direita -->
	<div style="clear: both"></div> <!-- Corta o efeito float -->
	<div id="base">
		<p>Copyright (c) caemös. All rights reserved.</p>
	</div> <!-- Fim de base -->
</div> <!-- Fim de corpo -->

</body>

</html>
