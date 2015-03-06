<?php
/**
 * Plugin Name: Bear Bones Page Hover box
 * Text Domain: bb-page-hover-box
 * Domain Path: /languages
 * Description: Custom widget to display a box with a link for a page. Uses featured image.
 * Author:      Wendy Shoef
 * Author URI:  http://perkstersolutions.com/
 * Version:     1.0.0
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * 
 * NOTES:
 * This is a custom widget to display a box with an image and text displayed on hover. The widget setup is based 
 * on the wonderful plugin Flexible Posts Widget (http://wordpress.org/extend/plugins/flexible-posts-widget) 
 * by David Paul Ellenwood <david@dpedesign.com> which we use frequently in our projects
 *
 * @TODO: Set up languages files
 */
 
 
// Block direct requests
if ( ! defined( 'WPINC' ) ) {
	die;
}
 /*
 
 	
	
	*/

class bb_page_hover_box_widget extends WP_Widget {
	
	/**
     * Plugin version number
     *
     * The variable name is used as a unique identifier for the widget
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $plugin_version = '1.0.0';
	
	/**
     * Unique identifier for your widget.
     *
     * The variable name is used as a unique identifier for the widget
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $widget_slug = 'bb_phb_widget';
	
	/**
     * Unique identifier for your widget.
     *
     * The variable name is used as the text domain when internationalizing strings
     * of text. Its value should match the Text Domain file header in the main
     * widget file.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $widget_text_domain = 'bb-page-hover-box';
	
	 /**
	 * Setup variables to hold our default values
     *
     * @since    1.0.0
	 */

	protected $thumbsizes = '';
	protected $templates  = '';
	
	
	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {
		
		// load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );

		// The widget contrstructor
		parent::__construct(
			$this->get_widget_slug(),
			__( 'Page Hover Box', $this->get_widget_text_domain() ),
			array(
				//'classname'   => $this->get_widget_slug(),
				'description' => __( 'Display posts as widget items.', $this->get_widget_text_domain() ),
			)
		);
		
		// Setup the default variables after wp is loaded
		add_action( 'wp_loaded', array( $this, 'setup_defaults' ) );

		// @TODO Register admin styles and scripts 
		/*add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );*/
		
	}
	
	/**
	 * Return the widget slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_widget_slug() {
		return $this->widget_slug;
	}

	/**
	 * Return the widget text domain.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin text domain variable.
	 */
	public function get_widget_text_domain() {
		return $this->widget_text_domain;
	}
	
	/**
	 * Return the plugin version.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin version variable.
	 */
	public function get_plugin_version() {
		return $this->plugin_version;
	}


	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/
	
