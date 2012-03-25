<!-- TITLE -->
<title><? echo $titulo; ?></title>

<!-- METAs -->
<meta charset="utf-8" />
<meta name="description" content="<? echo $descripcion; ?>" />
<meta name="keywords" content="<? echo $keywords; ?>" />

<? if($mobile){ ?>
<!-- MOBILE -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> 
<? } ?>

<!-- FAVICON -->
<link rel="shortcut icon" href="favicon.ico<? echo d($b); ?>" />
<link rel="icon" type="image/ico" href="favicon.ico<? echo d($b); ?>" />
<link rel="apple-touch-icon" href="/apple-touch-icon.png<? echo d($b); ?>"/>
<link rel="apple-touch-icon-precomposed" href="apple-touch-icon-precomposed.png">
<!-- HUMANS -->
<link rel="author" href="humans.txt" />

<!-- Google Webfonts -->


<!-- CSS -->
<? foreach($css as $c){ ?>
<link style="text/css" href="css/<? echo $c.d($b); ?>" rel="stylesheet" />
<? } ?>

<!-- ie HACK -->
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- JAVASCRIPT -->
<? if($gmaps){ ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<? } ?>
<script type="text/javascript" src="js/jscripts.js<? echo d($b); ?>"></script>


<? if($tester==true){	?>
<script type="text/javascript">
	$(document).ready(function(){
		$('body').append('<div class="tester"><? for($i=0; $i<$cols; $i++){ ?><div></div><? } ?></div>');
	});
</script>
<?	}	?>