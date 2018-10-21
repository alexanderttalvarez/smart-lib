<?php

namespace Kec\Smart;

class ShortCodes {
	use Singleton;

	protected function init() {
		add_shortcode( 'smart_date', [ __CLASS__, 'date' ] );
	}

	/**
	 * Return full year
	 *
	 * @param array $atts Shortcode Attributes.
	 *
	 * @return string
	 */
	public static function date( $atts ) : string {

		// Set attributes
		shortcode_atts( [
			'year' => '',
		], $atts );

		// Var
		$date = '';
		$year = $atts['year'] ?? '';

		if ( '' !== $year ) {
			$date .= $year . ' - ';
		}

		$date .= date( 'Y' );

		return esc_attr( $date );

	}
}
