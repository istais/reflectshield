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
		   	   $buffer = (str_replace($key, htmlentities($key,ENT_QUOTES), $buffer));
			   $buffer = (str_replace($value, htmlentities($value,ENT_QUOTES), $buffer));
		   }
		}
		return $buffer;
	}

	public function core($buffer)
	{
		$buffer = $this->sanitize($_GET, $buffer);
		$buffer = $this->sanitize($_POST, $buffer);
		$buffer = $this->sanitize($_COOKIE, $buffer);
		$buffer = $this->sanitize($_FILES, $buffer);
	  	return $buffer;
	}

	public function __construct(){

		ob_start(array($this,'core'));

	}

	public function __destruct(){

		ob_end_flush();

	}
}
?>