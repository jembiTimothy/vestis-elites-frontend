<?php
/**
 * Vestis Elites — Homepage
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Add a dedicated body class to the coded homepage.
 */
function vestis_elites_homepage_body_class( $classes ) {

	if ( is_page() ) {

		$page_id      = get_queried_object_id();
		$page_content = get_post_field( 'post_content', $page_id );

		if ( $page_content && has_shortcode( $page_content, 'vestis_frontend' ) ) {
			$classes[] = 've-coded-homepage';
		}
	}

	return $classes;
}

add_filter(
	'body_class',
	'vestis_elites_homepage_body_class'
);


/**
 * Find a published WordPress page by title.
 */
function vestis_elites_get_page_url( $title ) {

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'title'          => $title,
			'posts_per_page' => 1,
		)
	);

	if ( empty( $pages ) ) {
		return '';
	}

	return get_permalink( $pages[0]->ID );
}


/**
 * Find a WordPress image attachment by filename.
 */
function vestis_elites_get_image_id( $filename ) {

	$attachments = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'meta_query'     => array(
				array(
					'key'     => '_wp_attached_file',
					'value'   => $filename,
					'compare' => 'LIKE',
				),
			),
		)
	);

	if ( empty( $attachments ) ) {
		return 0;
	}

	return (int) $attachments[0]->ID;
}


/**
 * Vestis Elites coded homepage.
 */
