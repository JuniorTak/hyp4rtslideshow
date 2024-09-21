# hyp4rtslideshow

This is a GitHub repo for the development of a WordPress slideshow plugin.

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

Note: Unit Test cases are still being implemented. A sample test is the only current test case available.

To run it, run the following command

```bash
  ./vendor/bin/phpunit tests/TestHypSlideshow.php
```
