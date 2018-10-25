<?php
/**
 * WPML class
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Elementor\Compatibility;

use Kec\Smart\Singleton;

class WPML {
    use Singleton;

    protected function init() {

        // WPML String Translation plugin exist check
        if ( is_wpml_string_translation_active() ) {
            add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'add_translatable_nodes' ] );
        }
    }

    /**
     * Adds additional translatable nodes to WPML
     *
     * @since 1.0.16
     *
     * @param  array $nodes_to_translate WPML nodes to translate
     *
     * @return array   $nodes_to_translate Updated nodes
     */
    public function add_translatable_nodes( $nodes_to_translate ) {

        $nodes_to_translate['smart-acf'] = [
            'conditions' => [ 'widgetType' => 'smart-acf' ],
            'fields'     => [
                [
                    'field'       => 'field_name',
                    'type'        => _x( 'ACF Field Name', 'elementor', 'smart' ),
                    'editor_type' => 'LINE',
                ],
                [
                    'field'       => 'link_text',
                    'type'        => _x( 'ACF Link Text', 'elementor', 'smart' ),
                    'editor_type' => 'LINE',
                ],
                [
                    'field'       => 'field_label',
                    'type'        => _x( 'ACF Label', 'elementor', 'smart' ),
                    'editor_type' => 'LINE',
                ],
            ],
        ];

    }
}
