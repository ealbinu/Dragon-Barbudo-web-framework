<?php
	include('settings.php');
	include('php/Inputs.php');

/*	*	*	 SETUP	*	*	 */
	
	
	
	
	$jscripts="";
	foreach($js as $js){
		$jscripts .= file_get_contents('js/'.$js);
	}
	file_put_contents('js/jscripts.js', $jscripts);
	
	
	// NAV
	$nav = array(
				'Inicio',
				'Productos|Seccion',
				'Servicios|Seccion|Seccion',
				'Contacto'
				);
	$navigation="";
	
	
	
	
	



	
	
	/*	*	*	*	*	*	*	*	*	*	*	PARTICULAR FUNCTIONS  *	*	*	*	*	*	*	*	*	*	*	*	*/
	
	
	
		
	/*	*	*	*	*	*	*	*	*	*	*	UNTOUCHABLE FUNCTIONS  *	*	*	*	*	*	*	*	*	*	*	*	*/
	// CREATE QR from Google Chart's API
	function qr($url, $size){
		return '<img src="http://chart.apis.google.com/chart?cht=qr&chl='.$url.'&chs='.$size.'x'.$size.'&chld=L|1" />';
	}
	
	// MYSQL CONNECTION
	if($servidor&&$usuario&&$password&&$dbase){
	
	$conexion = mysql_connect($servidor, $usuario, $password) or die ("Revisa host, usuario y password. " . mysql_error());
	$db = mysql_select_db($dbase) or die("Revisa el nombre de tu BD. " . mysql_error());
	mysql_query("SET NAMES UTF8");
	
	}
	
	// FORCE RELOAD: ANTI-CACHE…  returns a random number  [  ?v=1  ] 
	function d($dbug){
		if($dbug){
			$b = "?v=".rand(1, 50);
			return $b;
		}
	};
	
	// CURRENT URL
	function currenturl() {
 		$pageURL = 'http';
 		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 		$pageURL .= "://";
 		if ($_SERVER["SERVER_PORT"] != "80") {
  			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
 		} else {
  			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 		}
 		#return $pageURL."/";
 		global $u;
 		return $u."/";
	}
	function currenturi(){
		$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		return $url;
	}
	
	// RETURNS IMAGE WITH IMAGE.PHP [needs "currenturl" function]
	function imagephp($imageurl, $width){
		#$fullpath = currenturl()."php/image.php?width=$width&image=".currenturl()."$imageurl";
		$fullpath = currenturl()."php/image.php?width=$width&image=".currenturl()."$imageurl";
		return $fullpath;
	}
	
	// GENERATE NAVIGATION...
	#ul [navigation ul becomes $navigation]
	if(count($nav) > 0){
		$navigation.='<ul class="level1">';	
		foreach($nav as $n){ 
			
			if(strpos($n,'|')){
				$innernav = explode('|',$n);
				$navigation.= "<li class='level1' id='nav_".cname($innernav[0])."'>".cLinks($innernav[0],'level1')."<ul class='level2'>";
				for($i=1;$i<count($innernav);$i++){
					$navigation.= "<li class='level2'>".cLinks($innernav[$i],'level2',$innernav[0])."</li>";
				}
				$navigation.="</li></ul>";
			} else {
				$navigation.= "<li id='nav_".cname($n)."'>".cLinks($n)."</li>";
			};
			
		}
		$navigation.='</ul>';
	}
	
	
	
	
	

	# set active section
	function active($u){
		if(strtolower($u) == "inicio"){ $u = "index"; }
		$currentFile = $_SERVER["PHP_SELF"];
		$parts = explode('/', $currentFile);
		$parts2= explode('.', $parts[count($parts) - 1]);
		$equals = $parts2[count($parts2)-2];
		if(strtolower($u) == $equals){
			return 'active';
		}
	}
	#Convertir Strings en versiones 100% leíbles ["ÑÁ ú" en "na-u"] usado en nombres de páginas
	function cname($name){
		$special = array('á', 'é','í','ó','ú','Á', 'É','Í','Ó','Ú', ' ', '¿', 'ñ', 'Ñ', '"', '\?');
		$vowels = array('a', 'e','i','o','u','A', 'E','I','O','U', '-', '', 'n', 'N','','?');
		$final = str_replace($special, $vowels, $name);
		return strtolower($final);
	}
	# CREATE A LINK PARSING STRING WITH cname() SETS active() AND ADDS THE STRING BETWEEN <a> & </a>
	function cLinks($name, $class='',$inner=null){	
		$cl;
		if($class){
			$cl = ' '.$class.'';
		}
		if($inner){
			return '<a href="'.cname($inner."\?in=".$name).'" class="'.active(cname($name)).$cl.'">'.$name.'</a>';
		} else {
			return '<a href="'.cname($name).'" class="'.active(cname($name)).$cl.'">'.$name.'</a>';
		}
	}
	
	
	
	/*	*	*	*	*	*	*	*	*	*	*	FUNCTIONS YOU SHOULD NOT TOUCH *	*	*	*	*	*	*	*	*	*	*	*	*/
	
?>