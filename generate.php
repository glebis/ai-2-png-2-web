<?php

$conf['format'] = 'png';
$conf['image_folder'] = '_png';
$conf['output_folder'] = '_out';
$conf['img_folder'] = 'img';

function arguments($argv) {
    $_ARG = array();
    foreach ($argv as $arg) {
      if (ereg('--([^=]+)=(.*)',$arg,$reg)) {
        $_ARG[$reg[1]] = $reg[2];
      } elseif(ereg('-([a-zA-Z0-9])',$arg,$reg)) {
            $_ARG[$reg[1]] = 'true';
        }
    }
  return $_ARG;
};

$args = arguments($argv);

$conf = array_merge($conf,$args);


$files = array();

if ($handle = opendir($conf['image_folder'])) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." && $entry != ".DS_Store") {
            $files[] = str_replace('.'.$conf['format'], '', $entry);
        }
    }
    closedir($handle);
}


// TODO: make optional
file_put_contents($conf['output_folder'].'/.htaccess', 'DirectoryIndex '.$files[0].'.html');


foreach($files as $id=>$filename) {
	
	$file = $conf['output_folder'].'/'.$filename.'.html';

	if($files[$id+1]!='') {
		$link = $files[$id+1];
	}
	else {
		$link = $files[0];
	}

	$text = '<a href="'.$link.'.html">
		<div class="container"><img src="'.$conf['img_folder'].'/'.$filename.'.'.$conf['format'].'" alt=""></div>
	</a>';

$content = '<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>'.$filename.'</title>
	<style>
		body {
			margin: 0; 
			padding: 0;
			min-width: 1100px;
			background: #fff;
		}
		.container {
			margin: 0 auto;
			text-align: center;
		}
		img {
			max-width: 1200px;
		}
	</style>
</head>
<body>'
	.$text.
'</body>


<script type="text/javascript">
function leftArrowPressed() {
   history.back();
}

function rightArrowPressed() {
   location.href = "'.$link.'.html";
}

document.onkeydown = function(evt) {
    evt = evt || window.event;
    switch (evt.keyCode) {
        case 37:
            leftArrowPressed();
            break;
        case 39:
            rightArrowPressed();
            break;
    }
};
</script>
</html>';

	file_put_contents($file, $content);
	
}
?>