	/**
	 * Outputs the content of the widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array args  The array of form elements
	 * @param array instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {
				
		extract( $args );
		extract( $instance );
				
		$title = apply_filters( 'widget_title', empty( $title ) ? '' : $title );
		
		if ( empty( $template ) )
			$template = 'default.php';
		
		//Pass arguments to be used in template
		$phb_info = $instance;
		
		//Get the excerpt
		$phb_info['excerpt'] = isset( $phb_info['excerpt_override'] ) ? $phb_info['excerpt_override'] : bb_phb_excerpt( $phb_info['post_id'] );
		//Check if direct link and no id set
		if( isset( $phb_info['link'] ) && $phb_info['post_id'] < 1 ) $phb_info['post_id'] = url_to_postid( $phb_info['link'] ); //prar($linkID);
		//prar( $phb_info );
		
		// Get and include the template we're going to use
		include( $this->get_template( $template ) );
		
		// Be sure to reset any post_data before proceeding
		wp_reset_postdata();
        
    }

    /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
			
		$instance 				= $old_instance;
		$instance['title']		= strip_tags( $new_instance['title'] );
		$instance['post_id']		= (int) $new_instance['post_id'];
		$instance['iconclass']		= strip_tags( $new_instance['iconclass'] );
		$instance['icon']		= ( isset(  $new_instance['icon'] ) ? (int) $new_instance['icon'] : '0' );
		$instance['link']		= strip_tags( $new_instance['link'] );
		$instance['link_text']		= strip_tags( $new_instance['link_text'], '<i>' );
		$instance['thumbnail']	= ( isset(  $new_instance['thumbnail'] ) ? (int) $new_instance['thumbnail'] : '0' );
		$instance['img_override']		= strip_tags( $new_instance['img_override'] );
		$instance['excerpt_override']		= strip_tags( $new_instance['excerpt_override'] );
		$instance['thumbsize']	= ( in_array ( $new_instance['thumbsize'], $this->thumbsizes ) ? $new_instance['thumbsize'] : '' );
		$instance['template']	= ( array_key_exists( $new_instance['template'], $this->templates ) ? $new_instance['template'] : 'default.php' );
		$instance['cur_tab']	= (int) $new_instance['cur_tab'];
		
        
        return $instance;
      
    }

    /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		
		$instance = wp_parse_args( (array) $instance, array(
			'title'	=> '',
			'post_id'	=> '',
			'icon'	=> '0',
			'iconclass'	=> 'fa fa-',
			'link' 		=> '',
			'link_text'		=> 'More',
			'thumbnail' => '0',
			'thumbsize' => '',
			'img_override' => '',
			'excerpt_override' => '',
			'template'	=> 'default.php',
			'cur_tab'	=> '0',
		) );
		
		extract( $instance );
		
		include( $this->get_template( 'admin' ) );
		
	}

	/**
	 * Loads theme files in appropriate hierarchy:
	 * 1. child theme 2. parent theme 3. plugin resources.
	 * Will look in the bb-page-hover-box/ directory in a theme
	 * and the views/ directory in the plugin
	 *
	 * Based on a function in the amazing image-widget
	 * by Matt Wiebe at Modern Tribe, Inc.
	 * http://wordpress.org/extend/plugins/image-widget/
	 * 
	 * @param string $template template file to search for
	 * @return template path
	 **/
	public function get_template( $template ) {
		
		// whether or not .php was added
		$template_slug = preg_replace( '/.php$/', '', $template );
		$template = $template_slug . '.php';
		
		// Set to the default
		$file = 'views/' . $template;

		// Look for a custom version
		if ( $theme_file = locate_template( array( $this->get_widget_text_domain() . '/' . $template ) ) ) {
			$file = $theme_file;
		}
		
		return apply_filters( 'bb_phb_template_' . $template, $file );
		
	}

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {
		
		load_plugin_textdomain( $this->get_widget_text_domain(), false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		
	} // end widget_textdomain

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

		wp_enqueue_style(
			$this->get_widget_slug() . '-admin',
			plugins_url( 'css/admin.css', __FILE__ ),
			array(),
			$this->get_plugin_version()
		);

	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {
		
		$source = 'js/admin.min.js';
		
		if( SCRIPT_DEBUG ) {
			$source = 'js/admin.js';
		}
		
		wp_enqueue_script(
			$this->get_widget_slug() . '-admin',
			plugins_url( $source, __FILE__ ),
			array( 'jquery', 'jquery-ui-tabs' ),
			$this->get_plugin_version(),
			true
		);

	} // end register_admin_scripts
	
	
	
	
	/**
     * Setup a number of default variables used throughout the plugin
     *
     * Since 3.3.1
     *
     */
	public function setup_defaults() {
		
		// Get the registered image sizes
		$this->thumbsizes = get_intermediate_image_sizes();
		
		// Set the available templates
		$this->templates = wp_cache_get( 'templates', $this->widget_slug );
		
		if( false === $this->templates ) {
			$this->templates = (array) $this->get_files( 'php', 0, true );
			wp_cache_set( 'templates', $this->templates, $this->widget_slug );
		}
		
		
	}

	/**
	 * Return template files from the current theme, parent theme and the plugin views directory.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * Based on the function of the same name in wp-includes/class-wp-theme.php
	 *
	 * @param mixed $type Optional. Array of extensions to return. Defaults to all files (null).
	 * @param int $depth Optional. How deep to search for files. Defaults to a flat scan (0 depth). -1 depth is infinite.
	 * @param bool $search_parent Optional. Whether to return parent files. Defaults to false.
	 * @return array Array of files, keyed by the path to the file relative to the theme's directory, with the values
	 * 	being absolute paths.
	 */
	public function get_files( $type = null, $depth = 0, $search_parent = false ) {
		
		$files = array();
		$theme_dir = get_stylesheet_directory() . '/' . $this->get_widget_text_domain();
		$plugin_dir = dirname(__FILE__) . '/views';
		
		// Check the current theme
		if( is_dir( $theme_dir ) ) {
			$files += (array) self::scandir( $theme_dir, $type, $depth );
		}

		// Check the parent theme
		if ( $search_parent && is_child_theme() ) {
			$parent_theme_dir = get_template_directory() . '/' . $this->get_widget_text_domain();
			if( is_dir( $parent_theme_dir ) ) {
				$files += (array) self::scandir( $parent_theme_dir, $type, $depth );
			}
		}
		
		// Check the plugin views folder
		if( is_dir( $plugin_dir ) ) {
			$files += (array) self::scandir( $plugin_dir, $type, $depth );
			// Remove the admin view
			unset( $files['admin.php'] );
		}
		
		return $files;
	}
	
	/**
	 * Scans a directory for files of a certain extension.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * Based on the function of the same name in wp-includes/class-wp-theme.php
	 *
	 * @param string $path Absolute path to search.
	 * @param mixed  Array of extensions to find, string of a single extension, or null for all extensions.
	 * @param int $depth How deep to search for files. Optional, defaults to a flat scan (0 depth). -1 depth is infinite.
	 * @param string $relative_path The basename of the absolute path. Used to control the returned path
	 * 	for the found files, particularly when this function recurses to lower depths.
	 */
	private static function scandir( $path, $extensions = null, $depth = 0, $relative_path = '' ) {
		if ( ! is_dir( $path ) )
			return false;

		if ( $extensions ) {
			$extensions = (array) $extensions;
			$_extensions = implode( '|', $extensions );
		}

		$relative_path = trailingslashit( $relative_path );
		if ( '/' == $relative_path )
			$relative_path = '';

		$results = scandir( $path );
		$files = array();

		foreach ( $results as $result ) {
			if ( '.' == $result[0] )
				continue;
			if ( is_dir( $path . '/' . $result ) ) {
				if ( ! $depth || 'CVS' == $result )
					continue;
				$found = self::scandir( $path . '/' . $result, $extensions, $depth - 1 , $relative_path . $result );
				$files = array_merge_recursive( $files, $found );
			} elseif ( ! $extensions || preg_match( '~\.(' . $_extensions . ')$~', $result ) ) {
				$files[ $relative_path . $result ] = $path . '/' . $result;
			}
		}

		return $files;
	}
	

} // class bb_page_hover_box_widget


/**
 * Initialize the widget on widgets_init
 */
add_action( 'widgets_init', create_function( '', 'register_widget("bb_page_hover_box_widget");' ) );


function bb_phb_excerpt($post_id = null, $url = null, $length = 35, $more = '...', $echo = false){
	//prar($post_id);
	if($post_id) {
		$post = get_post($post_id); //Gets post ID
		
	} elseif( $url ) {
		$post_id = url_to_postid( $url );
		$post = get_post($post_id);
	}
	$bbphb_excerpt = get_post_meta( $post_id, 'page-hover-box-excerpt', true );
	
	if( $bbphb_excerpt ) {
		//prar($bbphb_excerpt);
		$excerpt_length = $length; //Sets excerpt length by word count
		$bbphb_excerpt = strip_tags(strip_shortcodes($bbphb_excerpt)); //Strips tags and images
		$words = explode(' ', $bbphb_excerpt, $excerpt_length + 1);

		if(count($words) > $excerpt_length) :
			array_pop($words);
			array_push($words, $more);
			$bbphb_excerpt = implode(' ', $words);
		endif;
		$the_excerpt = $bbphb_excerpt;
	} else {
		$the_excerpt = bb_phb_excerpt_from_post( $post_id, $length, false, $more );
	}

	if($echo) {
		echo apply_filters('the_content', $the_excerpt);
	} else {
	    return $the_excerpt;
	}
}

function bb_phb_excerpt_from_post( $id = null, $excerpt_length = 55, $echo = true, $excerpt_more = '...' ) {

	//prar($id);
    if($id) {
		$post = get_post($id);
		
		$title = get_the_title($post->ID);  //prar($title);
		if( $post->post_excerpt ) {
			$excerpt = $post->post_excerpt;
		} else {
			$excerpt = $post->post_content;
		}
		
		if($title == $excerpt) $excerpt = $post->post_content;
			 
		$excerpt = strip_shortcodes( $excerpt );
		//$excerpt = wp_strip_all_tags( $excerpt ); prar($excerpt);
		$excerpt = strip_tags( strip_shortcodes( $excerpt ) ); //Strips tags, images and other shortcodes
		//prar($excerpt);
		   

		$words = preg_split("/[\n\r\t ]+/", $excerpt, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$excerpt = implode(' ', $words);
			$excerpt = $excerpt . $excerpt_more;
		} else {
			$excerpt = implode(' ', $words);
		}
		
		if($echo) {
			echo apply_filters('the_content', $excerpt);
		} else {
			return $excerpt;
		}
	}
}

function phb_image($post_id, $thumbsize, $img_attr, $image_override = null) {

		//check for override set on page/post
		if( !$image_override ) $image_override = get_post_meta( $post_id, 'page-hover-box-image', true ); //prar($image_override);
		
		//set default img class
		$classes = ( isset( $img_attr['class'] ) ? $img_attr['class'] : 'bb-phb__img' );
		
		//If image ovverride, get id
		if( $image_override ) {
			$image_id = bb_phb_get_attachment_id_from_url ( $image_override );
			$image = wp_get_attachment_image( $image_id, $thumbsize, false,  $img_attr);
		} else {
			$image = get_the_post_thumbnail( $post_id, $thumbsize, $img_attr );
		}
		return $image;
}

function bb_phb_get_attachment_id_from_url( $attachment_url = '' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}

?>