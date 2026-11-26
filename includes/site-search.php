
<?php
/**
 * Vestis Elites — Global Site Search
 *
 * Searches published products, downloadable products,
 * Journal articles, service pages, opportunities and pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return a search result in a consistent format.
 */
function ve_site_search_result( $post_id, $type ) {

    $result = array(
        'title' => get_the_title( $post_id ),
        'url'   => get_permalink( $post_id ),
        'type'  => $type,
    );

    return $result;
}

/**
 * Identify the appropriate group for a WordPress page.
 */
function ve_site_search_page_group( $post ) {

    $text = strtolower(
        $post->post_title . ' ' . $post->post_name
    );

    if (
        preg_match(
            '/opportunit|partner|apprentice|career|application/',
            $text
        )
    ) {
        return 'Opportunities';
    }

    if (
        preg_match(
            '/service|alteration|grooming|tailor|hair|manicure|pedicure|consultation/',
            $text
        )
    ) {
        return 'Services';
    }

    return 'Pages';
}

/**
 * Perform the public AJAX search.
 */
function ve_site_search_ajax() {

    if (
        ! check_ajax_referer(
            've_site_search',
            'nonce',
            false
        )
    ) {
        wp_send_json_error(
            array(
                'message' => 'Your search session has expired. Refresh the page and try again.',
            ),
            403
        );
    }

    $term = isset( $_POST['term'] )
        ? sanitize_text_field( wp_unslash( $_POST['term'] ) )
        : '';

    $term = trim( $term );

    if ( strlen( $term ) < 2 ) {
        wp_send_json_success(
            array(
                'groups' => array(),
            )
        );
    }

    if ( strlen( $term ) > 100 ) {
        $term = substr( $term, 0, 100 );
    }

    $groups = array(
        'Categories'        => array(),
        'Products'          => array(),
        'Digital Products'  => array(),
        'Journal'           => array(),
        'Services'           => array(),
        'Opportunities'      => array(),
        'Pages'              => array(),
    );

    /*
     * PRODUCTS
     */
    if ( function_exists( 'wc_get_products' ) ) {

        $products = wc_get_products(
            array(
                'status'  => 'publish',
                'limit'   => 8,
                's'       => $term,
                'orderby' => 'relevance',
                'return'  => 'objects',
            )
        );

        foreach ( $products as $product ) {

            if ( ! $product instanceof WC_Product ) {
                continue;
            }

            if ( ! $product->is_visible() ) {
                continue;
            }

            $group = $product->is_downloadable()
                ? 'Digital Products'
                : 'Products';

            $groups[ $group ][] = array(
                'title' => $product->get_name(),
                'url'   => get_permalink( $product->get_id() ),
                'type'  => $group,
                'price' => wp_strip_all_tags(
                    $product->get_price_html()
                ),
                'image' => $product->get_image_id()
                    ? wp_get_attachment_image_url(
                        $product->get_image_id(),
                        'thumbnail'
                    )
                    : '',
            );
        }

        /*
         * PRODUCT CATEGORIES
         */
        $categories = get_terms(
            array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'number'     => 5,
                'name__like' => $term,
            )
        );

        if ( ! is_wp_error( $categories ) ) {

            foreach ( $categories as $category ) {

                $category_url = get_term_link( $category );

                if ( is_wp_error( $category_url ) ) {
                    continue;
                }

                $groups['Categories'][] = array(
                    'title' => $category->name,
                    'url'   => $category_url,
                    'type'  => 'Product category',
                );
            }
        }
    }

    /*
     * JOURNAL ARTICLES
     */
    $journal = new WP_Query(
        array(
            'post_type'              => 'post',
            'post_status'            => 'publish',
            's'                      => $term,
            'posts_per_page'         => 5,
            'orderby'                => 'relevance',
            'ignore_sticky_posts'    => true,
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        )
    );

    foreach ( $journal->posts as $post ) {

        $groups['Journal'][] = ve_site_search_result(
            $post->ID,
            'Journal article'
        );
    }

    /*
     * WORDPRESS PAGES
     *
     * Service and opportunity pages are grouped separately.
     */
    $pages = new WP_Query(
        array(
            'post_type'              => 'page',
            'post_status'            => 'publish',
            's'                      => $term,
            'posts_per_page'         => 12,
            'orderby'                => 'relevance',
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        )
    );

    foreach ( $pages->posts as $post ) {

        $group = ve_site_search_page_group( $post );

        if ( count( $groups[ $group ] ) >= 5 ) {
            continue;
        }

        $groups[ $group ][] = ve_site_search_result(
            $post->ID,
            $group
        );
    }

    /*
     * Remove empty groups.
     */
    $groups = array_filter(
        $groups,
        function ( $items ) {
            return ! empty( $items );
        }
    );

    wp_send_json_success(
        array(
            'groups' => $groups,
        )
    );
}

