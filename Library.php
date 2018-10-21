<?php

namespace Kec\Smart;

use Elementor\Plugin;

class Library {
	use Singleton;

	/**
	 * Return element array
	 *
	 * @return array
	 */
	public static function options(): array {

		// Return library templates array
		$templates     = [ '&mdash; ' . esc_html__( 'Select', 'smart' ) . ' &mdash;' ];
		$get_templates = get_posts(
			[
				'post_type'   => 'smart_library',
				'numberposts' => - 1,
				'post_status' => 'publish',
			]
		);

		if ( ! empty( $get_templates ) ) {
			foreach ( $get_templates as $template ) {
				$templates[ $template->ID ] = $template->post_title;
			}
		}

		return $templates;
	}

	/**
	 * Start things up
	 */
	private function init() {
		add_action( 'init', [ $this, 'library_post_type' ] );

		if ( is_admin() ) {
			add_action( 'admin_menu', [ $this, 'add_page' ], 1 );
			add_filter( 'smart/main_metaboxes_post_types', [ $this, 'add_metabox' ], 20 );
			add_action( 'add_meta_boxes_smart_library', [ $this, 'shortcode_metabox' ] );
			add_filter( 'manage_edit-smart_library_columns', [ $this, 'edit_columns' ] );
			add_action( 'manage_smart_library_posts_custom_column', [ $this, 'custom_columns' ], 10, 2 );
		}

		add_action( 'template_redirect', [ $this, 'block_template_frontend' ] );

		add_shortcode( 'smart_library', [ $this, 'short_code' ] );
	}

	/**
	 * Register library post type
	 *
	 * @since 1.0.0
	 */
	public static function library_post_type() {
		// Name
		$name = esc_html__( 'Theme Library', 'smart' );
		$name = apply_filters( 'smart/library_text', $name );

		// Register the post type
		register_post_type(
			'smart_library',
			apply_filters(
				'smart/library_args',
				[
					'labels'              => [
						'name'               => $name,
						'singular_name'      => esc_html__( 'Template', 'smart' ),
						'add_new'            => esc_html__( 'Add New', 'smart' ),
						'add_new_item'       => esc_html__( 'Add New Template', 'smart' ),
						'edit_item'          => esc_html__( 'Edit Template', 'smart' ),
						'new_item'           => esc_html__( 'Add New Template', 'smart' ),
						'view_item'          => esc_html__( 'View Template', 'smart' ),
						'search_items'       => esc_html__( 'Search Template', 'smart' ),
						'not_found'          => esc_html__( 'No Templates Found', 'smart' ),
						'not_found_in_trash' => esc_html__( 'No Templates Found In Trash', 'smart' ),
						'menu_name'          => esc_html__( 'Library', 'smart' ),
					],
					'public'              => true,
					'hierarchical'        => false,
					'show_ui'             => true,
					'show_in_menu'        => false,
					'show_in_nav_menus'   => false,
					'can_export'          => true,
					'exclude_from_search' => true,
					'capability_type'     => 'post',
					'rewrite'             => false,
					'supports'            => [ 'title', 'editor', 'thumbnail', 'author', 'elementor' ],
				]
			)
		);
	}

	/**
	 * Add sub menu page
	 *
	 * @since 1.0.0
	 */
	public function add_page() {

		// Name
		$name = esc_html__( 'Template Library', 'smart' );
		$name = apply_filters( 'smart/library_text', $name );

		add_theme_page(
			esc_html__( 'Template Library', 'smart' ),
			'<span style="color:#f18500;">' . $name . '</span>',
			'edit_pages',
			'edit.php?post_type=smart_library'
		);
	}

	/**
	 * Add the Settings metabox into the custom post type
	 *
	 * @since 1.0.0
	 *
	 * @param array $types Post Types array.
	 *
	 * @return array
	 */
	public static function add_metabox( array $types ): array {
		$types[] = 'smart_library';

		return $types;
	}

	/**
	 * Add shorcode metabox
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_Post $post Post object.
	 */
	public static function display_metabox( $post ) {
		?>
        <input type="text" class="widefat" value='[almirall_library id="<?php echo $post->ID; // WPCS: XSS OK ?>"]' readonly/>
		<?php
	}

	/**
	 * Add shortcode metabox
	 * The $this variable is not used to get the display_meta_box() function because it doesn't work on older PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_Post $post Post object.
	 */
	public static function shortcode_metabox( $post ) {

		add_meta_box(
			'library-shortcode-metabox',
			esc_html__( 'Shortcode', 'smart' ),
			[ __CLASS__, 'display_metabox' ],
			'smart_library',
			'side',
			'low'
		);

	}

	/**
	 * Make the post type inaccessible
	 *
	 * @since 1.0.0
	 */
	public static function block_template_frontend() {
		if ( is_singular( 'smart_library' ) && ! self::is_current_user_can_edit() ) {
			wp_redirect( site_url(), 301 );
			die;
		}
	}

	/**
	 * If the current user can edit
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return bool
	 */
	public static function is_current_user_can_edit( $post_id = 0 ): bool {
		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		if ( 'trash' === get_post_status( $post_id ) ) {
			return false;
		}

		$post_type_object = get_post_type_object( get_post_type( $post_id ) );
		if ( $post_type_object === null ) {
			return false;
		}

		if ( ! isset( $post_type_object->cap->edit_post ) ) {
			return false;
		}

		$edit_cap = $post_type_object->cap->edit_post;
		if ( ! current_user_can( $edit_cap, $post_id ) ) {
			return false;
		}

		if ( get_option( 'page_for_posts' ) === $post_id ) {
			return false;
		}

		return true;
	}

	/**
	 * Add the shortcode column
	 *
	 * @since 1.0.0
	 *
	 * @param array $columns Columns array.
	 *
	 * @return array
	 */
	public static function edit_columns( $columns ): array {
		$columns['smart_library_shortcode'] = esc_html__( 'Shortcode', 'smart' );

		return $columns;
	}

	/**
	 * Display the shortcode column
	 *
	 * @since 1.0.0
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 */
	public static function custom_columns( $column, $post_id ) {

		switch ( $column ) {
			case 'smart_library_shortcode':
				// Display the shortcode in the column view
				$shortcode = esc_attr( sprintf( '[smart_library id="%d"]', $post_id ) );
				printf( '<input type="text" value="%s" readonly style="min-width: 200px;" />', $shortcode ); // WPCS: XSS OK
				break;
		}
	}

	/**
	 * Registers the function as a shortcode
	 *
	 * @param array $atts    Shortcode attributes.
	 * @param null  $content Shortcode content.
	 *
	 * @return string
	 */
	public function short_code( $atts, $content = null ): string {

		// Attributes
		$atts = shortcode_atts(
			[
				'id' => '',
			], $atts, 'smart_library'
		);

		ob_start();

		if ( $atts['id'] ) {

			// Check if the template is created with Elementor
			$elementor = get_post_meta( $atts['id'], '_elementor_edit_mode', true );

			// If Elementor
			if ( $elementor && Elementor::is_active() ) {

				echo Plugin::instance()->frontend->get_builder_content_for_display( $atts['id'] ); // WPCS: XSS OK

			} else {

				// Get template content
				$content = $atts['id'];

				if ( ! empty( $content ) ) {

					$template = get_post( $content );

					if ( $template && ! is_wp_error( $template ) ) {
						$content = $template->post_content;
					}
				}

				// Display template content
				echo do_shortcode( $content ); // WPCS: XSS OK

			}
		}

		return ob_get_clean();
	}

}
