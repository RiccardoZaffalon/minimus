<?php
/**
 * minimus Theme Customizer
 *
 * @package minimus
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function minimus_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/* Boxed Layout */
	$wp_customize->add_section('boxed_layout_section' , array(
	    'title'     => __('Website layout', 'minimus'),
	    'priority'  => 30
	));
	$wp_customize->add_setting('boxed_layout', array(
	    //'default'    	=> '0',
	    'transport'		=> 'refresh'
	));
	$wp_customize->add_control(
	    new WP_Customize_Control(
	        $wp_customize,
	        'boxed_layout',
	        array(
	            'label'     => __('Toggle boxed layout', 'minimus'),
	            'priority'  => 30,
	            'section'   => 'boxed_layout_section',
	            'settings'  => 'boxed_layout',
	            'type'      => 'checkbox',
	        )
	    )
	);

	/* Blog Description */
	$wp_customize->add_setting('blogdescription_show', array(
	    'default'    	=> '1',
	    'transport'		=> 'refresh'
	));
	$wp_customize->add_control(
	    new WP_Customize_Control(
	        $wp_customize,
	        'blogdescription_show',
	        array(
	            'label'     => __('Display Tagline', 'minimus'),
	            'priority'  => 30,
	            'section'   => 'title_tagline',
	            'settings'  => 'blogdescription_show',
	            'type'      => 'checkbox',
	        )
	    )
	);
}
add_action( 'customize_register', 'minimus_customize_register' );

function minimus_boxed_view() {
    if (get_theme_mod('boxed_layout')): ?>
    <style>
    	body > #page {
			margin: 0.4rem auto 0;
			max-width: 960px;
		}
    </style>
    <?php endif;
}
add_action( 'wp_head', 'minimus_boxed_view');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function minimus_customize_preview_js() {
	wp_enqueue_script( 'minimus_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'minimus_customize_preview_js' );
