# WordPress Starter Pack

This project contains the composer template information below along with a custom child theme for twentysixteen and the default plugin installations for wordpress.

* Child theme located in `cd web/wp-content/themes/custom/twentysixteen-child` (where custom development goes)

## Requirements

* Install Composer dependency manager for PHP [Composer](https://getcomposer.org/).
* Install Docker for your specific OS [Docker](https://docs.docker.com/)

## Directions to install

Clone the repo: `git clone https://github.com/grgwrd/wordpress-starter.git`

Enter into project and install with composer `cd wordpress-starter`

Install project with Composer `composer install`

Build and run your project with Docker `docker-compose build` and `docker-compose up -d` (-d to run containers in background)

Now, you should be able to visit [localhost:8000/](http://localhost:8000/) and run through the WordPress Installation.

# Composer Template for WordPress Projects

This project template should provide a kickstart for managing your site dependencies with [Composer](https://getcomposer.org/).

This project consist of:

* WordPress core: [johnpbloch/wordpress-core-installer](https://github.com/johnpbloch/wordpress-core-installer)
* Repository https://wpackagist.org/ to install WordPress plugins and themes
* `composer/installers` to set custom paths for plugins and themes
* `drupal-composer/preserve-paths` to exclude paths for plugins and themes under version control
* `wodby.yml` that runs `composer install`. You can remove it if you're not using [Wodby](https://wodby.com)

Current WordPress core: `~4.9`
