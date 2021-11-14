# Base Theme for Wordpress

This is a base theme without any CSS. All pages are created with twig files (yet utilizing Timber). Classes are BEM-compatible.

## Features

  * Advanced Color management: You can set 5 base colors and add more custom colors which are then shown in your gutenberg editor.
  * Routing system. Add or change routes in config/routes.php
  * Controller based: Each route can have it's own controller with a render function

## Used Frameworks
  * Timber
  * [Twig](https://www.google.com) is a Wordpress-Layer for the Twig PHP Template engine that improves code readability a lot. No more echos and PHP/HTML-Mixture.

## Install

Clone into your Wordpress theme folder, cd into the directory and run

    `composer install`


## Configuration

Before digging into any code, you may want to have a look into the config Directory. Most common Wordpress features, such as Widgets, Theme-Support, MIME-Types, Taxonomies, etc. you can edit here. Even ACF-Fields can be set up.

## twig Templates

This theme uses the twig template engine. It utilizes the awesome Timber-Component. You do not need to install the timber-plugin, as it is included by composer. In the future, it may be an option to include Timer sitewide, since it may also be used by plugins.  

## Class based structure

To avoid "spaghetti code", most functions are put in classes, so we have a clean and simple functions.php. When estending functions please stick to common coding guidelines such as:

  * Understandable function names without stupid acronyms
  * Every function should do **one** thing

## Laravel Mix

When developping locally, just run

    `npm install`



## Folder Structure

.
+-- assets
|   +-- edit your CSS and JS files here
|   +-- and compile them later with npm run build
+-- config
|   +-- add features and settungs to wordpress, such as
|   +-- theme_support, widgets, etc.
+-- lib
|   +-- PHP Classes
+-- public
|   +-- Where your compiled assets are
+-- templates
|   +-- Twig Templates for your Theme
+-- vendor
|   +-- Composer adds dependencies here.


