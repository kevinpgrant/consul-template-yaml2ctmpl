<?php

/**
    @author     Kevin Grant
    @copyright  October 2016
    @credits    sample json gratuitously taken from https://www.sitepoint.com/facebook-json-example/
    @disclaimer No warranty of any kind. Use it at your own risk!
    @usage      see the Readme.md
*/

$json_str = '{
   "data": [
      {
         "id": "X999_Y999",
         "from": {
            "name": "Tom Brady", "id": "X12"
         },
         "message": "Looking forward to 2010!",
         "actions": [
            {
               "name": "Comment",
               "link": "http://www.facebook.com/X999/posts/Y999"
            },
            {
               "name": "Like",
               "link": "http://www.facebook.com/X999/posts/Y999"
            }
         ],
         "type": "status",
         "created_time": "2010-08-02T21:27:44+0000",
         "updated_time": "2010-08-02T21:27:44+0000"
      },
      {
         "id": "X998_Y998",
         "from": {
            "name": "Peyton Manning", "id": "X18"
         },
         "message": "Where\'s my contract?",
         "actions": [
            {
               "name": "Comment",
               "link": "http://www.facebook.com/X998/posts/Y998"
            },
            {
               "name": "Like",
               "link": "http://www.facebook.com/X998/posts/Y998"
            }
         ],
         "type": "status",
         "created_time": "2010-08-02T21:27:44+0000",
         "updated_time": "2010-08-02T21:27:44+0000"
      }
   ]
}';

echo "JSON Before:\n" . $json_str . PHP_EOL;

function walkTheArray(&$array, $outerkey) {
	foreach ($array as $key => &$value) {
		$newkey = join('/', array($outerkey, $key));
		if (is_array($value)) {
			walkTheArray($value, $newkey);
		} else {

			$value ="{{ consulserver_name := key_or_default \"" . $newkey . "\" \"".$value."\" }}";
			$key = $value;
		}
	}
	return $array;
}

$someArray = json_decode($json_str, true);
walkTheArray($someArray, '');

// var_export($someArray);
$new_json_str = json_encode($someArray, JSON_PRETTY_PRINT);

echo "JSON After:\n" . $new_json_str . PHP_EOL;
