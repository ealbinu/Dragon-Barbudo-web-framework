<?php
	include('settings.php');

/*	*	*	 SETUP	*	*	 */
	
	
	
	
	$jscripts="";
	foreach($js as $js){
		$jscripts .= file_get_contents('js/'.$js);
	}
	file_put_contents('js/jscripts.js', $jscripts);
	
	
	// NAV
	$nav = array('inicio');
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
		$navigation.='<ul>';	
		foreach($nav as $n){ 
			$navigation.= "<li>".cLinks($n)."</li>";
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
		$special = array('á', 'é','í','ó','ú','Á', 'É','Í','Ó','Ú', ' ', '?', '¿', 'ñ', 'Ñ', '"');
		$vowels = array('a', 'e','i','o','u','A', 'E','I','O','U', '-', '', '', 'n', 'N','');
		$final = str_replace($special, $vowels, $name);
		return strtolower($final);
	}
	# CREATE A LINK PARSING STRING WITH cname() SETS active() AND ADDS THE STRING BETWEEN <a> & </a>
	function cLinks($name, $class=''){	
		$cl;
		if($class){
			$cl = ' '.$class.'';
		}
		if($inner){
			return '<a href="'.cname($inner."/".$name).'" class="'.active(cname($name)).$cl.'">'.$name.'</a>';
		} else {
			return '<a href="'.cname($name).'" class="'.active(cname($name)).$cl.'">'.$name.'</a>';
		}
	}
	
	
	
	# CREATE MULTIDIMENSIONAL NAVIGATION LINKS
	function createNav($arr){
		global $navigation;
		$navigation.="\n".'<ul class="level1">'."\n";
		foreach($arr as $a){
			if(is_array($a)){
				$navigation.= "\t"."<li>".cLinks($a[0],'levels')."\n";
				$navigation.="\t\t".'<ul class="level2">'."\n";
				foreach($a[1] as $a1){
					if(is_array($a1)){
						$navigation.= "\t\t\t".'<li><a href="'.cname($a[0]).'?p='.cname($a1[0]).'" class="levels2">'.$a1[0].'</a>'."\n";
						$navigation.="\t\t\t\t"."<ul>"."\n";
						
						foreach($a1[1] as $a2){
							$navigation.= "\t\t\t\t\t".'<li><a href="'.cname($a[0]).'?p='.cname($a1[0]).'&p2='.cname($a2).'">'.$a2.'</a></li>'."\n";
						}
						$navigation.="\t\t\t\t".'<li><a href="#" class="return"><</a></li>'."\n";
						$navigation.="\t\t\t\t"."</ul>"."\n";
					} else {
						$navigation.= "\t\t\t".'<li><a href="'.cname($a[0]).'?p='.cname($a1).'" >'.$a1.'</a></li>'."\n";
					}
					
					$navigation.="\t\t\t"."</li>"."\n";
				}
				$navigation.="\t\t\t".'<li><a href="#" class="return"><</a></li>'."\n";
				$navigation.="\t\t"."</ul>"."\n";
				
			} else {
				$navigation.= "\t"."<li>".cLinks($a,'')."</li>"."\n";
			}
		}
		$navigation.="</ul>";
	}
	
	/*	*	*	*	*	*	*	*	*	*	*	FUNCTIONS YOU SHOULD NOT TOUCH *	*	*	*	*	*	*	*	*	*	*	*	*/
	
?>