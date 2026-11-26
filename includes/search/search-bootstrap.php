
<?php
/**
 * Vestis Elites Search - foundation bootstrap.
 *
 * Loads the standalone search foundation modules in dependency order.
 * This file is intentionally not included by the main plugin yet.
 * It does not install database tables, schedule jobs, or run searches.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 've_search_load_foundation' ) ) {

    /**
     * Load the search foundation after verifying every required module exists.
     *
     * @return bool|WP_Error True when loaded, otherwise a descriptive error.
     */
    function ve_search_load_foundation() {

        $modules = array(
            'search-config.php',
            'search-database.php',
            'search-classification.php',
            'search-discovery.php',
            'search-index-records.php',
        );

        $module_paths = array();

        /* Preflight all files before loading any module. */
        foreach ( $modules as $module ) {

            $path = __DIR__ . '/' . $module;

            if ( ! is_file( $path ) || ! is_readable( $path ) ) {
                return new WP_Error(
                    've_search_foundation_module_missing',
                    sprintf(
                        'The search foundation could not load because %s is missing or unreadable.',
                        $module
                    )
                );
            }

            $module_paths[] = $path;
        }

        /* Load dependencies in their required order. */
        foreach ( $module_paths as $path ) {
            require_once $path;
        }

        /* Confirm the central configuration API is available. */
        if ( ! function_exists( 've_search_get_config' ) ) {
            return new WP_Error(
                've_search_foundation_config_unavailable',
                'The search configuration module did not initialise correctly.'
            );
        }

        if ( ! defined( 'VE_SEARCH_FOUNDATION_LOADED' ) ) {
            define( 'VE_SEARCH_FOUNDATION_LOADED', true );
        }

        return true;
    }
}

return ve_search_load_foundation();
