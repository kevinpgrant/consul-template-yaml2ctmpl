# consul-template-yaml2ctmpl
generate ctmpl files from a simple nested yaml file

## About

Written and maintained by Kevin Grant
Last updated October 2016

If you use consul as a key/value store, and make use of consul-template to maintain config files (whether that is on a native linux server, or in docker containers), then you might have had to create a bunch of .ctmpl files by hand.

Generally speaking, we found that if we had a bunch of yaml files, with *sane defaults*, then the corresponding ctmpl file were easy to create - wherever we found a key, we replaced it's value with the consul-template syntax for 'key_or_default' - so when consul-template uses it, it wil first look in consul for a override value, and if a key was not found, then the existing value from the config file would suffice as a default.

The benefit of this system is that we can commit a bunch of dev credentials (localhost:3306, my_dbuser, my_db_password) and know that although this seems like it breaks the rule of not committing secrets with the source code, we can be sure that we just use dummy dev values (who would want to attack their localhost?!) and keep our production credentials and values away from the hends of the developers, or other prying eyes.

## usage

edit the json string in the file, and then run it from the commandline

php -f yaml2ctmpl.php

for example, running it withe the following input....

	JSON Before:
	{
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
		 "message": "Where's my contract?",
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
	}


Will produce

	JSON After:
	{
	    "data": [
		{
		    "id": " {{ consulserver\/v1\/kv\/data\/0\/id\/ : \"X999_Y999\" }}",
		    "from": {
			"name": " {{ consulserver\/v1\/kv\/data\/0\/from\/name\/ : \"Tom Brady\" }}",
			"id": " {{ consulserver\/v1\/kv\/data\/0\/from\/id\/ : \"X12\" }}"
		    },
		    "message": " {{ consulserver\/v1\/kv\/data\/0\/message\/ : \"Looking forward to 2010!\" }}",
		    "actions": [
			{
			    "name": " {{ consulserver\/v1\/kv\/data\/0\/actions\/0\/name\/ : \"Comment\" }}",
			    "link": " {{ consulserver\/v1\/kv\/data\/0\/actions\/0\/link\/ : \"http:\/\/www.facebook.com\/X999\/posts\/Y999\" }}"
			},
			{
			    "name": " {{ consulserver\/v1\/kv\/data\/0\/actions\/1\/name\/ : \"Like\" }}",
			    "link": " {{ consulserver\/v1\/kv\/data\/0\/actions\/1\/link\/ : \"http:\/\/www.facebook.com\/X999\/posts\/Y999\" }}"
			}
		    ],
		    "type": " {{ consulserver\/v1\/kv\/data\/0\/type\/ : \"status\" }}",
		    "created_time": " {{ consulserver\/v1\/kv\/data\/0\/created_time\/ : \"2010-08-02T21:27:44+0000\" }}",
		    "updated_time": " {{ consulserver\/v1\/kv\/data\/0\/updated_time\/ : \"2010-08-02T21:27:44+0000\" }}"
		},
		{
		    "id": " {{ consulserver\/v1\/kv\/data\/1\/id\/ : \"X998_Y998\" }}",
		    "from": {
			"name": " {{ consulserver\/v1\/kv\/data\/1\/from\/name\/ : \"Peyton Manning\" }}",
			"id": " {{ consulserver\/v1\/kv\/data\/1\/from\/id\/ : \"X18\" }}"
		    },
		    "message": " {{ consulserver\/v1\/kv\/data\/1\/message\/ : \"Where's my contract?\" }}",
		    "actions": [
			{
			    "name": " {{ consulserver\/v1\/kv\/data\/1\/actions\/0\/name\/ : \"Comment\" }}",
			    "link": " {{ consulserver\/v1\/kv\/data\/1\/actions\/0\/link\/ : \"http:\/\/www.facebook.com\/X998\/posts\/Y998\" }}"
			},
			{
			    "name": " {{ consulserver\/v1\/kv\/data\/1\/actions\/1\/name\/ : \"Like\" }}",
			    "link": " {{ consulserver\/v1\/kv\/data\/1\/actions\/1\/link\/ : \"http:\/\/www.facebook.com\/X998\/posts\/Y998\" }}"
			}
		    ],
		    "type": " {{ consulserver\/v1\/kv\/data\/1\/type\/ : \"status\" }}",
		    "created_time": " {{ consulserver\/v1\/kv\/data\/1\/created_time\/ : \"2010-08-02T21:27:44+0000\" }}",
		    "updated_time": " {{ consulserver\/v1\/kv\/data\/1\/updated_time\/ : \"2010-08-02T21:27:44+0000\" }}"
		}
	    ]
	}

