<?php
/**
 * Module class
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Elementor\Modules\ContactForm;

use Kec\Smart\Elementor\Modules\Base;

class Module extends Base {

    /**
     * {@inheritdoc}
     */
    public function get_widgets() {
        return [
            'ContactForm',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function get_name() {
        return 'smart-contact-form-7';
    }
}
