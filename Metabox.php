<?php

namespace Kec\Smart;

use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\config;

class Metabox {
	use Singleton;

	/**
	 * @var FieldsBuilder;
	 */
	protected $builder;

	/**
	 * @see https://www.advancedcustomfields.com/resources/register-fields-via-php/#group-settings
	 */
	protected function init() {
		$this->builder = new FieldsBuilder( 'smart_settings', [ 'title' => esc_attr_x( 'KEC Smart Settings', 'acf fields', 'smart' ) ] );
		$this->builder
			->setLocation( 'post_type', '==', 'page' )
			->or( 'post_type', '==', 'post' );

		/** Initialize ACF Builder */
		add_action( 'acf/init', function () {
			$pattern = apply_filters( 'smart/acf_fields_source', config( 'theme.dir' ) . '/app/fields/*.php' );

			collect( glob( $pattern, GLOB_BRACE ) )->map( function ( $field ) {
				return require_once( $field );
			} );

			if ( \function_exists( 'acf_add_local_field_group' ) ) {
				acf_add_local_field_group( Metabox::get_instance()->build() );
			}

		}, 12 );

		/** Add our color palette to ACF */
		add_action( 'acf/input/admin_footer', function () {
			?>
            <script type="text/javascript">
                (function ($) {

                    acf.add_filter('color_picker_args', function (args, $field) {

                        // add the hexadecimal codes here for the colors you want to appear as swatches
                        args.palettes = <?php echo wp_json_encode( config( 'colors.palette' ) ); ?>;

                        // return colors
                        return args;

                    });

                })(jQuery);
            </script>
			<?php
		} );

		/** Loop through post types and add acf fields to rest api */
		add_action( 'rest_api_init', [ __CLASS__, 'acf2api_post_types' ], 99 );

		/** Loop through taxonomies and add acf fields to rest api */
		add_action( 'rest_api_init', [ __CLASS__, 'acf2api_terms' ], 99 );
	}

	/**
	 * @param $title
	 * @param $args
	 *
	 * @return FieldsBuilder
	 * @throws \StoutLogic\AcfBuilder\FieldNameCollisionException if name already exists.
	 */
	public function addTab( $title, array $args = [] ): FieldsBuilder {
		$this->builder->addTab( $title, array_merge( [ 'placement' => 'left' ], $args ) );

		return $this->builder;
	}

	/**
	 * @return array
	 */
	public function build(): array {
		return $this->builder->build();
	}

	public static function acf2api_post_types() {
		global $wp_post_types;

		$post_types = array_keys( $wp_post_types );

		collect( $post_types )->map( function ( $post_type ) {
			add_filter( 'rest_prepare_' . $post_type,
				/**
				 * Filters the post data for a response.
				 *
				 * @param \WP_REST_Response $data    The response object.
				 * @param \WP_Post          $post    The original Post object.
				 * @param \WP_REST_Request  $request Request used to generate the response.
				 *
				 * @return \WP_REST_Response
				 */
				function ( $data, $post, $request ) {
					// Get the response data
					$response_data = $data->get_data();

					// Bail early if there's an error
					if ( $request['context'] !== 'view' || is_wp_error( $data ) ) {
						return $data;
					}

					// Get all fields
					$fields = get_fields( $post->ID );

					// If we have fields...
					if ( $fields ) {
						// Loop through them...
						foreach ( $fields as $field_name => $value ) {
							// Set the meta
							$response_data[ $field_name ] = $value;
						}
					}

					// Commit the API result var to the API endpoint
					$data->set_data( $response_data );

					return $data;
				}, 10, 3 );
		} );
	}

	public static function acf2api_terms() {

		$taxonomies = array_keys( get_taxonomies() );

		collect( $taxonomies )->map( function ( $taxonomy ) {
			add_filter( 'rest_prepare_' . $taxonomy,
				/**
				 * Filters a term item returned from the API.
				 *
				 * @param \WP_REST_Response $data    The response object.
				 * @param object            $term    The original term object.
				 * @param \WP_REST_Request  $request Request used to generate the response.
				 *
				 * @return \WP_REST_Response
				 */
				function ( $data, $term, $request ) {
					// Get the response data
					$response_data = $data->get_data();

					// Bail early if there's an error
					if ( $request['context'] !== 'view' || is_wp_error( $data ) ) {
						return $data;
					}

					// Get all fields
					$fields = get_fields( 'term_' . $term->term_id );

					if ( $fields ) {
						foreach ( $fields as $field_name => $value ) {
							$response_data[ $field_name ] = $value;
						}
					}

					// Commit the API result var to the API endpoint
					$data->set_data( $response_data );

					return $data;
				}, 10, 3 );
		} );
	}

	/**
	 * @return array
	 */
	public static function library(): array {
		$templates     = [ esc_html_x( 'Select a Template', 'acf fields', 'smart' ) ];
		$get_templates = get_posts( [ 'post_type' => 'smart_library', 'numberposts' => - 1, 'post_status' => 'publish' ] );

		if ( ! empty ( $get_templates ) ) {
			foreach ( $get_templates as $template ) {
				$templates[ $template->ID ] = $template->post_title;
			}
		}

		return $templates;
	}

	/**
	 * @return array
	 */
	public static function title_styles(): array {
		return apply_filters( 'smart/title_styles', [
			''                 => esc_html_x( 'Default', 'acf fields', 'smart' ),
			'default'          => esc_html_x( 'Default Style', 'acf fields', 'smart' ),
			'centered'         => esc_html_x( 'Centered', 'acf fields', 'smart' ),
			'centered-minimal' => esc_html_x( 'Centered Minimal', 'acf fields', 'smart' ),
			'background-image' => esc_html_x( 'Background Image', 'acf fields', 'smart' ),
			'solid-color'      => esc_html_x( 'Solid Color and White Text', 'acf fields', 'smart' ),
		] );
	}

	/**
	 * @return array
	 */
	public static function widget_areas(): array {
		global $wp_registered_sidebars;

		$widgets_areas    = [ esc_html_x( 'Default', 'acf fields', 'smart' ) ];
		$get_widget_areas = $wp_registered_sidebars;
		if ( ! empty( $get_widget_areas ) ) {
			foreach ( $get_widget_areas as $widget_area ) {
				$name = $widget_area['name'] ?? '';
				$id   = $widget_area['id'] ?? '';
				if ( $name && $id ) {
					$widgets_areas[ $id ] = $name;
				}
			}
		}

		return $widgets_areas;
	}
}
