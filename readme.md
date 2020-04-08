# Kids Team Theme for Wordpress

This theme is created for the Wordpress-powered Website from kids-team.at/de/ch. It tries to combine newest technology like webpack and twig (via Timber) with a clear, class-based structure. This document may be a guideline for anyone who works on the page.

## Configuration

Before digging into the code, you may want to have a look into the config Directory. Most common Wordpress features, such as Widgets, Theme-Support, MIME-Types, Taxonomies , etc you can edit here.

## twig Templates

This theme uses the twig template engine. It utilizes the awesome Timber-Component. You do not need to install the timber-plugin, as it is included by composer. 

## Class based structure

To avoid "spaghetti code", most functions are put in classes, so we have a clean and simple functions.php.

## Webpack

For development, webpack and browser-sync may be good accompany. Simply run

    npm install

then start happy theming with ES6 and SASS.

## Folder Structure

.
+-- assets
|   +-- edit your SCSS and JA files here
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


