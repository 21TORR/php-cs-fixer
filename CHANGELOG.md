1.1.8
=====

* (bug) Exclude `reference.php` in PHP-CS-Fixer config.


1.1.7
=====

* (bug) Add missing `migrations` entry in possible list of directories to scan.


1.1.6
=====

* (improvement) Use newer PHP-CS-Fixer version.
* (improvement) Also run CS fixer for migrations.
* (improvement) Require PHP 8.4


1.1.5
=====

* (improvement) Fix overly strict rules for PHPUnit.


1.1.4
=====

* (improvement) Make sure to always import FQCNs.


1.1.3
=====

* (improvement) Fix inside more dirs and simplify the directory logic.


1.1.2
=====

* (bug) Disable `phpdoc_to_comment` as it breaks property PHPDocs without tag.
* (bug) Disable `method_chaining_indentation` as it breaks for Symfony Configuration classes.


1.1.1
=====

* (bug) Remove breaking rule.
* (improvement) Fill list of checked custom fixer rules.
* (improvement) Improve comment style in config file.


1.1.0
=====

* (feature) Automatically enable parallel fixing.
* (feature) Update all rules.
* (improvement) Remove and replace deprecated rule usage.


1.0.2
=====

* (improvement) Exclude `secrets` dir.


1.0.1
=====

* (bug) Fix invalid rules.
* (bug) Fix error in README.


1.0.0
=====

Initial release `\o/`
