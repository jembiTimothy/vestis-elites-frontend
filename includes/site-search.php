<?php
/**
 * Vestis Elites — Global Site Search
 *
 * Customer-facing search for WooCommerce products, product taxonomies,
 * Journal articles, service pages, opportunities and public information pages.
 *
 * Shortcode: [ve_site_search]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Search configuration based on the current Vestis Elites site structure.
 *
 * Keep these IDs/slugs in sync if the corresponding WordPress pages change.
 */
function ve_site_search_config() {
	return array(
		'service_page_ids' => array( 1373, 2349, 2368, 2372, 848 ),
		'opportunity_page_ids' => array( 1488, 1940, 1937 ),
		'excluded_page_ids' => array(
			13,   // Cart.
			14,   // Checkout.
			15,   // My Account.
			784,  // Client Portal.
			851,  // Request Under Review.
			1510, // Thank You.
			1936, // Affiliate Account.
			1938, // Affiliate Reset Password.
			833,  // Home 2026 (alternate/legacy page).
			17,   // Home Page (legacy page).
			640,  // The House (alternate page).
		),
		'product_taxonomies' => array(
			'product_cat'   => 'Categories',
			'product_brand' => 'Brands',
			'product_tag'   => 'Product Tags',
		),
		'limits' => array(
			'products'       => 6,
			'taxonomy_terms' => 4,
			'journal'        => 4,
			'pages'          => 4,
			'group_items'    => 5,
		),
	);
}

/**
 * Consistent page/post result format.
 */
function ve_site_search_result( $post_id, $type ) {
	$title = get_the_title( $post_id );
	$url   = get_permalink( $post_id );

	if ( ! $title || ! $url ) {
		return null;
	}

	return array(
		'title' => wp_strip_all_tags( $title ),
		'url'   => esc_url_raw( $url ),
		'type'  => sanitize_text_field( $type ),
	);
}

/**
 * Consistent taxonomy result format.
 */
function ve_site_search_term_result( $term, $taxonomy ) {
	$url = get_term_link( $term );

	if ( is_wp_error( $url ) ) {
		return null;
	}

	$type_labels = array(
		'product_cat'   => 'Product category',
		'product_brand' => 'Product brand',
		'product_tag'   => 'Product tag',
	);

	return array(
		'title' => wp_strip_all_tags( $term->name ),
		'url'   => esc_url_raw( $url ),
		'type'  => isset( $type_labels[ $taxonomy ] )
			? $type_labels[ $taxonomy ]
			: 'Product taxonomy',
	);
}

/**
 * Decide whether a product belongs in the digital-products group.
 *
 * Downloadable is the primary WooCommerce flag. The live site also has
 * a Grooming Ebooks category and a digital-ebook product tag, which are
 * used as fallbacks for products whose downloadable flag may be unset.
 */
function ve_site_search_is_digital_product( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return false;
	}

	$product_id = $product->get_id();

	if ( $product->is_downloadable() ) {
		return true;
	}

	if ( has_term( array( 'grooming-ebooks', 'the-personal-presentation-system' ), 'product_cat', $product_id ) ) {
		return true;
	}

	if ( has_term( 'digital-ebook', 'product_tag', $product_id ) ) {
		return true;
	}

	return false;
}

/**
 * Add a result only when its group has not reached its display limit.
 */
function ve_site_search_add_result( &$groups, $group, $result, $limit ) {
	if ( ! $result || ! isset( $groups[ $group ] ) ) {
		return;
	}

	if ( count( $groups[ $group ] ) >= $limit ) {
		return;
	}

	$groups[ $group ][] = $result;
}

