Blogger
=======

Blogger - test project for ONGR bundles. It uses functionality of
`Elasticsearch`, `FilterManager`, `Router`, `Settings`, `Cookies` 
bundles. This test application is implemented as a blog/news site
 with a minimal admin panel.

Installation
--------------

The installation is very simple and basic, most of the assets are already
in the web folder therefore very little frontend compilation is needed.
To install just run these commands:

  * `composer install`
  * `bin/console ongr:es:index:create`
  * `bin/console ongr:es:index:create -m settings`
  * `bin/console ongr:es:index:import data.json`
  * `bin/console ongr:es:index:import settings.json -m settings`
  * `bin/console assets:install --symlink`
  * `bin/console doctrine:database:create`
  * `bin/console doctrine:schema:update --force`
  * Finally, import the `dump.sql` to your database and you are ready

Two users should now be configured:
 
  * username: `test`, password: `test`
  * username: `admin`, password: `admin`