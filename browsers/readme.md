# Conditional Stylesheets and Body Classes #
**Contributors:** qlstudio  
**Tags:** css, browsers, clients, stylesheets, conditional, ie, explorer, hacks  
**Requires at least:** 3.2  
**Tested up to:** 4.0.0  
**Stable tag:** 0.4.7  
**License:** GPLv2  

Add conditional browser stylesheets and body class declarations

## Description ##

Easily include browser specific stylesheets in templates or select browser and version specific classes in CSS.

Conditional browser stylesheets are added after the main theme style.css allowing them to overrule previous rules - you only need to add the CSS rules that should change.

This plugin uses up-to-date WordPress top level functions, sanitizes all input data and is fully internationalized.

For feature request and bug reports, [please use the Q Support Website](https://qstudio.us/support/categories/conditional-stylesheets-and-body-classes).

Please do not use the Wordpress.org forum to report bugs, as we no longer monitor or respond to questions there.

### Features ###

* Checks for and adds browser and version specific stylesheets - such as "browsers-windows-firefox.css".
* Add browser and version specific body classes to all pages - such as body.browsers-msie-10
* Includes the Mobile Detect class and adds mobile & touch body classes.
* Adds a post type body class, for example: "posttype-page".
* Inserts handy HTML comments in the HTML footer of template files to tell you which CSS files could be used and which were found.

## Installation ##

For an automatic installation through WordPress:

1. Go to the 'Add New' plugins screen in your WordPress admin area
1. Search for 'Browsers'
1. Click 'Install Now' and activate the plugin

For a manual installation via FTP:

1. Upload the `browsers` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' screen in your WordPress admin area

To upload the plugin through WordPress, instead of FTP:

1. Upload the downloaded zip file on the 'Add New' plugins screen (see the 'Upload' tab) in your WordPress admin area and activate.

## Frequently Asked Questions ##

### How do I add and access browser specirfic stylesheets? ###

To add extra stylesheets, create a new CSS file and upload it to the root of your active theme or in the directory THEME/library/css/ - you can include a mixture of 3 values:

- Operating System name ( windows, mac, linux )
- Browser Name ( firefox, safari, chrome, msie )
- Browser Version ( a specific whole version number )

The plugin then looks for a matching CSS file in the root of the active theme or in the directory THEME/library/css/ using a combinations of these 3 values ( in these example we'll use IE 10 on windows ):

- browsers-msie.css
- browsers-msie-10.css
- browsers-windows-msie.css

### How do I select browser specific classes in my CSS files? ###

The Browsers plugin adds a collection of extra browser and operating system specific classes to the HTML &lt;body&gt; tag of all front-end pages of the current active theme.

The best way to find out what classes are added is to use a source code inspector like Google Chrome's Inspector to view the &lt;body&gt; tag.

You can then use these new classes to select HTML elements in the following way ( again using IE 10 as an example ):

style.css

`body.browsers-msie-10 {
	background-color: red;
}`

--------------

## Screenshots ##

## Changelog ##

### 0.4.7 ###
* readme update

### 0.4.6 ###
* WP 4.4.1 Testing

### 0.4.5 ###
* WP 4.0 Testing

### 0.4.4 ###
* 3.9.1 Testing

### 0.4.3 ###
* 3.8.1 Testing
* Forum link

### 0.4.1 ###
* Name change

### 0.4.0 ###
* Readyness for Q Theme Framework integration

### 0.3.4 ###
* Readme corrections

### 0.3.1 ###
* Correction to stylesheet location function

### 0.3 ###
* Body tags and CSS file names homogenized

### 0.2 ###
* First public release.

## Upgrade Notice ##

### 0.2 ###
First release.
