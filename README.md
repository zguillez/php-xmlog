# php-xmlog

[![Dependency Status](https://gemnasium.com/zguillez/php-xmlog.svg)](https://gemnasium.com/zguillez/php-xmlog)
![](https://reposs.herokuapp.com/?path=zguillez/php-xmlog)
[![License](http://img.shields.io/:license-mit-blue.svg)](http://doge.mit-license.org)
[![Analytics](https://ga-beacon.appspot.com/UA-1125217-30/zguillez/php-xmlog?pixel)](https://github.com/igrigorik/ga-beacon)
[![Join the chat at https://gitter.im/zguillez/php-xmlog](https://badges.gitter.im/zguillez/php-xmlog.svg)](https://gitter.im/zguillez/php-xmlog?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

PHP module for create XML and LOG files


# Getting Started

### Add package to composer.json

`composer require zguillez/php-xmlog`

	//packaje.json
	{
        "require": {
            "zguillez/php-xmlog": "^1.0.0"
        }
    }


# Example:

	<?php

      require 'vendor/autoload.php';

      use Z\Log;

      $log = new Log("register", "./logs/");

      echo $log->insert(Log::LOG, 'This is an update!', false, true, true);
      echo $log->insert(Log::XML, 'This is an update!', false, true, true);


# Contributing and issues

Contributors are welcome, please fork and send pull requests! If you have any ideas on how to make this project better then please submit an issue or send me an [email](mailto:mail@zguillez.io).

# License

©2016 Zguillez.io

Original code licensed under [MIT](https://en.wikipedia.org/wiki/MIT_License) Open Source projects used within this project retain their original licenses.

# Changelog

### v1.0.0 (March 12, 2016) 

* Initial implementation
