=== Gaya ===
Contributors: jekkilekki
Tags: translation-ready
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A custom theme built for Key to Korean (keytokorean.com).

== Description ==

Gaya is a custom WordPress theme with no build process: edit any file in this
folder directly and reload the browser. It was originally scaffolded from WP
Rig, which used a Gulp build pipeline compiling a separate `/dev` source
folder into this one; that split has been removed. See README.md for the
current file structure and a changelog of the 2026 PHP 8 compatibility pass.

== Installation ==

1. Copy this folder to `wp-content/themes/`.
2. Activate it from Appearance > Themes.
3. No build step, no dependencies to install.

== Changelog ==

= 1.1.0 =
* PHP 8 compatibility fixes (see README.md for the full list).
* Removed the Gulp/Babel/node-sass build process.
* Removed dead/duplicate files and dev-only content shipped to visitors.

= 1.0.3 and earlier =
See git history.
