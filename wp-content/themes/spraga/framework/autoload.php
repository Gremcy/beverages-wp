<?php if(!defined('ABSPATH')){ exit(); }

/**
 * Register the autoloader
 */
spl_autoload_register( function( $class ) {
	$namespace_prefix = 'PS';

	$len = strlen( $namespace_prefix );

	$relative_class = strtolower( substr( $class, $len ) );
	$relative_class = str_replace( '\\', '/', $relative_class );

	$file = __DIR__ . strtolower( $relative_class . '.class.php' );

	if ( file_exists( $file ) ) {
		require $file;
	}
} );
