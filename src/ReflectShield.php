<?php
// MIT License

// Copyright (c) 2016 Ioannis Stais

// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in all
// copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
// SOFTWARE.

namespace ReflectShield;

class ReflectShield
{
	public function sanitize($array, $buffer){
		if (!isset($array)){
			return $buffer;
		}
		foreach($array as $key => $value)
		{
		   if (is_array($value)){
		   		$buffer = $this->sanitize($value, $buffer);
		   }
		   else{
			   $buffer = (str_replace($value, htmlentities($value,ENT_QUOTES), $buffer));
		   }
		}
		return $buffer;
	}

	public function flatten(array $array) {
    	$return = array();
    	array_walk_recursive($array, function($a,$b) use (&$return) { $return[] = $a;$return[] = $b;});
    	return $return;
	}

	
	public function core($buffer)
	{   
		$data = array_merge($this->flatten($_GET),$this->flatten($_POST),$this->flatten($_COOKIE),$this->flatten($_FILES));
		usort($data,function($a, $b) { return strlen($b) - strlen($a);});
		return $this->sanitize($data, $buffer);
	}

	public function __construct(){
		ob_start(array($this,'core'));

	}

	public function __destruct(){

		ob_end_flush();

	}
}
?>