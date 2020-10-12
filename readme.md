# Kids Team Theme for Wordpress

This theme is created for the Wordpress-powered Website from kids-team.at/de/ch. This document may be a guideline for anyone who works on the page.

## Used Frameworks

  * [I'm an inline-style link](https://www.google.com) is a Wordpress-Layer for the Twig PHP Template engine that improves code readability a lot. No more echos and PHP/HTML-Mixture.
  * Tailwind is a utility-first CSS Framework. Don't write huge CSS files, but simply insert desired classes into your HTML.
  * alpine.js is Tailwind for JavaScript. Many common features can be coded with a few extra HTML Attributes

## Configuration

Before digging into the code, you may want to have a look into the config Directory. Most common Wordpress features, such as Widgets, Theme-Support, MIME-Types, Taxonomies , etc. you can edit here. Even ACF-Fields can be set up.

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


