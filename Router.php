<?php

namespace Kec\Smart;

use Brain\Cortex\Route\RouteCollectionInterface;
use Brain\Cortex\Router\MatchingResult;
use Brain\Cortex\Route\QueryRoute;

class Router {
	use Singleton;

	protected function init() {
		add_action( 'cortex.routes', [ $this, 'latest_posts' ] );
		add_action( 'cortex.matched', [ $this, 'body_classes' ] );
	}

	/**
	 * Add latest posts custom route
	 *
	 * @param RouteCollectionInterface $routes
	 */
	public function latest_posts( RouteCollectionInterface $routes ) {
		$routes->addRoute( new QueryRoute(
			'{type:[a-z]+}/latest',
			function ( array $matches ) {
				return [
					'post_type'      => $matches['type'],
					'posts_per_page' => 5,
					'orderby'        => 'date',
					'order'          => 'ASC',
				];
			}
		) );
	}

	/**
	 * Body classes based on Router info
	 *
	 * @param MatchingResult $results
	 */
	public function body_classes( MatchingResult $results ) {

		$template      = $results->template();
		$customClasses = [];
		if ( $template ) {
			$customClasses[] = $template;
		}

		add_filter( 'body_class', function ( $classes ) use ( $customClasses ) {
			return array_merge( $classes, $customClasses );
		} );

	}
}
