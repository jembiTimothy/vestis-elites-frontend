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


		/* Astra row */

		body.ve-coded-homepage .site-content .ast-row {

			display: block !important;

			width: 100% !important;

			max-width: none !important;

			margin: 0 !important;
		}


		/* Primary content column */

		body.ve-coded-homepage .site-content #primary {

			display: block !important;

			float: none !important;

			width: 100% !important;

			max-width: none !important;

			flex: none !important;

			margin: 0 !important;

			padding: 0 !important;
		}


		/* Remove Astra secondary/sidebar column */

		body.ve-coded-homepage .site-content #secondary {

			display: none !important;

			width: 0 !important;

			max-width: 0 !important;

			margin: 0 !important;

			padding: 0 !important;
		}


		/* Entry */

		body.ve-coded-homepage .site-content .hentry {

			display: block !important;

			width: 100% !important;

			max-width: none !important;

			margin: 0 !important;

			padding: 0 !important;
		}


		/* Entry content */

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
		body.ve-coded-homepage .ve-hero-image {

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
		   TABLET
		========================================================= */

		@media (max-width: 900px) {

			.ve-hero-content__inner {

				padding-left: 28px;

				padding-right: 28px;
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

	</style>

	<?php

	return ob_get_clean();
}