add_action(
    'wp_ajax_ve_site_search',
    've_site_search_ajax'
);

add_action(
    'wp_ajax_nopriv_ve_site_search',
    've_site_search_ajax'
);


/**
 * Global search component.
 *
 * Usage: [ve_site_search]
 */
function ve_site_search_shortcode() {

    $instance_id = wp_unique_id( 've-site-search-' );

    ob_start();
    ?>

    <div
        id="<?php echo esc_attr( $instance_id ); ?>"
        class="ve-site-search"
        data-endpoint="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
        data-nonce="<?php echo esc_attr( wp_create_nonce( 've_site_search' ) ); ?>"
    >

        <label
            class="screen-reader-text"
            for="<?php echo esc_attr( $instance_id ); ?>-input"
        >
            Search Vestis Elites
        </label>

        <div class="ve-site-search__field">

            <span class="ve-site-search__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                    <circle cx="10.8" cy="10.8" r="6.8"></circle>
                    <path d="m16 16 5 5"></path>
                </svg>
            </span>

            <input
                id="<?php echo esc_attr( $instance_id ); ?>-input"
                class="ve-site-search__input"
                type="search"
                placeholder="Search..."
                autocomplete="off"
                aria-autocomplete="list"
                aria-expanded="false"
                aria-controls="<?php echo esc_attr( $instance_id ); ?>-results"
            >

            <button
                class="ve-site-search__clear"
                type="button"
                aria-label="Clear search"
                hidden
            >
                &times;
            </button>

        </div>

        <div
            id="<?php echo esc_attr( $instance_id ); ?>-results"
            class="ve-site-search__results"
            role="region"
            aria-label="Search suggestions"
            hidden
        ></div>

    </div>

    <style>
        .ve-site-search {
            position: relative;
            width: 100%;
            max-width: 320px;
            font-family: inherit;
            z-index: 99999;
        }

        .ve-site-search,
        .ve-site-search * {
            box-sizing: border-box;
        }

        .ve-site-search__field {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            min-height: 44px;
            padding: 0 12px;
            border: 1px solid #d8d8d8;
            border-radius: 3px;
            background: #fff;
        }

        .ve-site-search__icon {
            display: flex;
            flex: 0 0 19px;
        }

        .ve-site-search__icon svg {
            width: 19px;
            height: 19px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.7;
            stroke-linecap: round;
        }

        .ve-site-search__input {
            width: 100%;
            min-width: 0;
            padding: 8px 0;
            border: 0 !important;
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
            color: #171717 !important;
            font-size: 14px;
        }

        .ve-site-search__input::placeholder {
            color: #777;
        }

        .ve-site-search__clear {
            flex: 0 0 auto;
            border: 0;
            padding: 2px 5px;
            background: transparent;
            color: #555;
            font-size: 22px;
            cursor: pointer;
        }

        .ve-site-search__results {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            width: min(420px, 90vw);
            max-height: 420px;
            overflow-y: auto;
            padding: 12px;
            border: 1px solid #dedede;
            background: #fff;
            color: #171717;
            box-shadow: 0 12px 32px rgba(0,0,0,.12);
            z-index: 999999;
        }

        .ve-site-search__group + .ve-site-search__group {
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px solid #e8e8e8;
        }

        .ve-site-search__heading {
            margin: 0 0 7px;
            color: #1f4d3a;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .ve-site-search__item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 5px;
            color: #171717;
            font-size: 13px;
            line-height: 1.45;
            text-decoration: none;
        }

        .ve-site-search__item:hover,
        .ve-site-search__item:focus {
            background: #f5f5f2;
            color: #1f4d3a;
        }

        .ve-site-search__item img {
            width: 38px;
            height: 44px;
            flex: 0 0 38px;
            object-fit: cover;
        }

        .ve-site-search__item-copy {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .ve-site-search__price {
            color: #777;
            font-size: 11px;
        }

        .ve-site-search__message {
            padding: 14px 5px;
            color: #666;
            font-size: 13px;
            line-height: 1.6;
        }

        @media (max-width: 600px) {
            .ve-site-search {
                max-width: 100%;
            }

            .ve-site-search__field {
                min-height: 40px;
                padding: 0 9px;
            }

            .ve-site-search__results {
                max-height: 65vh;
            }
        }
    </style>

    <script>
    (function () {

        const root = document.getElementById(
            <?php echo wp_json_encode( $instance_id ); ?>
        );

        if (!root || root.dataset.initialised === 'true') {
            return;
        }

        root.dataset.initialised = 'true';

        const input = root.querySelector('.ve-site-search__input');
        const results = root.querySelector('.ve-site-search__results');
        const clear = root.querySelector('.ve-site-search__clear');

        let timer = null;
        let controller = null;
        let requestNumber = 0;

        function closeResults() {
            results.hidden = true;
            input.setAttribute('aria-expanded', 'false');
        }

        function showMessage(message) {
            results.replaceChildren();

            const element = document.createElement('div');
            element.className = 've-site-search__message';
            element.textContent = message;

            results.appendChild(element);
            results.hidden = false;
            input.setAttribute('aria-expanded', 'true');
        }

        function renderGroups(groups) {

            results.replaceChildren();

            const names = Object.keys(groups || {});

            if (!names.length) {
                showMessage('No matching results. Try another search term.');
                return;
            }

            names.forEach(function (name) {

                const section = document.createElement('section');
                section.className = 've-site-search__group';

                const heading = document.createElement('h3');
                heading.className = 've-site-search__heading';
                heading.textContent = name;

                section.appendChild(heading);

                groups[name].forEach(function (item) {

                    const link = document.createElement('a');
                    link.className = 've-site-search__item';
                    link.href = item.url;

                    if (item.image) {
                        const image = document.createElement('img');
                        image.src = item.image;
                        image.alt = '';
                        image.loading = 'lazy';
                        link.appendChild(image);
                    }

                    const copy = document.createElement('span');
                    copy.className = 've-site-search__item-copy';

                    const title = document.createElement('span');
                    title.textContent = item.title;
                    copy.appendChild(title);

                    if (item.price) {
                        const price = document.createElement('span');
                        price.className = 've-site-search__price';
                        price.textContent = item.price;
                        copy.appendChild(price);
                    }

                    link.appendChild(copy);
                    section.appendChild(link);
                });

                results.appendChild(section);
            });

            results.hidden = false;
            input.setAttribute('aria-expanded', 'true');
        }

        async function search(term) {

            if (controller) {
                controller.abort();
            }

            controller = new AbortController();

            const currentRequest = ++requestNumber;

            const body = new URLSearchParams();
            body.append('action', 've_site_search');
            body.append('nonce', root.dataset.nonce);
            body.append('term', term);

            try {

                const response = await fetch(
                    root.dataset.endpoint,
                    {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                        },
                        body: body.toString(),
                        signal: controller.signal
                    }
                );

                if (!response.ok) {
                    throw new Error('Search request failed.');
                }

                const data = await response.json();

                if (currentRequest !== requestNumber) {
                    return;
                }

                if (!data.success) {
                    showMessage('Search is temporarily unavailable. Please try again.');
                    return;
                }

                renderGroups(data.data.groups);

            } catch (error) {

                if (error.name !== 'AbortError') {
                    showMessage('Search is temporarily unavailable. Please try again.');
                }
            }
        }

        input.addEventListener('input', function () {

            const term = input.value.trim();

            clear.hidden = !term;

            window.clearTimeout(timer);

            if (controller) {
                controller.abort();
            }

            if (term.length < 2) {
                closeResults();
                return;
            }

            showMessage('Searching...');

            timer = window.setTimeout(function () {
                search(term);
            }, 300);
        });

        input.addEventListener('focus', function () {
            if (input.value.trim().length >= 2) {
                results.hidden = false;
            }
        });

        clear.addEventListener('click', function () {

            input.value = '';
            clear.hidden = true;

            if (controller) {
                controller.abort();
            }

            closeResults();
            input.focus();
        });

        document.addEventListener('click', function (event) {
            if (!root.contains(event.target)) {
                closeResults();
            }
        });

        input.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeResults();
            }
        });

    })();
    </script>

    <?php

    return ob_get_clean();
}

add_shortcode(
    've_site_search',
    've_site_search_shortcode'
);
