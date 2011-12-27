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
3. Install Juicer needed files:
    juicer install yui_compressor
    juicer install closure_compiler
    juicer install jslint
4. `bundle exec guard` to start compressing and compiling coffeescript / sass automatically
5. `bundle exec rake jasmine` to fire up local jasmine testing server on port 8888

Note: update the guardfile minify process if you use different libraries. I
hardcoded the paths since I'm pulling in the libs as submodules and I don't
want to process and minify *everything* recursively, because we'd end up with
a crapton of extra stuff we don't want, since we can't point to specific files
through submodules. You might, for example, try to load jQuery externally
instead of compiling it into the app.min.js.

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
