<!DOCTYPE html>
<html>
  <head>
		<title>Image upload</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="generator" content="cat /dev/urandom > index.html" />
		<link href="../css/upload.css" rel="stylesheet" media="all" />
		<link rel="icon" href="/favicon.png" type="image/x-png" />
	</head>
	<div style="width:100%;height:100%">
 	<body>
		<?php
		if ($handle = opendir('.')) {
		    while (false !== ($file = readdir($handle))) { 
				if ($file != "." && $file != ".." && $file != "index.php" ) { 
					echo   '<div class="image" style="float:left;">
									<a class="link" href="http://up.araya.su/img/' . $file . '"><img title="' . $file . '" src="./thumb/' . $file . '" class="done"></a>
							</div>'; 
		        } 
		    }
		    closedir($handle); 
		}

		?> 

	</div>
	</body>
</html>
