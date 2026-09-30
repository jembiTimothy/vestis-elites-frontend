<?php
/**
 * Vestis Elites — Homepage
 *
 * Section 1: Hero Content
 * Section 2: Hero Image
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Find a published WordPress page by title
 * and return its current permalink.
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
 * Homepage.
 */
function vestis_elites_homepage() {

	/* ---------------------------------------------------------
	   CTA DESTINATIONS
	   --------------------------------------------------------- */

	$consultation_url = vestis_elites_get_page_url( 'Private Consultation' );
	$atelier_url      = vestis_elites_get_page_url( 'Atelier' );


	/* ---------------------------------------------------------
	   HERO IMAGES
	   --------------------------------------------------------- */

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
	     SECTION 1 — HERO CONTENT
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
		   SECTION 1 — HERO CONTENT
		   ========================================================= */

		.ve-hero-content {

			width: 100vw;

			margin-left: calc(50% - 50vw);

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


		/* EYEBROW */

		.ve-hero-content__eyebrow {

			margin: 0 0 40px;

			color: #5E9B7D;

			font-size: 12px;

			font-weight: 600;

			line-height: 1.2;

			letter-spacing: 0.20em;

			text-transform: uppercase;
		}


		/* H1 */

		.ve-hero-content__title {

			max-width: 760px;

			margin: 0;

			color: #F7F5EF;

			font-size: clamp(42px, 5.2vw, 68px);

			font-weight: 500;

			line-height: 1.10;

			letter-spacing: -0.035em;

			text-wrap: balance;
		}


		/* SUPPORTING COPY */

		.ve-hero-content__supporting {

			max-width: 540px;

			margin: 42px 0 0;

			color: rgba(247, 245, 239, 0.76);

			font-size: clamp(16px, 1.4vw, 18px);

			font-weight: 400;

			line-height: 1.65;
		}


		/* CTA GROUP */

		.ve-hero-content__actions {

			display: flex;

			align-items: center;

			flex-wrap: wrap;

			gap: 34px;

			margin-top: 58px;
		}


		/* PRIMARY CTA */

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

			box-sizing: border-box;

			background: #F7F5EF;

			color: #000000;

			border: 1px solid #F7F5EF;

			font-size: 14px;

			font-weight: 600;

			line-height: 1;

			letter-spacing: 0.01em;

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


		/* SECONDARY CTA */

		.ve-button--secondary {

			display: inline-flex;

			align-items: center;

			justify-content: center;

			min-height: 44px;

			padding: 10px 0;

			gap: 9px;

			box-sizing: border-box;

			color: #F7F5EF;

			border: 0;

			font-size: 14px;

			font-weight: 600;

			line-height: 1;

			letter-spacing: 0.01em;

			text-decoration: underline;

			text-decoration-thickness: 1px;

			text-underline-offset: 6px;

			transition:
				color 260ms ease,
				text-decoration-color 260ms ease;
		}


		.ve-button--secondary:hover,
		.ve-button--secondary:focus-visible {

			color: #1F4D3A;
		}


		.ve-button__arrow {

			display: inline-block;

			transition:
				transform 260ms ease;
		}


		.ve-button--secondary:hover .ve-button__arrow,
		.ve-button--secondary:focus-visible .ve-button__arrow {

			transform: translateX(5px);
		}


		/* ACCESSIBILITY */

		.ve-button:focus-visible {

			outline: 2px solid #1F4D3A;

			outline-offset: 6px;
		}


		/* QUIET ENTRANCE ANIMATION */

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
		   SECTION 2 — HERO IMAGE
		   ========================================================= */

		.ve-hero-image {

			width: 100vw;

			margin-left: calc(50% - 50vw);

			/*
			 * Controlled ivory breathing space between
			 * the statement and the editorial image.
			 */

			margin-top: 48px;

			padding: 0;

			background: #F7F5EF;

			overflow: hidden;
		}


		.ve-hero-image picture {

			display: block;

			width: 100%;
		}


		.ve-hero-image__media {

			display: block;

			width: 100%;

			height: auto;

			margin: 0;

			padding: 0;

			object-fit: cover;

			object-position: center center;

			transform: scale(1.001);

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


			.ve-hero-content__title {

				max-width: 650px;
			}


			.ve-hero-image {

				margin-top: 48px;
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

				max-width: 100%;

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

				max-width: 430px;

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

				min-height: 44px;

				padding: 10px 0;
			}


			/* MOBILE IMAGE */

			.ve-hero-image {

				margin-top: 32px;
			}


			.ve-hero-image__media {

				width: 100%;

				height: auto;

				object-fit: cover;

				object-position: center center;
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


			.ve-button--primary,
			.ve-button--secondary,
			.ve-button__arrow {

				transition: none;
			}
		}

	</style>


	<?php

	return ob_get_clean();
}
