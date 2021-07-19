<?php
/**
 * Define constant variables
 */
define( 'ORGNK_TESTIMONIALS_CPT_NAME', 'testimonial' );
define( 'ORGNK_TESTIMONIALS_SINGLE_NAME', 'Testimonial' );
define( 'ORGNK_TESTIMONIALS_PLURAL_NAME', 'Testimonials' );
define( 'ORGNK_TESTIMONIALS_SHORTCODE_NAME', 'testimonials' );

/**
 * Main Organik_Testimonials class
 */
class Organik_Testimonials {

	/**
     * The single instance of Organik_Testimonials
     */
	private static $instance = null;

	/**
     * Main class instance
     * Ensures only one instance of this class is loaded or can be loaded
     */
    public static function instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self;
        }
        return self::$instance;
	}

	/**
     * Constructor function
     */
	public function __construct() {

		// Register ACF Fields
		new Organik_Testimonials_ACF_Fields();

		// Define the CPT rewrite variable on init - required here because we need to use get_permalink() which isn't available when plugins are initialised
		add_action( 'init', array( $this, 'orgnk_testimonials_cpt_rewrite_slug' ) );

        // Hook into the 'init' action to add the Custom Post Type
		add_action( 'init', array( $this, 'orgnk_testimonials_cpt_register' ) );

        // Change the title placeholder
		add_filter( 'enter_title_here', array( $this, 'orgnk_testimonials_cpt_title_placeholder' ) );

		// Switch the default editor to use Teeny MCE
		add_filter( 'wp_editor_settings', array( $this, 'orgnk_testimonials_cpt_enable_teeny_editor' ) );

		// Remove unneccessary buttons from the Teeny MCE
		add_filter( 'teeny_mce_buttons', array( $this, 'orgnk_testimonials_cpt_remove_teeny_editor_buttons' ) );

		// Add 'about' page to admin menu
		add_action( 'admin_menu', array( $this, 'orgnk_testimonials_cpt_admin_about_page' ) );

		// Add post meta to the admin list view for this CPT
		add_filter( 'manage_' . ORGNK_TESTIMONIALS_CPT_NAME . '_posts_columns', array( $this, 'orgnk_testimonials_cpt_admin_table_column' ) );
		add_action( 'manage_' . ORGNK_TESTIMONIALS_CPT_NAME . '_posts_custom_column', array( $this, 'orgnk_testimonials_cpt_admin_table_content' ), 10, 2 );

		// Register shortcode
		add_shortcode( ORGNK_TESTIMONIALS_SHORTCODE_NAME, array( $this, 'orgnk_testimonials_cpt_shortcode' ) );
	}

	/**
	 * orgnk_testimonials_cpt_register()
	 * Register the custom post type
	 */
	public function orgnk_testimonials_cpt_register() {

		$labels = array(
			'name'                      	=> ORGNK_TESTIMONIALS_PLURAL_NAME,
			'singular_name'             	=> ORGNK_TESTIMONIALS_SINGLE_NAME,
			'menu_name'                 	=> ORGNK_TESTIMONIALS_PLURAL_NAME,
			'name_admin_bar'            	=> ORGNK_TESTIMONIALS_SINGLE_NAME,
			'archives'              		=> 'Testimonial archives',
			'attributes'            		=> 'Testimonial Attributes',
			'parent_item_colon'     		=> 'Parent testimonial:',
			'all_items'             		=> 'All testimonials',
			'add_new_item'          		=> 'Add new testimonial',
			'add_new'               		=> 'Add new testimonial',
			'new_item'              		=> 'New testimonial',
			'edit_item'             		=> 'Edit testimonial',
			'update_item'           		=> 'Update testimonial',
			'view_item'             		=> 'View testimonial',
			'view_items'            		=> 'View testimonials',
			'search_items'          		=> 'Search testimonial',
			'not_found'             		=> 'Not found',
			'not_found_in_trash'    		=> 'Not found in Trash',
			'featured_image'        		=> 'Featured Image',
			'set_featured_image'    		=> 'Set featured image',
			'remove_featured_image' 		=> 'Remove featured image',
			'use_featured_image'    		=> 'Use as featured image',
			'insert_into_item'      		=> 'Insert into testimonial',
			'uploaded_to_this_item' 		=> 'Uploaded to this testimonial',
			'items_list'            		=> 'Testimonials list',
			'items_list_navigation' 		=> 'Testimonials list navigation',
			'filter_items_list'     		=> 'Filter testimonials list'
		);

		$rewrite = array(
			'slug'                  		=> ORGNK_TESTIMONIALS_REWRITE_SLUG, // The slug for single posts
			'with_front'            		=> false,
			'pages'                 		=> true,
			'feeds'                 		=> false
		);

		$args = array(
			'label'                 		=> ORGNK_TESTIMONIALS_SINGLE_NAME,
			'description'           		=> 'Manage and display testimonials',
			'labels'                		=> $labels,
			'supports'              		=> array( 'title', 'editor', 'page-attributes' ),
			'taxonomies'            		=> array(),
			'hierarchical'          		=> false,
			'public'                		=> true,
			'show_ui'               		=> true,
			'show_in_menu'          		=> true,
			'menu_position'         		=> 25,
			'menu_icon'             		=> 'dashicons-format-quote',
			'show_in_admin_bar'     		=> true,
			'show_in_nav_menus'     		=> true,
			'can_export'            		=> true,
			'has_archive'           		=> false, // The slug for archive, bool toggle archive on/off
			'publicly_queryable'    		=> false, // Bool toggle single on/off
			'exclude_from_search'   		=> true,
			'capability_type'       		=> 'page',
			'rewrite'						=> $rewrite
		);
		register_post_type( ORGNK_TESTIMONIALS_CPT_NAME, $args );
	}

	/**
	 * orgnk_testimonials_cpt_rewrite_slug()
	 * Conditionally define the CPT archive permalink based on the pages for CPT functionality in Organik themes
	 * Includes a fallback string to use as the slug if the option isn't set
	 */
	public function orgnk_testimonials_cpt_rewrite_slug() {
		$default_slug = 'testimonials';
		$archive_page_id = get_option( 'page_for_' . ORGNK_TESTIMONIALS_CPT_NAME );
		$archive_page_slug = str_replace( home_url(), '', get_permalink( $archive_page_id ) );
		$archive_permalink = ( $archive_page_id ? $archive_page_slug : $default_slug );
		$archive_permalink = ltrim( $archive_permalink, '/' );
		$archive_permalink = rtrim( $archive_permalink, '/' );

		define( 'ORGNK_TESTIMONIALS_REWRITE_SLUG', $archive_permalink );
	}

	/**
	 * orgnk_testimonials_cpt_title_placeholder()
	 * Change CPT title placeholder on edit screen
	 */
	public function orgnk_testimonials_cpt_title_placeholder( $title ) {

		$screen = get_current_screen();

		if ( $screen && $screen->post_type == ORGNK_TESTIMONIALS_CPT_NAME ) {
			return 'Add person&#39s name';
		}
		return $title;
	}

	/**
	 * orgnk_testimonials_cpt_enable_teeny_editor()
	 * Convert the default editor to Teeny MCE for this CPT
	 */
	public function orgnk_testimonials_cpt_enable_teeny_editor( $settings ) {

		$screen = get_current_screen();

		if ( $screen && $screen->post_type == ORGNK_TESTIMONIALS_CPT_NAME ) {
			$settings['teeny'] = true;
			$settings['media_buttons'] = false;
		}

		return $settings;
	}

	/**
	 * orgnk_testimonials_cpt_remove_teeny_editor_buttons()
	 * Remove some options/buttons from the editor
	 */
	public function orgnk_testimonials_cpt_remove_teeny_editor_buttons( $buttons ) {

		$screen = get_current_screen();

		if ( $screen && $screen->post_type == ORGNK_TESTIMONIALS_CPT_NAME ) {
			$remove_buttons = array(
				'blockquote',
				'alignleft',
				'aligncenter',
				'alignright',
				'fullscreen'
			);

			foreach ( $buttons as $button_key => $button_value ) {
				if ( in_array( $button_value, $remove_buttons ) ) {
					unset( $buttons[ $button_key ] );
				}
			}
		}
		return $buttons;
	}

	/**
	 * orgnk_testimonials_cpt_admin_about_page()
	 * Add the CPT 'about' page to the admin menu
	 */
	public function orgnk_testimonials_cpt_admin_about_page() {
		add_submenu_page(
			'edit.php?post_type=' . ORGNK_TESTIMONIALS_CPT_NAME,
			'About ' . ORGNK_TESTIMONIALS_PLURAL_NAME,
			'About ' . ORGNK_TESTIMONIALS_PLURAL_NAME,
			'edit_pages',
			'about-' . ORGNK_TESTIMONIALS_CPT_NAME,
			array( $this, 'orgnk_testimonials_cpt_admin_about_page_content' )
		);
	}

	/**
	 * orgnk_testimonials_cpt_admin_about_page_content()
	 * The content for the CPT 'about' page in admin
	 */
	public function orgnk_testimonials_cpt_admin_about_page_content() {
		include_once plugin_dir_path( __FILE__ ) . '../lib/about.php';
	}

	/**
	 * orgnk_testimonials_cpt_admin_table_column()
	 * Register new column(s) in admin list view
	 */
	public function orgnk_testimonials_cpt_admin_table_column( $defaults ) {

		$new_order = array();

		foreach( $defaults as $key => $value ) {
			// When we find the date column, slip in the new column before it
			if ( $key == 'date' ) {
				$new_order['shortcode'] = 'Shortcode';
			}
			$new_order[$key] = $value;
		}

		return $new_order;
	}

	/**
	 * orgnk_testimonials_cpt_admin_table_content()
	 * Return the content for the new admin list view columns for each post
	 */
	public function orgnk_testimonials_cpt_admin_table_content( $column_name, $post_id ) {

		global $post;

		if ( $column_name == 'shortcode' ) {
			echo '[' . ORGNK_TESTIMONIALS_SHORTCODE_NAME . ' id="' . $post_id . '"]';
		}
	}

	/**
	 * orgnk_testimonials_cpt_shortcode()
	 * Shortcode to print testimonials
	 * Usage: [testimonials id='1, 2, 3']
	 */
	public function orgnk_testimonials_cpt_shortcode( $attributes ) {

		static $instance = 0;
		$instance++;

		$display_type = 'slider';

		// Setup the query arguments
		$args = array(
			'post_type'         	=> ORGNK_TESTIMONIALS_CPT_NAME,
			'post_status' 			=> 'publish',
			'orderby'           	=> 'menu_order',
			'order'             	=> 'ASC'
		);

		// Set the attributes that the user can supply to the shortcode
		$attribute = shortcode_atts( array(
			'id'      				=> NULL,
			'style'					=> 'slider'
		), $attributes );

		// If IDs are specified in the shortcode, conver the IDs into an array so we can add it to the query arguments
		if ( isset( $attribute['id'] ) ) {
			$post_ids = preg_replace('/\s+/', '', $attribute['id'] ); // Remove all whitespace
			$post_ids = explode( ',', $post_ids ); // Convert string to array by comma seperation
			$args['post__in'] = $post_ids;
		}

		// If the style attribute is set to list in the shortcode, then force the display type to be 'list'
		if ( isset( $attribute['style'] ) && $attribute['style'] === 'list' ) {
			$display_type = 'list';
		}

		// Finally, determine the number of posts to retrieve based on the final display type setting
		$args['posts_per_page'] = ( $display_type === 'slider' ) ? 8 : -1;

		// Run the query
		$testimonials_loop = new WP_Query( $args );

		// Once the query is run, if only 1 post was found, then we want to default to the 'list' style to avoid a slider with only one slide
		if ( $testimonials_loop->found_posts <= 1 ) {
			$display_type = 'list';
		}

		// Begin output
		ob_start();

		if ( file_exists( get_template_directory() . '/template-parts/shortcodes/shortcode-testimonials.php' ) ) {
			include ( get_template_directory() . '/template-parts/shortcodes/shortcode-testimonials.php' );
		}  else {
			include plugin_dir_path( __FILE__ ) . '../public/shortcode/shortcode.php';
		}

		return ob_get_clean();
	}
}
