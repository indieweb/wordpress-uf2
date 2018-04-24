<?php


class UF2_Settings {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'admin_settings' ), 11 );
	}

	public function admin_menu() {
		// If the IndieWeb Plugin is installed use its menu.
		if ( class_exists( 'IndieWeb_Plugin' ) ) {
			add_submenu_page(
				'indieweb',
				__( 'Microformats', 'wp-uf2' ), // page title
				__( 'Microfomats', 'wp-uf2' ), // menu title
				'manage_options', // access capability
				'uf2',
				array( $this, 'uf2_options' )
			);
		} else {
			add_options_page(
				'',
				'Microformats',
				'manage_options',
				'uf2',
				array( $this, 'uf2_options' )
			);
		}
	}

	public function register_settings() {
		$section = 'uf2';

		register_setting(
			$section,
			'uf2_author',
			array(
				'type'         => 'boolean',
				'description'  => __( 'Attempt to Markup Author', 'wp-uf2' ),
				'show_in_rest' => true,
				'default'      => 1,
			)
		);

		register_setting(
			$section,
			'uf2_media',
			array(
				'type'         => 'boolean',
				'description'  => __( 'Attempt to add Photo Property to Media', 'wp-uf2' ),
				'show_in_rest' => true,
				'default'      => 1,
			)
		);

	}

	public function admin_settings() {
		$page = 'uf2';
		// Settings Section
		$section = 'uf2';

		add_settings_section(
			$section, // ID used to identify this section and with which to register options
			__( 'General Settings', 'wp-uf2' ), // Title to be displayed on the administration page
			array( $this, 'uf2_options_callback' ), // Callback used to render the description of the section
			$page // Page on which to add this section of options
		);

		add_settings_field(
			'uf2_author', // ID used to identify the field throughout the theme
			__( 'Author', 'wp-uf2' ), // The label to the left of the option interface element
			array( $this, 'checkbox_callback' ),   // The name of the function responsible for rendering the option interface
			$page, // The page on which this option will be displayed
			$section, // The name of the section to which this field belongs
			array( // The array of arguments to pass to the callback. In this case, just a description.
				'name'        => 'uf2_author',
				'description' => __( 'Attempt to mark up author', 'wp-uf2' ),
			)
		);

		add_settings_field(
			'uf2_media', // ID used to identify the field throughout the theme
			__( 'Media', 'wp-uf2' ), // The label to the left of the option interface element
			array( $this, 'checkbox_callback' ),   // The name of the function responsible for rendering the option interface
			$page, // The page on which this option will be displayed
			$section, // The name of the section to which this field belongs
			array( // The array of arguments to pass to the callback. In this case, just a description.
				'name'        => 'uf2_media',
				'description' => __( 'Attempt to add photo property to all images and avatars', 'wp-uf2' ),
			)
		);

	}

	public function uf2_options_callback() {
	}

	public function uf2_options() {
?>
	<h1><?php _e( 'Microformats 2', 'wp-uf2' ); ?></h1>
	<p> <?php _e( 'The Microformats 2 plugin attempts to add microformats to WordPress themes using WordPress hooks and filters. This does not work as well as having microformats built into your theme.You can check how your page is marked up by visiting <a href="http://indiewebify.me">Indiewebify.me</a>', 'wp-uf2' ); ?> </p>
	
	<div class="wrap">
	<form method="post" action="options.php">
<?php settings_fields( 'uf2' ); ?>
<?php do_settings_sections( 'uf2' ); ?>
<?php submit_button(); ?>

</form></div>
<?php
	}

	public function checkbox_callback( array $args ) {
		$option   = get_option( $args['name'] );
		$disabled = isset( $args['disabled'] ) ? $args['disabled'] : false;

		$checked = $option;

		echo "<input name='" . esc_html( $args['name'] ) . "' type='hidden' value='0' />";
		echo "<input name='" . esc_html( $args['name'] ) . "' type='checkbox' value='1' " . checked( $checked, 1, false ) . ( $disabled ? ' disabled ' : ' ' ) . '/> ';

		if ( array_key_exists( 'description', $args ) ) {
			echo '<label for="' . esc_html( $args['name'] ) . '">' . esc_html( $args['description'] ) . '</label>';
		}
	}

}
