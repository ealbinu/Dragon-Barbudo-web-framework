<?php
# include this CLASS
# Initialize --->  new Inputs('LabelName', 'InputType', 'DefaultValue', 'Required?');  
####
# EXAMPLE --->  new Inputs('Your Name','text', 'John Foo', true);
# RESULT ---> <label for="your_name">Your Name</label><input type="text" id="your_name" name="yourname" value="John Foo" required />
####
class Inputs{
	var $title;
	var $type;
	var $name;
	var $value;
	var $required;
	public function Inputs($ti,$ty, $v=NULL, $r=false){
		$this->title = $ti;
		$this->type = $ty;
		$this->name = iname($ti);
		$this->value = $v;
		$this->required = $r;
		if($ti){
			echo '<label for="'.$this->name.'">'.$this->title.'</label>';
		}
		switch($this->type){
			case 'text':
			case 'password':
			case 'email':
			case 'color':
			case 'date':
			case 'hidden':
			case 'search':
			case 'tel':
			case 'submit':
				if($r){
					echo '<input type="'.$this->type.'" id="'.$this->name.'" name="'.$this->name.'" value="'.$this->value.'" required />';
				} else {
					echo '<input type="'.$this->type.'" id="'.$this->name.'" name="'.$this->name.'" value="'.$this->value.'" />';
				}
				break;
			case 'textarea':
				if($r){
					echo '<textarea id="'.$this->name.'" name="'.$this->name.'" required>'.$this->value.'</textarea>';
				} else {
					echo '<textarea id="'.$this->name.'" name="'.$this->name.'">'.$this->value.'</textarea>';
				}
				break;
			case 'buttonsubmit':
					echo '<button name="'.iname($this->value).'">'.$this->value.'</button>';
				break;
				case 'button':
					echo '<button type="submit" name="'.iname($this->value).'">'.$this->value.'</button>';
				break;
			case 'select':
				echo '<select id="'.$this->name.'" name="'.$this->name.'" >';
				foreach($this->value as $v){
					echo '<option value="'.array_search($v,$this->value).'">'.$v.'</option>';
				}
				echo '</select>';
				break;
				
		}
	}

	
}

function iname($name){
		$special = array('á', 'é','í','ó','ú','Á', 'É','Í','Ó','Ú', ' ', '?', '¿', 'ñ', 'Ñ', '"','.','+','[',']');
		$vowels = array('a', 'e','i','o','u','A', 'E','I','O','U', '_', '', '', 'n', 'N','','','plus','','');
		$final = str_replace($special, $vowels, $name);
		return strtolower($final);
	}

?>