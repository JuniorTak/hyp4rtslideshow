# Hyp4rtslideshow

A repo for the development of a WordPress slideshow plugin, based on [rtCamp](https://rtcamp.com/) WordPress-Slideshow Plugin assignment.

## Usage

1. Download the [plugin .zip file](https://www.dropbox.com/scl/fi/nwuhu45rbmex8au78djzp/hyp4rtslideshow.1.0.0.zip?rlkey=7ao32x1z0ooiej8478h2h6a8x&st=flo5i2uk&dl=0)
2. In the admin-side of your WordPress site, install and activate the plugin
3. Click the admin menu **HypSlideshow** to access the plugin settings page
4. Add images to display in the slideshow, you can also remove and reorder images
5. Add the shortcode `[hypslideshow]` on a page/post where you want to display the slideshow
6. In the front-side of your WordPress site, visit the page/post to see the slideshow in action

## Demo

http://hyp4rt.infinityfreeapp.com/demo-page/

## Running Tests

Before running tests, make sure to properly set up the [WordPress Testing Suite](https://make.wordpress.org/cli/handbook/misc/plugin-unit-tests/#running-tests-locally) which requires [WP-CLI](https://make.wordpress.org/cli/handbook/guides/installing/).

Then, run the following command to install [Composer](https://getcomposer.org/) dependencies

```bash
  composer install
```

To run tests, run the following command

```bash
  ./vendor/bin/phpunit tests/TestHypSlideshow.php
```

If you encounter any issue while setting up PHP Unit Tests, please refer to this [guide on fixing common issues while setting up php unit tests for wordpress plugins](https://sanjeebaryal.com.np/fixing-issues-while-setting-up-php-unit-tests-for-wordpress-plugins/).
