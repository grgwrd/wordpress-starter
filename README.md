# WordPress Starter Pack

This project contains the composer template information below along with a custom child theme for twentysixteen and the default plugin installations for wordpress and including [Airpress Plugin](https://wordpress.org/plugins/airpress/)

# Composer Template for WordPress Projects

This project template should provide a kickstart for managing your site dependencies with [Composer](https://getcomposer.org/).

This project consist of:

* WordPress core: [johnpbloch/wordpress-core-installer](https://github.com/johnpbloch/wordpress-core-installer)
* Repository https://wpackagist.org/ to install WordPress plugins and themes
* `composer/installers` to set custom paths for plugins and themes
* `drupal-composer/preserve-paths` to exclude paths for plugins and themes under version control
* `wodby.yml` that runs `composer install`. You can remove it if you're not using [Wodby](https://wodby.com)

Current WordPress core: `~4.9`