/**
 * Public AJAX search endpoint.
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

	if ( function_exists( 'mb_strlen' ) ) {
		$term_length = mb_strlen( $term, 'UTF-8' );
	} else {
		$term_length = strlen( $term );
	}

	if ( $term_length < 2 ) {
		wp_send_json_success( array( 'groups' => array() ) );
	}

	if ( $term_length > 80 ) {
		$term = function_exists( 'mb_substr' )
			? mb_substr( $term, 0, 80, 'UTF-8' )
			: substr( $term, 0, 80 );
	}

	$config = ve_site_search_config();
	$limits = $config['limits'];

	$groups = array(
		'Products'         => array(),
		'Digital Products' => array(),
		'Categories'       => array(),
		'Brands'           => array(),
		'Product Tags'     => array(),
		'Services'         => array(),
		'Opportunities'    => array(),
		'Journal'          => array(),
		'Pages'            => array(),
	);

	/*
	 * PRODUCTS
	 */
	if ( function_exists( 'wc_get_products' ) ) {
		$products = wc_get_products(
			array(
				'status'  => 'publish',
				'limit'   => 12,
				's'       => $term,
				'orderby' => 'relevance',
				'return'  => 'objects',
			)
		);

		foreach ( $products as $product ) {
			if ( ! $product instanceof WC_Product || ! $product->is_visible() ) {
				continue;
			}

			$group = ve_site_search_is_digital_product( $product )
				? 'Digital Products'
				: 'Products';

			$image_id  = $product->get_image_id();
			$image_url = $image_id
				? wp_get_attachment_image_url( $image_id, 'woocommerce_thumbnail' )
				: '';

			$result = array(
				'title' => $product->get_name(),
				'url'   => esc_url_raw( get_permalink( $product->get_id() ) ),
				'type'  => $group,
				'price' => wp_strip_all_tags( $product->get_price_html() ),
				'image' => $image_url ? esc_url_raw( $image_url ) : '',
			);

			ve_site_search_add_result(
				$groups,
				$group,
				$result,
				$limits['products']
			);
		}

		/*
		 * PRODUCT CATEGORIES, BRANDS AND TAGS
		 *
		 * Use WordPress term search rather than name__like. This searches
		 * the registered taxonomy's term names and descriptions.
		 */
		foreach ( $config['product_taxonomies'] as $taxonomy => $group ) {
			if ( ! taxonomy_exists( $taxonomy ) ) {
				continue;
			}

			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => true,
					'number'     => $limits['taxonomy_terms'],
					'search'     => $term,
					'orderby'    => 'name',
					'order'      => 'ASC',
				)
			);

			if ( is_wp_error( $terms ) || empty( $terms ) ) {
				continue;
			}

			foreach ( $terms as $product_term ) {
				ve_site_search_add_result(
					$groups,
					$group,
					ve_site_search_term_result( $product_term, $taxonomy ),
					$limits['taxonomy_terms']
				);
			}
		}
	}

	/*
	 * JOURNAL ARTICLES
	 *
	 * The live site uses standard WordPress posts for Journal content.
	 */
	$journal = new WP_Query(
		array(
			'post_type'              => 'post',
			'post_status'            => 'publish',
			's'                      => $term,
			'posts_per_page'         => $limits['journal'],
			'orderby'                => 'relevance',
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	foreach ( $journal->posts as $journal_post ) {
		ve_site_search_add_result(
			$groups,
			'Journal',
			ve_site_search_result( $journal_post->ID, 'Journal article' ),
			$limits['journal']
		);
	}
	wp_reset_postdata();

	/*
	 * PUBLIC PAGES
	 *
	 * Explicit page IDs are used for Services and Opportunities because
	 * the site's page titles/slugs do not all contain generic keywords.
	 * Utility, account, transaction and legacy pages are excluded.
	 */
	$pages = new WP_Query(
		array(
			'post_type'              => 'page',
			'post_status'            => 'publish',
			's'                      => $term,
			'posts_per_page'         => 30,
			'orderby'                => 'relevance',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	foreach ( $pages->posts as $page ) {
		$page_id = (int) $page->ID;

		if ( in_array( $page_id, $config['excluded_page_ids'], true ) ) {
			continue;
		}

		if ( in_array( $page_id, $config['service_page_ids'], true ) ) {
			$group = 'Services';
			$type  = 'Service';
		} elseif ( in_array( $page_id, $config['opportunity_page_ids'], true ) ) {
			$group = 'Opportunities';
			$type  = 'Opportunity';
		} else {
			$group = 'Pages';
			$type  = 'Page';
		}

		ve_site_search_add_result(
			$groups,
			$group,
			ve_site_search_result( $page_id, $type ),
			$limits['group_items']
		);
	}
	wp_reset_postdata();

	/*
	 * Remove empty groups while preserving the defined display order.
	 */
	foreach ( $groups as $group_name => $items ) {
		if ( empty( $items ) ) {
			unset( $groups[ $group_name ] );
		}
	}

	wp_send_json_success(
		array(
			'groups' => $groups,
		)
	);
}

add_action( 'wp_ajax_ve_site_search', 've_site_search_ajax' );
add_action( 'wp_ajax_nopriv_ve_site_search', 've_site_search_ajax' );
/**
 * Search component.
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
				<svg viewBox="0 0 24 24" focusable="false">
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
			z-index: 99999;
			width: 100%;
			max-width: 320px;
			font-family: inherit;
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
			margin: 0;
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
			padding: 2px 5px;
			border: 0;
			background: transparent;
			color: #555;
			font-size: 22px;
			cursor: pointer;
		}
		.ve-site-search__results {
			position: absolute;
			top: calc(100% + 8px);
			left: 0;
			z-index: 999999;
			width: min(420px, 90vw);
			max-height: 420px;
			overflow-y: auto;
			padding: 12px;
			border: 1px solid #dedede;
			background: #fff;
			color: #171717;
			box-shadow: 0 12px 32px rgba(0,0,0,.12);
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
			min-width: 0;
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
				const response = await fetch(root.dataset.endpoint, {
					method: 'POST',
					credentials: 'same-origin',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
					},
					body: body.toString(),
					signal: controller.signal
				});

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
				if (error.name !== 'AbortError' && currentRequest === requestNumber) {
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

			window.clearTimeout(timer);
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

add_shortcode( 've_site_search', 've_site_search_shortcode' );