function vestis_elites_homepage() {

	$consultation_url = vestis_elites_get_page_url( 'Private Consultation' );
	$atelier_url      = vestis_elites_get_page_url( 'Atelier' );

	$desktop_image_id = vestis_elites_get_image_id(
		'vestis-elite-about-hero-premium-2.webp'
	);

	$mobile_image_id = vestis_elites_get_image_id(
		'vestis-elites-refined-men-portrait.webp'
	);

	$desktop_image_url = $desktop_image_id
		? wp_get_attachment_image_url( $desktop_image_id, 'full' )
		: '';

	$mobile_image_url = $mobile_image_id
		? wp_get_attachment_image_url( $mobile_image_id, 'full' )
		: '';

	$desktop_srcset = $desktop_image_id
		? wp_get_attachment_image_srcset( $desktop_image_id, 'full' )
		: '';

	$mobile_srcset = $mobile_image_id
		? wp_get_attachment_image_srcset( $mobile_image_id, 'full' )
		: '';
	$journal_url = vestis_elites_get_page_url( 'Journal' );

	$atelier_image_id = vestis_elites_get_image_id(
		'imperium-wine-double-breasted-suit-luxury-fashion.webp'
	);

	$consultation_image_id = vestis_elites_get_image_id(
		'vestis-elites-private-consultation-bespoke-tailoring.webp'
	);

	$journal_image_id = vestis_elites_get_image_id(
		'vestis-elites-journal-personal-presentation-editorial.webp'
	);

	$atelier_image_url = $atelier_image_id
		? wp_get_attachment_image_url( $atelier_image_id, 'full' )
		: '';

	$consultation_image_url = $consultation_image_id
		? wp_get_attachment_image_url( $consultation_image_id, 'full' )
		: '';

	$journal_image_url = $journal_image_id
		? wp_get_attachment_image_url( $journal_image_id, 'full' )
		: '';
		$testimonial_one_image_id = vestis_elites_get_image_id(
		'vestis-elites-client-testimonial-whatsapp-review.webp'
	);

	$testimonial_two_image_id = vestis_elites_get_image_id(
		'vestis-elites-client-testimonial-whatsapp-chat.webp'
	);

	$testimonial_one_image_url = $testimonial_one_image_id
		? wp_get_attachment_image_url( $testimonial_one_image_id, 'full' )
		: '';

	$testimonial_two_image_url = $testimonial_two_image_id
		? wp_get_attachment_image_url( $testimonial_two_image_id, 'full' )
		: '';
		/* =========================================================
	   SECTION 7 — LIVE WOOCOMMERCE ATELIER
	========================================================= */

	$atelier_products = array();

	if ( function_exists( 'wc_get_products' ) ) {

		$atelier_candidates = wc_get_products(
			array(
				'status'       => 'publish',
				'type'         => array( 'simple', 'variable' ),
				'stock_status' => 'instock',
				'limit'        => 12,
				'orderby'      => 'rand',
				'return'       => 'objects',
			)
		);

		foreach ( $atelier_candidates as $atelier_product ) {

			if ( ! $atelier_product instanceof WC_Product ) {
				continue;
			}

			if ( ! $atelier_product->is_visible() ) {
				continue;
			}

			if ( ! $atelier_product->is_purchasable() ) {
				continue;
			}

			if ( ! $atelier_product->get_image_id() ) {
				continue;
			}

			$atelier_products[] = $atelier_product;

			if ( count( $atelier_products ) >= 6 ) {
				break;
			}
		}
	}
	ob_start();
	?>

	<!-- =========================================================
	     SECTION 1 — HERO
	     ========================================================= -->

	<section
		class="ve-hero-content"
		aria-labelledby="ve-hero-title"
	>

		<div class="ve-hero-content__inner">

			<p class="ve-hero-content__eyebrow">
				VESTIS ELITES
			</p>

			<h1
				id="ve-hero-title"
				class="ve-hero-content__title"
			>
				Personal Presentation.<br>
				Lifestyle.<br>
				Bespoke.
			</h1>

			<p class="ve-hero-content__supporting">
				Bespoke clothing and personal presentation designed around you.
			</p>

			<div class="ve-hero-content__actions">

				<?php if ( $consultation_url ) : ?>

					<a
						class="ve-button ve-button--primary"
						href="<?php echo esc_url( $consultation_url ); ?>"
					>
						Begin Your Private Consultation
					</a>

				<?php endif; ?>

				<?php if ( $atelier_url ) : ?>

					<a
						class="ve-button ve-button--secondary"
						href="<?php echo esc_url( $atelier_url ); ?>"
					>
						<span>Explore The Atelier</span>

						<span
							class="ve-button__arrow"
							aria-hidden="true"
						>
							→
						</span>
					</a>

				<?php endif; ?>

			</div>

		</div>

	</section>


	<!-- =========================================================
	     SECTION 2 — HERO IMAGE
	     ========================================================= -->

	<?php if ( $desktop_image_url || $mobile_image_url ) : ?>

		<section
			class="ve-hero-image"
			aria-label="Vestis Elites editorial presentation"
		>

			<picture>

				<?php if ( $mobile_image_url ) : ?>

					<source
						media="(max-width: 640px)"
						srcset="<?php echo esc_attr( $mobile_srcset ? $mobile_srcset : $mobile_image_url ); ?>"
						sizes="100vw"
					>

				<?php endif; ?>

				<img
					class="ve-hero-image__media"
					src="<?php echo esc_url( $desktop_image_url ? $desktop_image_url : $mobile_image_url ); ?>"
					<?php if ( $desktop_srcset ) : ?>
						srcset="<?php echo esc_attr( $desktop_srcset ); ?>"
						sizes="100vw"
					<?php endif; ?>
					alt="Man wearing a tailored beige suit in the Vestis Elites atelier"
					loading="eager"
					fetchpriority="high"
					decoding="async"
				>

			</picture>

		</section>

	<?php endif; ?>


	<!-- =========================================================
	     SECTION 3 — THE HOUSE
	     ========================================================= -->

	<section
		class="ve-house"
		aria-labelledby="ve-house-title"
	>

		<div class="ve-house__inner">

			<p class="ve-house__eyebrow">
				THE HOUSE
			</p>

			<h2
				id="ve-house-title"
				class="ve-house__title"
			>
				Your time belongs elsewhere.
			</h2>

			<p class="ve-house__body">
				Personal presentation can demand constant decisions.
				<strong>Vestis Elites</strong> takes that responsibility off you through
				clothing, grooming and presentation solutions designed around you.
			</p>

			<p class="ve-house__closing">
				So you can focus on what matters.
			</p>

		</div>

	</section>

	<!-- =========================================================
	     SECTION 4 — EXPLORE THE HOUSE
	     ========================================================= -->

	<section
		class="ve-explore"
		aria-labelledby="ve-explore-title"
	>

		<div class="ve-explore__inner">

			<header class="ve-explore__header">

				<h2
					id="ve-explore-title"
					class="ve-explore__title"
				>
					Explore the House.
				</h2>

			</header>


			<div class="ve-explore__grid">


				<!-- ATELIER -->

				<?php if ( $atelier_url && $atelier_image_url ) : ?>

					<a
						class="ve-explore-card ve-explore-card--atelier"
						href="<?php echo esc_url( $atelier_url ); ?>"
					>

						<div class="ve-explore-card__image-wrap">

							<img
								class="ve-explore-card__image"
								src="<?php echo esc_url( $atelier_image_url ); ?>"
								alt="Man wearing a wine double-breasted suit by Vestis Elites"
								loading="lazy"
								decoding="async"
							>

						</div>

						<div class="ve-explore-card__content">

							<p class="ve-explore-card__eyebrow">
								THE ATELIER
							</p>

							<h3 class="ve-explore-card__title">
								The collection, thoughtfully curated.
							</h3>

							<span class="ve-explore-card__cta">
								Explore The Atelier
								<span aria-hidden="true">→</span>
							</span>

						</div>

					</a>

				<?php endif; ?>


				<!-- PRIVATE CONSULTATION -->

				<?php if ( $consultation_url && $consultation_image_url ) : ?>

					<a
						class="ve-explore-card ve-explore-card--consultation"
						href="<?php echo esc_url( $consultation_url ); ?>"
					>

						<div class="ve-explore-card__image-wrap">

							<img
								class="ve-explore-card__image"
								src="<?php echo esc_url( $consultation_image_url ); ?>"
								alt="Private bespoke tailoring consultation at Vestis Elites"
								loading="lazy"
								decoding="async"
							>

						</div>

						<div class="ve-explore-card__content">

							<p class="ve-explore-card__eyebrow">
								PRIVATE CONSULTATION
							</p>

							<h3 class="ve-explore-card__title">
								Your presentation starts with a conversation.
							</h3>

							<p class="ve-explore-card__supporting">
								Tell us where you are and where you want to go.
							</p>

							<span class="ve-explore-card__cta">
								Begin Your Private Consultation
								<span aria-hidden="true">→</span>
							</span>

						</div>

					</a>

				<?php endif; ?>


				<!-- JOURNAL -->

				<?php if ( $journal_url && $journal_image_url ) : ?>

					<a
						class="ve-explore-card ve-explore-card--journal"
						href="<?php echo esc_url( $journal_url ); ?>"
					>

						<div class="ve-explore-card__image-wrap">

							<img
								class="ve-explore-card__image"
								src="<?php echo esc_url( $journal_image_url ); ?>"
								alt="Man exploring ideas on personal presentation"
								loading="lazy"
								decoding="async"
							>

						</div>

						<div class="ve-explore-card__content">

							<p class="ve-explore-card__eyebrow">
								THE JOURNAL
							</p>

							<h3 class="ve-explore-card__title">
								Ideas on personal presentation, style and the way you live.
							</h3>

							<span class="ve-explore-card__cta">
								Read The Journal
								<span aria-hidden="true">→</span>
							</span>

						</div>

					</a>

				<?php endif; ?>


			</div>

		</div>

</section>
	<!-- =========================================================
	     SECTION 5 — WHY VESTIS
	     ========================================================= -->

	<section
		class="ve-why"
		aria-labelledby="ve-why-title"
	>

		<div class="ve-why__inner">

			<header class="ve-why__header">

				<p class="ve-why__eyebrow">
					WHY VESTIS ELITES
				</p>

				<h2
					id="ve-why-title"
					class="ve-why__title"
				>
					We make personal presentation easier.
				</h2>

				<p class="ve-why__intro">
					Vestis Elites helps you manage how you present yourself through tailored clothing, grooming and personal presentation solutions designed around your lifestyle.
				</p>

			</header>


			<div class="ve-why__principles">


				<article class="ve-why__principle">

					<span class="ve-why__number">
						01
					</span>

					<div class="ve-why__principle-content">

						<h3 class="ve-why__principle-title">
							We understand you.
						</h3>

						<p class="ve-why__principle-text">
							We start with you — your lifestyle, work, preferences and the way you want to be seen.
						</p>

					</div>

				</article>


				<article class="ve-why__principle">

					<span class="ve-why__number">
						02
					</span>

					<div class="ve-why__principle-content">

						<h3 class="ve-why__principle-title">
							We handle the details.
						</h3>

						<p class="ve-why__principle-text">
							From what you wear to how you groom and present yourself, we help you make better decisions without having to manage everything yourself.
						</p>

					</div>

				</article>


				<article class="ve-why__principle">

					<span class="ve-why__number">
						03
					</span>

					<div class="ve-why__principle-content">

						<h3 class="ve-why__principle-title">
							We build for the long term.
						</h3>

						<p class="ve-why__principle-text">
							Our goal is not to dress you once. We build a trusted relationship that helps you maintain a consistent standard of presentation over time.
						</p>

					</div>

				</article>


			</div>


			<p class="ve-why__closing">
				Less time managing your presentation. More time focused on what matters.
			</p>

		</div>

	</section>
		<!-- =========================================================
	     SECTION 6 — CLIENT EXPERIENCE
	     ========================================================= -->

	<section
		class="ve-client-experience"
		aria-labelledby="ve-client-experience-title"
	>

		<div class="ve-client-experience__inner">

			<header class="ve-client-experience__header">

				<p class="ve-client-experience__eyebrow">
					CLIENT EXPERIENCE
				</p>

				<h2
					id="ve-client-experience-title"
					class="ve-client-experience__title"
				>
					The experience speaks for itself.
				</h2>

			</header>


			<div class="ve-client-experience__proof">


				<?php if ( $testimonial_one_image_url ) : ?>

					<figure class="ve-testimonial-proof ve-testimonial-proof--primary">

						<img
							src="<?php echo esc_url( $testimonial_one_image_url ); ?>"
							alt="Client feedback about a Vestis Elites outfit"
							loading="lazy"
							decoding="async"
						>

					</figure>

				<?php endif; ?>


				<?php if ( $testimonial_two_image_url ) : ?>

					<figure class="ve-testimonial-proof ve-testimonial-proof--secondary">

						<img
							src="<?php echo esc_url( $testimonial_two_image_url ); ?>"
							alt="Client feedback praising a Vestis Elites outfit"
							loading="lazy"
							decoding="async"
						>

					</figure>

				<?php endif; ?>


			</div>


			<blockquote class="ve-client-experience__quote">

				<p>
					“Yes, oh please pardon me, it really fits so well. He likes it.”
				</p>

				<footer>
					<span>CLIENT FEEDBACK</span>
				</footer>

			</blockquote>


		</div>

	</section>
		<!-- =========================================================
	     SECTION 7 — THE ATELIER
	     ========================================================= -->

	<section
		class="ve-atelier"
		aria-labelledby="ve-atelier-title"
	>

		<div class="ve-atelier__inner">

			<header class="ve-atelier__header">

				<h2
					id="ve-atelier-title"
					class="ve-atelier__title"
				>
					THE ATELIER
				</h2>

			</header>


			<?php if ( ! empty( $atelier_products ) ) : ?>

				<div
					class="ve-atelier__carousel"
					data-ve-atelier-carousel
				>

					<div class="ve-atelier__track">

						<?php foreach ( $atelier_products as $atelier_product ) : ?>

							<?php

							$atelier_gallery_ids = array_unique(
								array_merge(
									array( $atelier_product->get_image_id() ),
									$atelier_product->get_gallery_image_ids()
								)
							);

							$atelier_gallery_ids = array_filter( $atelier_gallery_ids );

							?>

							<article
								class="ve-atelier-product"
								data-ve-atelier-product
								data-product-id="<?php echo esc_attr( $atelier_product->get_id() ); ?>"
								data-product-type="<?php echo esc_attr( $atelier_product->get_type() ); ?>"
							>

								<div class="ve-atelier-product__visual">

									<div class="ve-atelier-product__gallery">

										<?php foreach ( $atelier_gallery_ids as $atelier_index => $atelier_image_id ) : ?>

											<?php
											$atelier_image_url = wp_get_attachment_image_url(
												$atelier_image_id,
												'full'
											);

											if ( ! $atelier_image_url ) {
												continue;
											}
											?>

											<img
												class="ve-atelier-product__image<?php echo 0 === $atelier_index ? ' is-active' : ''; ?>"
												src="<?php echo esc_url( $atelier_image_url ); ?>"
												alt="<?php echo esc_attr( $atelier_product->get_name() ); ?>"
												loading="<?php echo 0 === $atelier_index ? 'eager' : 'lazy'; ?>"
												decoding="async"
											>

										<?php endforeach; ?>

									</div>

								</div>


								<div class="ve-atelier-product__content">

									<h3 class="ve-atelier-product__name">
										<?php echo esc_html( $atelier_product->get_name() ); ?>
									</h3>


									<?php
									$atelier_short_description = wp_trim_words(
										wp_strip_all_tags(
											$atelier_product->get_short_description()
										),
										24,
										'…'
									);
									?>

									<?php if ( $atelier_short_description ) : ?>

										<p class="ve-atelier-product__description">
											<?php echo esc_html( $atelier_short_description ); ?>
										</p>

									<?php endif; ?>


									<div class="ve-atelier-product__price">
										<?php echo wp_kses_post( $atelier_product->get_price_html() ); ?>
									</div>


									<div class="ve-atelier-product__actions">

										<button
											type="button"
											class="ve-atelier-product__purchase"
											data-ve-purchase
										>
											Purchase
										</button>

										<button
											type="button"
											class="ve-atelier-product__cart"
											data-ve-add-to-cart
										>
											Add to Cart
										</button>

									</div>


									<a
										class="ve-atelier-product__details"
										href="<?php echo esc_url( $atelier_product->get_permalink() ); ?>"
									>
										View Details →
									</a>

								</div>


								<div
									class="ve-atelier-product__selection"
									data-ve-size-selection
									hidden
								>

									<div class="ve-atelier-product__selection-inner">

										<p class="ve-atelier-product__selection-label">
											Select Size
										</p>

										<div
											class="ve-atelier-product__sizes"
											data-ve-product-sizes
										></div>

										<div
											class="ve-atelier-product__selected-price"
											data-ve-selected-price
										>
											<?php echo wp_kses_post( $atelier_product->get_price_html() ); ?>
										</div>

										<button
											type="button"
											class="ve-atelier-product__confirm"
											data-ve-confirm-purchase
										>
											Purchase
										</button>

									</div>

								</div>

							</article>

						<?php endforeach; ?>

					</div>


					<div class="ve-atelier__navigation">

						<button
							type="button"
							class="ve-atelier__arrow ve-atelier__arrow--previous"
							data-ve-atelier-prev
							aria-label="Previous product"
						>
							←
						</button>

						<button
							type="button"
							class="ve-atelier__arrow ve-atelier__arrow--next"
							data-ve-atelier-next
							aria-label="Next product"
						>
							→
						</button>

					</div>


					<p class="ve-atelier__swipe-hint">
						Swipe to explore →
					</p>

				</div>

			<?php else : ?>

				<p class="ve-atelier__empty">
					The Atelier is currently being curated.
				</p>

			<?php endif; ?>


			<div class="ve-atelier__footer">

				<a
					class="ve-atelier__full-link"
					href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
				>
					Explore the Full Atelier →
				</a>

			</div>

		</div>

	</section>
	<style>

		/* =========================================================
		   ASTRA — FULL WIDTH SINGLE COLUMN
		========================================================= */

		body.ve-coded-homepage .site-content > .ast-container {

			display: block !important;

			width: 100% !important;

			max-width: none !important;

			margin: 0 !important;

			padding-left: 0 !important;

			padding-right: 0 !important;
		}


		body.ve-coded-homepage .site-content .ast-row {

			display: block !important;

			width: 100% !important;

			max-width: none !important;

			margin: 0 !important;
		}


		body.ve-coded-homepage .site-content #primary {

			display: block !important;

			float: none !important;

			width: 100% !important;

			max-width: none !important;

			flex: none !important;

			margin: 0 !important;

			padding: 0 !important;
		}


		body.ve-coded-homepage .site-content #secondary {

			display: none !important;

			width: 0 !important;

			max-width: 0 !important;

			margin: 0 !important;

			padding: 0 !important;
		}


		body.ve-coded-homepage .site-content .hentry {

			display: block !important;

			width: 100% !important;

			max-width: none !important;

			margin: 0 !important;

			padding: 0 !important;
		}


		body.ve-coded-homepage .site-content .entry-content {

			display: block !important;

			width: 100% !important;

			max-width: none !important;

			margin: 0 !important;

			padding: 0 !important;
		}


		/* =========================================================
		   HOMEPAGE RESET
		========================================================= */

		body.ve-coded-homepage .ve-hero-content,
		body.ve-coded-homepage .ve-hero-image,
		body.ve-coded-homepage .ve-house {

			display: block;

			width: 100% !important;

			max-width: none !important;

			margin-left: 0 !important;

			margin-right: 0 !important;

			box-sizing: border-box;
		}


		/* =========================================================
		   HERO
		========================================================= */

		.ve-hero-content {

			background: #000000;

			color: #F7F5EF;

			overflow: hidden;
		}


		.ve-hero-content__inner {

			width: min(100%, 1180px);

			margin: 0 auto;

			padding:
				clamp(140px, 14vw, 190px)
				32px
				clamp(150px, 15vw, 210px);

			box-sizing: border-box;
		}


		.ve-hero-content__eyebrow {

			margin: 0 0 40px;

			color: #5E9B7D;

			font-size: 12px;

			font-weight: 600;

			line-height: 1.2;

			letter-spacing: 0.20em;

			text-transform: uppercase;
		}


		.ve-hero-content__title {

			max-width: 760px;

			margin: 0;

			color: #F7F5EF;

			font-size: clamp(42px, 5.2vw, 68px);

			font-weight: 500;

			line-height: 1.10;

			letter-spacing: -0.035em;
		}


		.ve-hero-content__supporting {

			max-width: 540px;

			margin: 42px 0 0;

			color: rgba(247, 245, 239, 0.76);

			font-size: clamp(16px, 1.4vw, 18px);

			line-height: 1.65;
		}


		/* =========================================================
		   CTA
		========================================================= */

		.ve-hero-content__actions {

			display: flex;

			align-items: center;

			flex-wrap: wrap;

			gap: 34px;

			margin-top: 58px;
		}


		.ve-button--primary,
		.ve-button--primary:hover,
		.ve-button--primary:focus,
		.ve-button--primary:visited {

			text-decoration: none !important;
		}


		.ve-button--primary {

			display: inline-flex;

			align-items: center;

			justify-content: center;

			min-height: 54px;

			padding: 0 30px;

			background: #F7F5EF;

			color: #000000;

			border: 1px solid #F7F5EF;

			font-size: 14px;

			font-weight: 600;

			line-height: 1;

			transition:
				background-color 260ms ease,
				color 260ms ease,
				border-color 260ms ease,
				transform 260ms ease;
		}


		.ve-button--primary:hover,
		.ve-button--primary:focus-visible {

			background: #1F4D3A;

			color: #FFFFFF;

			border-color: #1F4D3A;

			transform: translateY(-2px);
		}


		.ve-button--secondary {

			display: inline-flex;

			align-items: center;

			gap: 9px;

			min-height: 44px;

			padding: 10px 0;

			color: #F7F5EF;

			font-size: 14px;

			font-weight: 600;

			text-decoration: underline;

			text-decoration-thickness: 1px;

			text-underline-offset: 6px;

			transition: color 260ms ease;
		}


		.ve-button--secondary:hover,
		.ve-button--secondary:focus-visible {

			color: #1F4D3A;
		}


		.ve-button__arrow {

			transition: transform 260ms ease;
		}


		.ve-button--secondary:hover .ve-button__arrow {

			transform: translateX(5px);
		}


		/* =========================================================
		   HERO ANIMATION
		========================================================= */

		.ve-hero-content__eyebrow,
		.ve-hero-content__title,
		.ve-hero-content__supporting,
		.ve-hero-content__actions {

			animation:
				veHeroReveal
				1500ms
				cubic-bezier(0.22, 1, 0.36, 1)
				both;
		}


		.ve-hero-content__eyebrow {
			animation-delay: 0ms;
		}


		.ve-hero-content__title {
			animation-delay: 300ms;
		}


		.ve-hero-content__supporting {
			animation-delay: 600ms;
		}


		.ve-hero-content__actions {
			animation-delay: 900ms;
		}


		@keyframes veHeroReveal {

			from {

				opacity: 0;

				transform: translateY(18px);
			}

			to {

				opacity: 1;

				transform: translateY(0);
			}
		}


		/* =========================================================
		   IMAGE
		========================================================= */

		.ve-hero-image {

			margin-top: 48px !important;

			padding: 0 !important;

			background: #F7F5EF;

			overflow: hidden;
		}


		.ve-hero-image picture {

			display: block;

			width: 100%;
		}


		.ve-hero-image__media {

			display: block;

			width: 100% !important;

			max-width: none !important;

			height: auto;

			margin: 0 !important;

			padding: 0 !important;

			object-fit: cover;

			animation:
				veHeroImageReveal
				1800ms
				cubic-bezier(0.22, 1, 0.36, 1)
				both;
		}


		@keyframes veHeroImageReveal {

			from {

				opacity: 0;

				transform: scale(1.025);
			}

			to {

				opacity: 1;

				transform: scale(1.001);
			}
		}


		/* =========================================================
		   SECTION 3 — THE HOUSE
		========================================================= */

		.ve-house {

			background: #FFFFFF;

			color: #111111;

			overflow: hidden;
		}


		.ve-house__inner {

			width: min(100%, 1180px);

			margin: 0 auto;

			padding:
				clamp(120px, 12vw, 180px)
				32px
				clamp(130px, 13vw, 190px);

			box-sizing: border-box;
		}


		.ve-house__eyebrow {

			margin: 0 0 34px;

			color: #1F4D3A;

			font-size: 11px;

			font-weight: 600;

			line-height: 1.2;

			letter-spacing: 0.20em;

			text-transform: uppercase;
		}


		.ve-house__title {

			max-width: 760px;

			margin: 0;

			color: #111111;

			font-size: clamp(40px, 5vw, 64px);

			font-weight: 500;

			line-height: 1.08;

			letter-spacing: -0.035em;
		}


		.ve-house__body {

			max-width: 650px;

			margin: 42px 0 0;

			color: #3F3F3F;

			font-size: clamp(17px, 1.45vw, 19px);

			font-weight: 400;

			line-height: 1.75;

			letter-spacing: -0.005em;
		}


		.ve-house__body strong {

			color: #1F4D3A;

			font-weight: 600;

			letter-spacing: -0.01em;
		}


		.ve-house__closing {

			max-width: 600px;

			margin: 52px 0 0;

			color: #111111;

			font-size: clamp(20px, 2vw, 26px);

			font-weight: 500;

			line-height: 1.4;

			letter-spacing: -0.02em;
		}
				/* =========================================================
		   SECTION 4 — EXPLORE THE HOUSE
		========================================================= */

		.ve-explore {

			background: #FFFFFF;

			color: #111111;

			overflow: hidden;
		}


		.ve-explore__inner {

			width: min(100%, 1180px);

			margin: 0 auto;

			padding:
				clamp(110px, 11vw, 170px)
				32px
				clamp(120px, 12vw, 180px);

			box-sizing: border-box;
		}


		.ve-explore__header {

			margin-bottom: clamp(58px, 7vw, 90px);
		}


		.ve-explore__title {

			max-width: 760px;

			margin: 0;

			color: #111111;

			font-size: clamp(40px, 5vw, 64px);

			font-weight: 500;

			line-height: 1.08;

			letter-spacing: -0.035em;
		}


		.ve-explore__grid {

			display: grid;

			grid-template-columns: repeat(2, minmax(0, 1fr));

			column-gap: 34px;

			row-gap: 80px;
		}


		.ve-explore-card {

			display: block;

			color: inherit;

			text-decoration: none !important;

			transition: color 260ms ease;
		}


		.ve-explore-card--atelier {

			grid-column: 1 / -1;
		}


		.ve-explore-card__image-wrap {

			width: 100%;

			overflow: hidden;

			background: #F7F5EF;
		}


		.ve-explore-card--atelier .ve-explore-card__image-wrap {

			max-height: 760px;
		}


		.ve-explore-card--consultation .ve-explore-card__image-wrap,
		.ve-explore-card--journal .ve-explore-card__image-wrap {

			aspect-ratio: 3 / 2;
		}


		.ve-explore-card__image {

			display: block;

			width: 100% !important;

			max-width: none !important;

			height: auto;

			margin: 0 !important;

			padding: 0 !important;

			object-fit: cover;

			transition: transform 700ms cubic-bezier(0.22, 1, 0.36, 1);
		}


		.ve-explore-card--atelier .ve-explore-card__image {

			aspect-ratio: 2 / 3;

			object-fit: cover;

			object-position: center center;
		}


		.ve-explore-card--consultation .ve-explore-card__image,
		.ve-explore-card--journal .ve-explore-card__image {

			height: 100%;

			object-fit: cover;
		}


		.ve-explore-card:hover .ve-explore-card__image {

			transform: scale(1.025);
		}


		.ve-explore-card__content {

			padding-top: 30px;
		}


		.ve-explore-card__eyebrow {

			margin: 0 0 18px;

			color: #1F4D3A;

			font-size: 10px;

			font-weight: 600;

			line-height: 1.2;

			letter-spacing: 0.20em;

			text-transform: uppercase;
		}


		.ve-explore-card__title {

			max-width: 680px;

			margin: 0;

			color: #111111;

			font-size: clamp(25px, 3vw, 38px);

			font-weight: 500;

			line-height: 1.18;

			letter-spacing: -0.025em;
		}


		.ve-explore-card--consultation .ve-explore-card__title,
		.ve-explore-card--journal .ve-explore-card__title {

			font-size: clamp(23px, 2.5vw, 32px);
		}


		.ve-explore-card__supporting {

			max-width: 520px;

			margin: 20px 0 0;

			color: #555555;

			font-size: 16px;

			line-height: 1.65;
		}


		.ve-explore-card__cta {

			display: inline-flex;

			align-items: center;

			gap: 9px;

			margin-top: 28px;

			color: #111111;

			font-size: 13px;

			font-weight: 600;

			line-height: 1.4;

			text-decoration: underline;

			text-decoration-thickness: 1px;

			text-underline-offset: 6px;

			transition: color 260ms ease;
		}


		.ve-explore-card__cta span {

			transition: transform 260ms ease;
		}


		.ve-explore-card:hover .ve-explore-card__cta {

			color: #1F4D3A;
		}


		.ve-explore-card:hover .ve-explore-card__cta span {

			transform: translateX(5px);
		}


		/* =========================================================
		   SECTION 4 — MOBILE
		========================================================= */

		@media (max-width: 640px) {

			.ve-explore__inner {

				padding:
					100px
					22px
					110px;
			}


			.ve-explore__header {

				margin-bottom: 54px;
			}


			.ve-explore__title {

				font-size:
					clamp(
						36px,
						10.5vw,
						44px
					);

				line-height: 1.10;

				letter-spacing: -0.03em;
			}


			.ve-explore__grid {

				display: block;
			}


			.ve-explore-card {

				margin-bottom: 72px;
			}


			.ve-explore-card:last-child {

				margin-bottom: 0;
			}


			.ve-explore-card--atelier .ve-explore-card__image-wrap {

				max-height: none;
			}


			.ve-explore-card__content {

				padding-top: 26px;
			}


			.ve-explore-card__eyebrow {

				margin-bottom: 16px;

				font-size: 10px;

				letter-spacing: 0.19em;
			}


			.ve-explore-card__title,
			.ve-explore-card--consultation .ve-explore-card__title,
			.ve-explore-card--journal .ve-explore-card__title {

				font-size: 25px;

				line-height: 1.20;
			}


			.ve-explore-card__supporting {

				margin-top: 18px;

				font-size: 16px;

				line-height: 1.65;
			}


			.ve-explore-card__cta {

				margin-top: 25px;

				font-size: 13px;
			}
		}
		/* =========================================================
		   SECTION 5 — WHY VESTIS
		========================================================= */

		.ve-why {

			background: #111111;

			color: #F7F5EF;

			overflow: hidden;
		}


		.ve-why__inner {

			width: min(100%, 1180px);

			margin: 0 auto;

			padding:
				clamp(110px, 11vw, 160px)
				32px
				clamp(110px, 11vw, 160px);

			box-sizing: border-box;
		}


		.ve-why__header {

			max-width: 850px;

			margin-bottom: clamp(80px, 9vw, 120px);
		}


		.ve-why__eyebrow {

			margin: 0 0 28px;

			color: #5E9B7D;

			font-size: 10px;

			font-weight: 600;

			line-height: 1.2;

			letter-spacing: 0.20em;

			text-transform: uppercase;
		}


		.ve-why__title {

			margin: 0;

			color: #F7F5EF !important;

			font-size: clamp(42px, 5.5vw, 68px);

			font-weight: 500;

			line-height: 1.08;

			letter-spacing: -0.035em;
		}


		.ve-why__intro {

			max-width: 720px;

			margin: 30px 0 0;

			color: rgba(247, 245, 239, 0.72);

			font-size: clamp(17px, 1.8vw, 20px);

			line-height: 1.7;
		}


		.ve-why__principles {

			display: grid;

			grid-template-columns:
				repeat(3, minmax(0, 1fr));

			gap: 42px;

			padding-top: 42px;

			border-top: 1px solid rgba(247, 245, 239, 0.16);
		}


		.ve-why__principle {

			min-width: 0;
		}


		.ve-why__number {

			display: block;

			margin-bottom: 28px;

			color: #5E9B7D;

			font-size: 11px;

			font-weight: 600;

			line-height: 1.2;

			letter-spacing: 0.16em;
		}


		.ve-why__principle-title {

			margin: 0;

			color: #F7F5EF;

			font-size: clamp(22px, 2.3vw, 29px);

			font-weight: 500;

			line-height: 1.2;

			letter-spacing: -0.02em;
		}


		.ve-why__principle-text {

			max-width: 330px;

			margin: 20px 0 0;

			color: rgba(247, 245, 239, 0.68);

			font-size: 15px;

			line-height: 1.7;
		}


		.ve-why__closing {

			max-width: 700px;

			margin: clamp(90px, 10vw, 130px) 0 0;

			color: #F7F5EF;

			font-size: clamp(24px, 3vw, 36px);

			font-weight: 500;

			line-height: 1.3;

			letter-spacing: -0.025em;
		}


		/* =========================================================
		   SECTION 5 — MOBILE
		========================================================= */

		@media (max-width: 640px) {

			.ve-why__inner {

				padding:
					90px
					22px
					100px;
			}


			.ve-why__header {

				margin-bottom: 68px;
			}


			.ve-why__eyebrow {

				margin-bottom: 24px;

				font-size: 10px;

				letter-spacing: 0.19em;
			}


			.ve-why__title {

				font-size:
					clamp(
						38px,
						10.5vw,
						46px
					);

				line-height: 1.10;

				letter-spacing: -0.03em;
			}


			.ve-why__intro {

				margin-top: 24px;

				font-size: 16px;

				line-height: 1.7;
			}


			.ve-why__principles {

				display: block;

				padding-top: 0;

				border-top: 0;
			}


			.ve-why__principle {

				padding-top: 32px;

				margin-bottom: 58px;

				border-top: 1px solid rgba(247, 245, 239, 0.16);
			}


			.ve-why__principle:first-child {

				border-top: 0;

				padding-top: 0;
			}


			.ve-why__number {

				margin-bottom: 18px;

				font-size: 10px;
			}


			.ve-why__principle-title {

				font-size: 24px;

				line-height: 1.2;
			}


			.ve-why__principle-text {

				max-width: none;

				margin-top: 16px;

				font-size: 15px;

				line-height: 1.7;
			}


			.ve-why__closing {

				margin-top: 72px;

				font-size: 27px;

				line-height: 1.28;
			}
}

		/* =========================================================
		   TABLET
		========================================================= */

		@media (max-width: 900px) {

			.ve-hero-content__inner,
			.ve-house__inner {

				padding-left: 28px;

				padding-right: 28px;
							.ve-why__principles {

				grid-template-columns:
					repeat(2, minmax(0, 1fr));

				gap: 48px 32px;
			}


			.ve-why__title {

				font-size: clamp(40px, 5vw, 58px);
			}


			.ve-why__intro {

				max-width: 650px;

				font-size: 18px;
			}


			.ve-why__closing {

				max-width: 620px;
			}
			
		}


		/* =========================================================
		   MOBILE
		========================================================= */

		@media (max-width: 640px) {

			.ve-hero-content__inner {

				padding:
					120px
					22px
					130px;
			}


			.ve-hero-content__eyebrow {

				margin-bottom: 34px;

				font-size: 11px;

				letter-spacing: 0.19em;
			}


			.ve-hero-content__title {

				font-size:
					clamp(
						38px,
						11vw,
						46px
					);

				line-height: 1.10;

				letter-spacing: -0.03em;
			}


			.ve-hero-content__supporting {

				margin-top: 38px;

				font-size: 16px;

				line-height: 1.65;
			}


			.ve-hero-content__actions {

				align-items: stretch;

				flex-direction: column;

				gap: 24px;

				margin-top: 52px;
			}


			.ve-button--primary {

				width: 100%;

				min-height: 56px;
			}


			.ve-button--secondary {

				align-self: flex-start;
			}


			.ve-hero-image {

				margin-top: 32px !important;
			}


			/* Section 3 */

			.ve-house__inner {

				padding:
					100px
					22px
					55px;
			}


			.ve-house__eyebrow {

				margin-bottom: 30px;

				font-size: 10px;

				letter-spacing: 0.19em;
			}


			.ve-house__title {

				font-size:
					clamp(
						36px,
						10.5vw,
						44px
					);

				line-height: 1.10;

				letter-spacing: -0.03em;
			}


			.ve-house__body {

				margin-top: 34px;

				font-size: 16px;

				line-height: 1.72;
			}


			.ve-house__closing {

				margin-top: 42px;

				font-size: 21px;

				line-height: 1.4;
			}
		}


		/* =========================================================
		   REDUCED MOTION
		========================================================= */

		@media (prefers-reduced-motion: reduce) {

			.ve-hero-content__eyebrow,
			.ve-hero-content__title,
			.ve-hero-content__supporting,
			.ve-hero-content__actions,
			.ve-hero-image__media {

				animation: none;
			}
		}
		/* =========================================================
		   SECTION 6 — CLIENT EXPERIENCE
		========================================================= */

		.ve-client-experience {

			background: #FFFFFF;

			color: #111111;

			overflow: hidden;
		}


		.ve-client-experience__inner {

			width: min(100%, 1180px);

			margin: 0 auto;

			padding:
				clamp(110px, 11vw, 160px)
				32px
				clamp(110px, 11vw, 160px);

			box-sizing: border-box;
		}


		.ve-client-experience__header {

			max-width: 780px;

			margin-bottom: clamp(70px, 8vw, 110px);
		}


		.ve-client-experience__eyebrow {

			margin: 0 0 28px;

			color: #1F4D3A;

			font-size: 10px;

			font-weight: 600;

			line-height: 1.2;

			letter-spacing: 0.20em;

			text-transform: uppercase;
		}


		.ve-client-experience__title {

			margin: 0;

			color: #111111;

			font-size: clamp(42px, 5.5vw, 68px);

			font-weight: 500;

			line-height: 1.08;

			letter-spacing: -0.035em;
		}


		.ve-client-experience__proof {

			display: grid;

			grid-template-columns:
				minmax(0, 1.15fr)
				minmax(260px, 0.85fr);

			align-items: start;

			gap: clamp(28px, 5vw, 72px);

			max-width: 1050px;

			margin: 0 auto;
		}


		.ve-testimonial-proof {

			margin: 0;

			overflow: hidden;

			background: #F4F3EF;
		}


		.ve-testimonial-proof img {

			display: block;

			width: 100%;

			height: auto;

			max-width: 100%;

			object-fit: contain;
		}


		.ve-testimonial-proof--primary {

			margin-top: 0;
		}


		.ve-testimonial-proof--secondary {

			margin-top: clamp(70px, 10vw, 140px);
		}


		.ve-client-experience__quote {

			max-width: 760px;

			margin:
				clamp(90px, 10vw, 135px)
				auto
				0;

			padding: 0;

			border: 0;
		}


		.ve-client-experience__quote p {

			margin: 0;

			color: #111111;

			font-family: Georgia, "Times New Roman", serif;

			font-size: clamp(26px, 3.4vw, 42px);

			font-weight: 400;

			line-height: 1.35;

			letter-spacing: -0.02em;
		}


		.ve-client-experience__quote footer {

			margin-top: 28px;

			color: #1F4D3A;

			font-size: 10px;

			font-weight: 600;

			line-height: 1.2;

			letter-spacing: 0.18em;

			text-transform: uppercase;
		}


		/* =========================================================
		   SECTION 6 — MOBILE
		========================================================= */

		@media (max-width: 640px) {

			.ve-client-experience__inner {

				padding:
					90px
					22px
					100px;
			}


			.ve-client-experience__header {

				margin-bottom: 58px;
			}


			.ve-client-experience__eyebrow {

				margin-bottom: 24px;

				font-size: 10px;

				letter-spacing: 0.19em;
			}


			.ve-client-experience__title {

				font-size:
					clamp(
						38px,
						10.5vw,
						46px
					);

				line-height: 1.10;

				letter-spacing: -0.03em;
			}


			.ve-client-experience__proof {

				display: block;

				max-width: 100%;
			}


			.ve-testimonial-proof {

				width: 100%;

				max-width: 100%;
			}


			.ve-testimonial-proof--secondary {

				margin-top: 42px;
			}


			.ve-client-experience__quote {

				margin-top: 72px;
			}


			.ve-client-experience__quote p {

				font-size: 27px;

				line-height: 1.32;
			}

}
					/* =========================================================
		   SECTION 7 — THE ATELIER
		========================================================= */

		.ve-atelier {

			background: #F7F5EF;

			color: #111111;

			overflow: hidden;
		}


		.ve-atelier__inner {

			width: min(100%, 1180px);

			margin: 0 auto;

			padding:
				clamp(110px, 11vw, 170px)
				32px
				clamp(120px, 12vw, 180px);

			box-sizing: border-box;
		}


		.ve-atelier__header {

			margin-bottom: clamp(54px, 6vw, 78px);
		}


		.ve-atelier__title {

			margin: 0;

			color: #111111;

			font-size: clamp(42px, 5.5vw, 68px);

			font-weight: 500;

			line-height: 1.05;

			letter-spacing: -0.04em;
		}


		.ve-atelier__carousel {

			position: relative;

			width: 100%;
		}


		.ve-atelier__track {

			display: flex;

			width: 100%;

			transition:
				transform 650ms cubic-bezier(0.22, 1, 0.36, 1);
		}


		.ve-atelier-product {

			position: relative;

			flex: 0 0 100%;

			min-width: 0;

			display: grid;

			grid-template-columns: minmax(0, 1.12fr) minmax(300px, 0.88fr);

			column-gap: clamp(48px, 7vw, 100px);

			align-items: center;

			box-sizing: border-box;
		}


		.ve-atelier-product__visual {

			position: relative;

			width: 100%;

			overflow: hidden;

			background: #EDEAE2;

			aspect-ratio: 4 / 5;
		}


		.ve-atelier-product__gallery {

			position: relative;

			width: 100%;

			height: 100%;
		}


		.ve-atelier-product__image {

			position: absolute;

			inset: 0;

			display: block;

			width: 100% !important;

			height: 100% !important;

			max-width: none !important;

			margin: 0 !important;

			padding: 0 !important;

			object-fit: cover;

			opacity: 0;

			transition: opacity 650ms ease;
		}


		.ve-atelier-product__image.is-active {

			opacity: 1;
		}


		.ve-atelier-product__content {

			max-width: 500px;

			padding: 20px 0;
		}


		.ve-atelier-product__name {

			margin: 0;

			color: #111111;

			font-family: Georgia, "Times New Roman", serif;

			font-size: clamp(32px, 4vw, 52px);

			font-weight: 400;

			line-height: 1.08;

			letter-spacing: -0.025em;
		}


		.ve-atelier-product__description {

			max-width: 440px;

			margin: 24px 0 0;

			color: #555555;

			font-size: 16px;

			line-height: 1.7;
		}


		.ve-atelier-product__price {

			margin-top: 26px;

			color: #111111;

			font-size: 16px;

			font-weight: 600;

			line-height: 1.4;
		}


		.ve-atelier-product__price del {

			color: #777777;

			font-weight: 400;
		}


		.ve-atelier-product__price ins {

			color: inherit;

			text-decoration: none;
		}


		.ve-atelier-product__actions {

			display: flex;

			align-items: center;

			gap: 20px;

			margin-top: 34px;
		}


		.ve-atelier-product__purchase,
		.ve-atelier-product__cart {

			appearance: none;

			border: 0;

			border-radius: 0;

			font-family: inherit;

			font-size: 12px;

			font-weight: 600;

			line-height: 1.3;

			letter-spacing: 0.10em;

			text-transform: uppercase;

			cursor: pointer;

			transition:
				background-color 220ms ease,
				color 220ms ease,
				border-color 220ms ease;
		}


		.ve-atelier-product__purchase {

			padding: 15px 25px;

			background: #111111;

			color: #FFFFFF;
		}


		.ve-atelier-product__purchase:hover {

			background: #1F4D3A;

			color: #FFFFFF;
		}


		.ve-atelier-product__cart {

			padding: 14px 0;

			background: transparent;

			color: #111111;

			border-bottom: 1px solid #111111;
		}


		.ve-atelier-product__cart:hover {

			color: #1F4D3A;

			border-color: #1F4D3A;
		}


		.ve-atelier-product__details {

			display: inline-block;

			margin-top: 30px;

			color: #111111;

			font-size: 13px;

			font-weight: 600;

			line-height: 1.4;

			text-decoration: none !important;

			border-bottom: 1px solid #111111;

			padding-bottom: 5px;

			transition:
				color 220ms ease,
				border-color 220ms ease;
		}


		.ve-atelier-product__details:hover {

			color: #1F4D3A;

			border-color: #1F4D3A;
		}


		.ve-atelier__navigation {

			display: flex;

			align-items: center;

			gap: 10px;

			margin-top: 38px;
		}


		.ve-atelier__arrow {

			display: inline-flex;

			align-items: center;

			justify-content: center;

			width: 44px;

			height: 44px;

			padding: 0;

			border: 1px solid #C9C6BD;

			border-radius: 50%;

			background: transparent;

			color: #111111;

			font-size: 18px;

			line-height: 1;

			cursor: pointer;

			transition:
				background-color 220ms ease,
				border-color 220ms ease,
				color 220ms ease;
		}


		.ve-atelier__arrow:hover {

			background: #111111;

			border-color: #111111;

			color: #FFFFFF;
		}


		.ve-atelier__swipe-hint {

			margin: 22px 0 0;

			color: #777777;

			font-size: 10px;

			font-weight: 600;

			line-height: 1.3;

			letter-spacing: 0.16em;

			text-transform: uppercase;
		}


		.ve-atelier__footer {

			margin-top: clamp(62px, 7vw, 90px);

			padding-top: 28px;

			border-top: 1px solid #D8D5CC;
		}


		.ve-atelier__full-link {

			display: inline-flex;

			align-items: center;

			color: #111111;

			font-size: 13px;

			font-weight: 600;

			line-height: 1.4;

			text-decoration: none !important;

			border-bottom: 1px solid #111111;

			padding-bottom: 6px;

			transition:
				color 220ms ease,
				border-color 220ms ease;
		}


		.ve-atelier__full-link:hover {

			color: #1F4D3A;

			border-color: #1F4D3A;
		}


		.ve-atelier__empty {

			margin: 0;

			color: #555555;

			font-size: 16px;

			line-height: 1.6;
		}


		.ve-atelier-product__selection {

			position: absolute;

			z-index: 5;

			right: 0;

			bottom: 0;

			left: 0;

			background: rgba(247, 245, 239, 0.98);

			border-top: 1px solid #D8D5CC;

			padding: 24px;
		}


		.ve-atelier-product__selection-inner {

			max-width: 500px;
		}


		.ve-atelier-product__selection-label {

			margin: 0 0 16px;

			color: #111111;

			font-size: 11px;

			font-weight: 600;

			line-height: 1.3;

			letter-spacing: 0.14em;

			text-transform: uppercase;
		}


		.ve-atelier-product__sizes {

			display: flex;

			flex-wrap: wrap;

			gap: 8px;
		}


		.ve-atelier-product__selected-price {

			margin-top: 18px;

			color: #111111;

			font-size: 15px;

			font-weight: 600;
		}


		.ve-atelier-product__confirm {

			margin-top: 20px;

			padding: 13px 22px;

			border: 0;

			border-radius: 0;

			background: #111111;

			color: #FFFFFF;

			font-family: inherit;

			font-size: 11px;

			font-weight: 600;

			letter-spacing: 0.10em;

			text-transform: uppercase;

			cursor: pointer;
		}


		/* =========================================================
		   SECTION 7 — TABLET
		========================================================= */

		@media (max-width: 900px) {

			.ve-atelier-product {

				grid-template-columns: minmax(0, 1fr) minmax(280px, 0.9fr);

				column-gap: 42px;
			}


			.ve-atelier-product__name {

				font-size: clamp(30px, 5vw, 44px);
			}
		}


		/* =========================================================
		   SECTION 7 — MOBILE
		========================================================= */

		@media (max-width: 640px) {

			.ve-atelier__inner {

				padding:
					90px
					22px
					100px;
			}


			.ve-atelier__header {

				margin-bottom: 46px;
			}


			.ve-atelier__title {

				font-size:
					clamp(
						40px,
						11vw,
						50px
					);

				line-height: 1.06;
			}


			.ve-atelier-product {

				display: block;
			}


			.ve-atelier-product__visual {

				aspect-ratio: 4 / 5;
			}


			.ve-atelier-product__content {

				max-width: none;

				padding:
					34px
					0
					10px;
			}


			.ve-atelier-product__name {

				font-size: clamp(32px, 9vw, 42px);

				line-height: 1.08;
			}


			.ve-atelier-product__description {

				margin-top: 20px;

				font-size: 15px;

				line-height: 1.65;
			}


			.ve-atelier-product__price {

				margin-top: 22px;
			}


			.ve-atelier-product__actions {

				gap: 18px;

				margin-top: 28px;
			}


			.ve-atelier-product__purchase {

				padding:
					14px
					21px;
			}


			.ve-atelier-product__details {

				margin-top: 26px;
			}


			.ve-atelier__navigation {

				margin-top: 28px;
			}


			.ve-atelier__arrow {

				width: 42px;

				height: 42px;
			}


			.ve-atelier__swipe-hint {

				margin-top: 18px;

				font-size: 9px;
			}


			.ve-atelier__footer {

				margin-top: 58px;
			}


			.ve-atelier-product__selection {

				position: relative;

				right: auto;

				bottom: auto;

				left: auto;

				margin-top: 20px;
			}

		}
	</style>
	<script>
    document.addEventListener('DOMContentLoaded', function () {

        const carousel = document.querySelector('[data-ve-atelier-carousel]');

        if (!carousel) {
            return;
        }


        const track = carousel.querySelector('.ve-atelier__track');

        const products = Array.from(
            carousel.querySelectorAll('[data-ve-atelier-product]')
        );

        const previousButton = carousel.querySelector('[data-ve-atelier-prev]');

        const nextButton = carousel.querySelector('[data-ve-atelier-next]');


        if (!track || !products.length) {
            return;
        }


        let currentIndex = 0;

        let touchStartX = 0;

        let touchStartY = 0;


        /* =====================================================
           PRODUCT CAROUSEL
        ===================================================== */

        function updateCarousel() {

            track.style.transform =
                'translateX(-' + (currentIndex * 100) + '%)';

            products.forEach(function (product, index) {

                product.setAttribute(
                    'aria-hidden',
                    index === currentIndex ? 'false' : 'true'
                );

            });

        }


        function goToProduct(index) {

            if (index < 0) {
                index = products.length - 1;
            }

            if (index >= products.length) {
                index = 0;
            }


            currentIndex = index;

            updateCarousel();

        }


        function nextProduct() {

            goToProduct(currentIndex + 1);

        }


        function previousProduct() {

            goToProduct(currentIndex - 1);

        }


        if (nextButton) {

            nextButton.addEventListener(
                'click',
                nextProduct
            );

        }


        if (previousButton) {

            previousButton.addEventListener(
                'click',
                previousProduct
            );

        }


        /* =====================================================
           PRODUCT IMAGE GALLERY
           Runs independently from product navigation.
           Never stopped by carousel interaction.
        ===================================================== */

        products.forEach(function (product) {

            const images = Array.from(
                product.querySelectorAll(
                    '.ve-atelier-product__image'
                )
            );


            if (images.length <= 1) {
                return;
            }


            let imageIndex = images.findIndex(function (image) {

                return image.classList.contains('is-active');

            });


            if (imageIndex < 0) {
                imageIndex = 0;

                images[0].classList.add('is-active');
            }


            setInterval(function () {

                images[imageIndex].classList.remove('is-active');


                imageIndex =
                    (imageIndex + 1) % images.length;


                images[imageIndex].classList.add('is-active');

            }, 4000);

        });


        /* =====================================================
           TOUCH / SWIPE
        ===================================================== */

        carousel.addEventListener(
            'touchstart',
            function (event) {

                const touch = event.changedTouches[0];

                touchStartX = touch.clientX;

                touchStartY = touch.clientY;

            },
            { passive: true }
        );


        carousel.addEventListener(
            'touchend',
            function (event) {

                const touch = event.changedTouches[0];

                const deltaX =
                    touch.clientX - touchStartX;

                const deltaY =
                    touch.clientY - touchStartY;


                if (
                    Math.abs(deltaX) < 50 ||
                    Math.abs(deltaX) <= Math.abs(deltaY)
                ) {
                    return;
                }


                if (deltaX < 0) {

                    nextProduct();

                } else {

                    previousProduct();

                }

            },
            { passive: true }
        );


        /* =====================================================
           INITIALISE
        ===================================================== */

        updateCarousel();

    });
			</script>

	<?php

	return ob_get_clean();
}
