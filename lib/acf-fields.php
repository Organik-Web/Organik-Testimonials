<?php

/**
 * Main Organik_Testimonials_ACF_Fields class
 */
class Organik_Testimonials_ACF_Fields {

	/**
     * Constructor function
     */
	public function __construct() {

		// Hook into the 'init' action to add the ACF Fields on to CPT
		add_filter( 'init', array( $this, 'orgnk_testimonials_cpt_acf_fields' ) );
	}

	/**
	 * orgnk_testimonials_cpt_acf_fields()
	 * Manually insert ACF fields for this CPT
	 */
	public function orgnk_testimonials_cpt_acf_fields() {

		// Return early if ACF isn't active
		if ( ! class_exists( 'ACF' ) || ! function_exists( 'acf_add_local_field_group' ) || ! defined( 'ORGNK_TESTIMONIALS_CPT_NAME' )  || ! is_admin() ) return;

        // Field Group - Single Testimonial Settings
        acf_add_local_field_group(array(
            'key'       => 'group_5f8803f6a9a3e',
            'title'     => 'Single Testimonial Settings',
            'fields'    => array(

                // Field - Testimonial Position  - Text
                array(
                    'key'               => 'field_5f8804025c310',
                    'label'             => 'Position',
                    'name'              => 'testimonial_position',
                    'type'              => 'text',
                    'instructions'      => 'Enter the this person\'s position or title.',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width'             => '',
                        'class'             => '',
                        'id'                => '',
                    ),
                    'default_value'     => '',
                    'placeholder'       => '',
                    'prepend'           => '',
                    'append'            => '',
                    'maxlength'         => '',
                ),

                // Field - Testimonial Company - Text
                array(
                    'key'               => 'field_5f8804265c311',
                    'label'             => 'Company',
                    'name'              => 'testimonial_company',
                    'type'              => 'text',
                    'instructions'      => 'Enter the organisation or body that this person represents.',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width'             => '',
                        'class'             => '',
                        'id'                => '',
                    ),
                    'default_value'     => '',
                    'placeholder'       => '',
                    'prepend'           => '',
                    'append'            => '',
                    'maxlength'         => '',
                ),
            ),

            // Location Rules - Single Testimonial
            'location'                  => array(
                array(
                    array(
                        'param'             => 'post_type',
                        'operator'          => '==',
                        'value'             => ORGNK_TESTIMONIALS_CPT_NAME,
                    ),
                ),
            ),
            'menu_order'                => 0,
            'position'                  => 'acf_after_title',
            'style'                     => 'default',
            'label_placement'           => 'left',
            'instruction_placement'     => 'label',
            'hide_on_screen'            => '',
            'active'                    => true,
            'description'               => '',
        ));
    }
}