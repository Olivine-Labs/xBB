Mint Boilerplate
================

*Because my [jasmine-css-coffeescript-backbone](https://github.com/ajacksified/Jasmine-Backbone-SASS-HTML5-Boilerplate)
built on top of the html5 boilerplate wasn't enough*

## What's Included?

* A place to put your non-app assets
* PHPUnit structure for your server-side tests
* Guardfile that converts coffeescript and sass to their respective things
* Jasmine gem for your TDD pleasure (guardfile will convert coffeescript tests)
* Underscore, jQuery, Backbone, and json2 pulled in as submodules for client work
* Mint pulled in as a submodule for your server work
* Default configurations for all of these things
* [1140 grid](http://cssgrid.net/)

## Setup

### UI Dev

1. Install ruby, put it in your path, install bundler
2. cd to path, `bundle install`
3. `bundle exec guard` to watch and convert coffeescript and less
4. `bundle exec rake jasmine` to fire up local jasmine testing server on port 8888

### Server Dev

1. Install PHP, get it in your path
2. `pecl install xdebug`
3. Run these things:
    pear channel-discover pear.symfony-project.com
    pear channel-discover components.ez.no
    pear channel-discover pear.phpunit.de
    pear update-channels
    pear install phpunit/PHPUnit
    pear install PHP_CodeSniffer-beta
4. `sudo pecl install mongo`
5. Update php.ini file to include extension=mongo.so [more details](http://www.mongodb.org/display/DOCS/PHP+Language+Center)
6. Start the mongo server
7. Run mongo client, fire up the application or create the application database in your mongodb instance, then create
the mongodb user with credentials specified in app/config/Database.config.php

## TODO

* Get coffeescript to compile all scripts together and minify it
