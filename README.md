# Bear Bones Page Hover Box #
*******************************

## Features: ##
---------------
- Based on BEM
- Easily works with Font Awesome (or other icon set) to include an icon in front of title
- Template system
- Option to display thumbnail
- Thumbnail size selection
- Featured image override
- Excerpt override


## Template System: ##
----------------------
Based on the [Flexible Posts Widget plugin](http://wordpress.org/extend/plugins/flexible-posts-widget) 
by David Paul Ellenwood (dpedesign.com) which we use frequently in our projects 
**License:** GPL2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

### To use a custom HTML output template ###
1. Create a folder called 'bb-page-hover-box' in the root folder of the currently active theme.
1. Copy `default.php` from within the plugin's `views` folder into your theme's new `bb-page-hover-box` folder.
1. Rename your theme's `default.php` template file to a name of your choice. Example: `home-widget-hover.php`.
1. Go to 'Appearance' > 'Widgets' in WordPress to configure an instance of the widget.
1. In the 'Template Filename' field choose the name of the template file you added to your theme. Example: `Home Widget`

## Featured Image Override ##
-----------------------------
1. Add a custom field to the post/page with the name "page-hover-box-image"
2. Copy the url of the image to use into the value field
3. Save/Update

## Excerpt Override ##
----------------------
1. Add a custom field to the post/page with the name "page-hover-box-excerpt"
2. Enter the text to be used into the value field
3. Save/Update



## Frequently Asked Questions ##
----------------------------------

### How do I find a post's ID? ###
Per a [WordPress support thread](http://wordpress.org/support/topic/where-can-find-the-post-id):

Go to Posts in your WordPress admin, and click the post you need the ID of. Then, if you look in the address bar of your browser, you'll see something like this:

`http://example.com/wp-admin/post.php?post=1280&action=edit`

The number, in this case 1280, is the post ID.

### How can I style the images, titles or other widget output a certain way? ###
Ths plugin intentionally does NOT add any styling of it's own.  To adjust the font size, color, alignment, image size, etc. of any output from this widget, you'll need to edit your theme's styles. However, for your convenience, we have included scss and css files of examples.

### Does this plugin/widget insert any styles or scripts into my site? ###
NO! This plugin does not add styles or scripts to your public theme.  The plugin is intentionally designed to work within your existing theme.  