<?php
/**
 * Module class
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Elementor\Modules\NinjaForms;

use Kec\Smart\Elementor\Modules\Base;

class Module extends Base {

    /**
     * {@inheritdoc}
     */
    public function get_widgets() {
        return [
            'NinjaForms',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function get_name() {
        return 'smart-ninja-forms';
    }
}
