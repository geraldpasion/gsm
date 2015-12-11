=== Hide for group (roles) ===
Contributors: kuaza
Donate link: http://makaleci.com/bagis-yapin-donate
Tags: hide, blog hide, website hide, post hide, page hide, hide post, hide page, hide category, hide tag, hide text, hide tax, hide shortcode
Requires at least: 3.1
Tested up to: 4.0
Stable tag: 1.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Wordpress Hide for group (roles): website, blog, page, post (or text), category, tags,tax v.s..

== Description ==

Wordpress Hide for group (roles): website, blog, page, post (or text), category, tags,tax v.s..

* All site (blog) hide for group (role) : Is routed to the specified page. 
* Simple hide for group(roles) pages.
* Create New group (role) or remove..
* Simple hide page, post (or text), category, tags for user role (group)
* Admin setting pages
* Hide pages for redirect page settings
* Hide pages for message on post content
* shortcode for hide content in text area.
* v.s..

Demo: http://makaleci.com/dersler/wordpress/php_file_cache/

Thanks:

* http://wordpress.org/plugins/taxonomy-metadata/
* http://www.smashingmagazine.com/2012/01/04/create-custom-taxonomies-wordpress/
* http://david-coombes.com/wordpress-get-current-user-before-plugins-loaded/
* http://stackoverflow.com/a/5892694/2824532
* Wordpress codex
* http://kuaza.com
* and me :)

== Screenshots ==
1. Post or page settings area
2. Category, tags or tax setting area
3. Plugins admin settings page
4. Example hidden text in content
5. Hidden post for loop

== Installation ==

1. Install the plugin like you always install plugins, either by uploading it via FTP or by using the "Add Plugin" function of WordPress. (Upload directory 'kuaza-post-shared-tracker' to the '/wp-content/plugins/' directory)
2. Before deactive this plugins: http://wordpress.org/plugins/taxonomy-metadata/ (because this plugins code i added k_hide plugin) ;)
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Activate the plugin at the plugin administration page
5. Settings for plugins edit or save K_hide area


== Frequently Asked Questions ==

= How do hide text shortcode ? =

Simple and fast hide text (see old post for selected groups):
<code>
[k_hide]Exaple hide text[/k_hide]
</code>

= How do hide text shortcode allowed group ? =

Simple and fast hide text (select allowed group):
<code>
[k_hide allowed_group="editor,author,ziyaretci"]Exaple hide text[/k_hide]
</code>

= How do hide text shortcode hide message ? =

Simple and fast hide text (see old post for selected groups):
<code>
[k_hide message="<div style='border:1px solid #ccc;'>Upp, im sorry please upgrade membership.</div>"]Exaple hide text[/k_hide]
</code>

= How do hide text shortcode allowed group and hide message ? =

Simple and fast hide text (select allowed group and hide message):
<code>
[k_hide allowed_group="editor,author,ziyaretci" message="<div style='border:1px solid #ccc;'>Upp, im sorry please upgrade membership.</div>"]Exaple hide text[/k_hide]
</code>

= How disable hide for page, post, category or tags ? =

Please select disable area on options..

== Changelog ==

= 1.0 =
* First release (released plugins)

== Translations ==

The plugin comes with various translations, please refer to the [WordPress Codex](http://codex.wordpress.org/Installing_WordPress_in_Your_Language "Installing WordPress in Your Language") for more information about activating the translation. If you want to help to translate the plugin to your language, please have a look at the k_group.pot file which contains all definitions and may be used with a [gettext](http://www.gnu.org/software/gettext/) editor like [Poedit](http://www.poedit.net/) (Windows).