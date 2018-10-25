<?php
/**
 * Module class
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Elementor\Modules\GravityForms;

use Kec\Smart\Elementor\Modules\Base;

class Module extends Base {

    /**
     * {@inheritdoc}
     */
    public function get_widgets() {
        return [
            'GravityForms',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function get_name() {
        return 'smart-gravity-forms';
    }
}
