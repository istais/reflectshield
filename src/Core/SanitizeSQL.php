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

namespace ReflectShield\Core;


class SanitizeSQL
{


	public function fail(){
		die('Attack etected');
	}
	
	public function sanitize_mysql($functionname, $data){
		print \Patchwork\hasMissed($functionname);
		\Patchwork\redefine($functionname, function($query) use ($data) {
			$parser = new \PhpMyAdmin\SqlParser\Parser($query);
			foreach ($data as $key => $value) {
				if (strpos($query, $value) !== FALSE) { 
					$found = 0;
        			foreach ($parser->list as $key => $sqlvalue) {
        				if(is_array($sqlvalue)){
							foreach ($sqlvalue as $subkey => $subvalue) {
								//print("Token: ".$subvalue->token);
								if (strpos($subvalue->token, $value) !== FALSE) { 
									$found = 1;
									break;
								}
							}
						}
						if($found === 1){
							break;
						}
					}
					if($found !== 1){
							$this->fail();
					}
    			}
			}

			return \Patchwork\relay();
					
		});
	}

	public function sanitize_mysqli($functionname, $data){
		print \Patchwork\hasMissed($functionname);
		\Patchwork\redefine($functionname, function($link,$query) use ($data) {
			$parser = new \PhpMyAdmin\SqlParser\Parser($query);
			foreach ($data as $key => $value) {
				if (strpos($query, $value) !== FALSE) { 
					$found = 0;
        			foreach ($parser->list as $key => $sqlvalue) {
        				if(is_array($sqlvalue)){
							foreach ($sqlvalue as $subkey => $subvalue) {
								//print("Token: ".$subvalue->token);
								if (strpos($subvalue->token, $value) !== FALSE) { 
									$found = 1;
									break;
								}
							}
						}
						if($found === 1){
							break;
						}
					}
					if($found !== 1){
							$this->fail();
					}
    			}
			}

			return \Patchwork\relay();
					
		});
	}

	public function flatten(array $array) {
    	$return = array();
    	array_walk_recursive($array, function($a,$b) use (&$return) { $return[] = $a;$return[] = $b;});
    	return $return;
	}

	
	public function core()
	{   

		$data = array_merge($this->flatten($_GET),$this->flatten($_POST),$this->flatten($_COOKIE),$this->flatten($_FILES));
		usort($data,function($a, $b) { return strlen($b) - strlen($a);});
		$this->sanitize_mysql('mysql_query', $data);
		$this->sanitize_mysqli('mysqli_query', $data);


	}

	public function __construct(){
		require_once __DIR__ . "/../../vendor/antecedent/patchwork/Patchwork.php";
		$this->core();

	}

	public function __destruct(){

	}

}
?>