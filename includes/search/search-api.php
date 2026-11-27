
<?php
/**
 * Vestis Elites Search - REST API.
 *
 * Provides public predictive and full-results search endpoints.
 * Uses the indexed search engine exclusively.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Generate a privacy-conscious identifier for rate limiting.
 *
 * Uses the direct remote address only. Forwarded headers are not trusted.
 *
 * @return string
 */
if ( ! function_exists( 've_search_api_get_client_key' ) ) {
    function ve_search_api_get_client_key() {

        $ip = isset( $_SERVER['REMOTE_ADDR'] )
            ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) )
            : 'unknown';

        $ip = filter_var( $ip, FILTER_VALIDATE_IP )
            ? $ip
            : 'unknown';

        return hash_hmac(
            'sha256',
            $ip,
            wp_salt( 'auth' )
        );
    }
}

/**
 * Enforce the configured search request limit.
 *
 * @return true|WP_Error
 */
if ( ! function_exists( 've_search_api_check_rate_limit' ) ) {
    function ve_search_api_check_rate_limit() {

        $config = ve_search_get_config();

        $maximum = isset( $config['security']['maximum_query_requests'] )
            ? absint( $config['security']['maximum_query_requests'] )
            : 30;

        $window = isset( $config['security']['request_window'] )
            ? absint( $config['security']['request_window'] )
            : 60;

        $maximum = max( 1, $maximum );
        $window  = max( 1, $window );

        $key = 've_search_rate_' . ve_search_api_get_client_key();

        $state = get_transient( $key );

        if ( ! is_array( $state ) ) {
            $state = array(
                'count'      => 0,
                'started_at' => time(),
            );
        }

        $started_at = isset( $state['started_at'] )
            ? absint( $state['started_at'] )
            : time();

        $count = isset( $state['count'] )
            ? absint( $state['count'] )
            : 0;

        $elapsed = time() - $started_at;

        if ( $elapsed >= $window ) {
            $count      = 0;
            $started_at = time();
        }

        if ( $count >= $maximum ) {

            $retry_after = max(
                1,
                $window - ( time() - $started_at )
            );

            return new WP_Error(
                've_search_rate_limit_exceeded',
                'Too many search requests. Please wait before searching again.',
                array(
                    'status'      => 429,
                    'retry_after' => $retry_after,
                )
            );
        }

        $state = array(
            'count'      => $count + 1,
            'started_at' => $started_at,
        );

        set_transient(
            $key,
            $state,
            $window
        );

        return true;
    }
}

/**
 * Convert search engine errors into safe REST responses.
 *
 * @param WP_Error $error Search engine error.
 * @return WP_Error
 */
if ( ! function_exists( 've_search_api_format_error' ) ) {
    function ve_search_api_format_error( $error ) {

        $code = $error->get_error_code();

        $status = 400;

        if ( in_array(
            $code,
            array(
                've_search_engine_index_missing',
                've_search_engine_database_missing',
                've_search_database_module_missing',
                've_search_config_missing',
            ),
            true
        ) ) {
            $status = 503;
        }

        return new WP_Error(
            $code,
            $error->get_error_message(),
            array(
                'status' => $status,
            )
        );
    }
}

/**
 * Execute a public search request.
 *
 * @param WP_REST_Request $request REST request.
 * @param bool            $predictive Predictive or full-results mode.
 * @return WP_REST_Response|WP_Error
 */
if ( ! function_exists( 've_search_api_handle_request' ) ) {
    function ve_search_api_handle_request( $request, $predictive = false ) {

        $rate_limit = ve_search_api_check_rate_limit();

        if ( is_wp_error( $rate_limit ) ) {
            return $rate_limit;
        }

        $query = $request->get_param( 'q' );

        if ( ! is_string( $query ) ) {
            return new WP_Error(
                've_search_api_query_missing',
                'A search query is required.',
                array( 'status' => 400 )
            );
        }

        $options = array(
            'predictive' => (bool) $predictive,
        );

        if ( ! $predictive ) {

            $group = $request->get_param( 'group' );

            if ( null !== $group && '' !== $group ) {
                $options['group'] = $group;
            }

            $page = $request->get_param( 'page' );

            $options['page'] = null === $page
                ? 1
                : absint( $page );

            $per_page = $request->get_param( 'per_page' );

            if ( null !== $per_page ) {
                $options['per_page'] = absint( $per_page );
            }
        }

        $results = ve_search_execute_query(
            $query,
            $options
        );

        if ( is_wp_error( $results ) ) {
            return ve_search_api_format_error( $results );
        }

        $response = rest_ensure_response( $results );

        $response->header(
            'Cache-Control',
            'no-store, no-cache, must-revalidate, max-age=0'
        );

        $response->header(
            'X-Content-Type-Options',
            'nosniff'
        );

        return $response;
    }
}

/**
 * Predictive search endpoint callback.
 *
 * @param WP_REST_Request $request REST request.
 * @return WP_REST_Response|WP_Error
 */
if ( ! function_exists( 've_search_api_predictive' ) ) {
    function ve_search_api_predictive( $request ) {

        return ve_search_api_handle_request(
            $request,
            true
        );
    }
}

/**
 * Full search endpoint callback.
 *
 * @param WP_REST_Request $request REST request.
 * @return WP_REST_Response|WP_Error
 */
if ( ! function_exists( 've_search_api_results' ) ) {
    function ve_search_api_results( $request ) {

        return ve_search_api_handle_request(
            $request,
            false
        );
    }
}

/**
 * Register search REST API routes.
 */
if ( ! function_exists( 've_search_register_api_routes' ) ) {
    function ve_search_register_api_routes() {

        if (
            ! function_exists( 've_search_execute_query' ) ||
            ! function_exists( 've_search_get_config' )
        ) {
            return;
        }

        register_rest_route(
            've-search/v1',
            '/predictive',
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => 've_search_api_predictive',
                'permission_callback' => '__return_true',
                'args'                => array(
                    'q' => array(
                        'required'          => true,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                ),
            )
        );

        register_rest_route(
            've-search/v1',
            '/results',
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => 've_search_api_results',
                'permission_callback' => '__return_true',
                'args'                => array(
                    'q' => array(
                        'required'          => true,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    'group' => array(
                        'required'          => false,
                        'type'              => 'string',
                        'sanitize_callback' => 'sanitize_key',
                    ),
                    'page' => array(
                        'required'          => false,
                        'type'              => 'integer',
                        'default'           => 1,
                        'sanitize_callback' => 'absint',
                        'validate_callback' => function ( $value ) {
                            return absint( $value ) >= 1;
                        },
                    ),
                    'per_page' => array(
                        'required'          => false,
                        'type'              => 'integer',
                        'default'           => 20,
                        'sanitize_callback' => 'absint',
                        'validate_callback' => function ( $value ) {
                            return absint( $value ) >= 1
                                && absint( $value ) <= 50;
                        },
                    ),
                ),
            )
        );
    }
}

add_action(
    'rest_api_init',
    've_search_register_api_routes'
);
￼Enter
