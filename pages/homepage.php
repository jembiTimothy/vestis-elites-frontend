<?php
/**
 * Vestis Elites — Homepage
 * Section 1: Hero Content
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Find a WordPress page by its exact title.
 * This keeps CTA destinations controlled by WordPress
 * instead of hard-coding URLs into the frontend.
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
 * Homepage — Section 1
 */
function vestis_elites_homepage() {

	$consultation_url = vestis_elites_get_page_url( 'Private Consultation' );
	$atelier_url      = vestis_elites_get_page_url( 'Atelier' );

	ob_start();
	?>

	<section class="ve-hero-content" aria-labelledby="ve-hero-title">

		<div class="ve-hero-content__inner">

			<p class="ve-hero-content__eyebrow">
				VESTIS ELITES
			</p>

			<h1 id="ve-hero-title" class="ve-hero-content__title">
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
						<span class="ve-button__arrow" aria-hidden="true">→</span>
					</a>

				<?php endif; ?>

			</div>

		</div>

	</section>

	<style>
		/* =========================================================
		   VESTIS ELITES — HERO CONTENT
		   Section 1 only
		   ========================================================= */

		.ve-hero-content {
			width: 100%;
			background: #000000;
			color: #F7F5EF;
			overflow: hidden;
		}

		.ve-hero-content__inner {
			width: min(100%, 1180px);
			margin: 0 auto;
			padding: clamp(96px, 11vw, 156px) 32px
						clamp(92px, 10vw, 140px);

			box-sizing: border-box;
		}

		/* Eyebrow */

		.ve-hero-content__eyebrow {
			margin: 0 0 28px;
			color: #1F4D3A;
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
			line-height: 1.04;
			letter-spacing: -0.035em;
			text-wrap: balance;
		}

		/* Supporting copy */

		.ve-hero-content__supporting {
			max-width: 540px;
			margin: 32px 0 0;
			color: rgba(247, 245, 239, 0.76);
			font-size: clamp(16px, 1.4vw, 18px);
			font-weight: 400;
			line-height: 1.6;
			letter-spacing: 0;
		}

		/* CTA group */

		.ve-hero-content__actions {
			display: flex;
			align-items: center;
			flex-wrap: wrap;
			gap: 28px;
			margin-top: 44px;
		}

		/* Shared CTA */

		.ve-button {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			min-height: 52px;
			box-sizing: border-box;
			font-size: 14px;
			font-weight: 600;
			line-height: 1;
			letter-spacing: 0.01em;
			text-decoration: none;
			transition:
				background-color 220ms ease,
				color 220ms ease,
				border-color 220ms ease,
				transform 220ms ease,
				opacity 220ms ease;
		}

		/* Primary CTA */

		.ve-button--primary {
			padding: 0 27px;
			background: #F7F5EF;
			color: #000000;
			border: 1px solid #F7F5EF;
		}

		.ve-button--primary:hover,
		.ve-button--primary:focus-visible {
			background: #1F4D3A;
			color: #FFFFFF;
			border-color: #1F4D3A;
			transform: translateY(-2px);
		}

		/* Secondary CTA */

		.ve-button--secondary {
			min-height: auto;
			padding: 12px 0;
			gap: 8px;
			color: #F7F5EF;
			border: 0;
		}

		.ve-button--secondary:hover,
		.ve-button--secondary:focus-visible {
			color: #1F4D3A;
		}

		.ve-button__arrow {
			display: inline-block;
			transition: transform 220ms ease;
		}

		.ve-button--secondary:hover .ve-button__arrow,
		.ve-button--secondary:focus-visible .ve-button__arrow {
			transform: translateX(4px);
		}

		/* Keyboard accessibility */

		.ve-button:focus-visible {
			outline: 2px solid #1F4D3A;
			outline-offset: 5px;
		}

		/* Entrance animation */

		.ve-hero-content__eyebrow,
		.ve-hero-content__title,
		.ve-hero-content__supporting,
		.ve-hero-content__actions {
			animation: veHeroReveal 700ms cubic-bezier(0.22, 1, 0.36, 1) both;
		}

		.ve-hero-content__eyebrow {
			animation-delay: 0ms;
		}

		.ve-hero-content__title {
			animation-delay: 90ms;
		}

		.ve-hero-content__supporting {
			animation-delay: 180ms;
		}

		.ve-hero-content__actions {
			animation-delay: 270ms;
		}

		@keyframes veHeroReveal {

			from {
				opacity: 0;
				transform: translateY(14px);
			}

			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		/* Tablet */

		@media (max-width: 900px) {

			.ve-hero-content__inner {
				padding-left: 28px;
				padding-right: 28px;
			}

			.ve-hero-content__title {
				max-width: 650px;
			}
		}

		/* Mobile */

		@media (max-width: 640px) {

			.ve-hero-content__inner {
				padding: 88px 22px 84px;
			}

			.ve-hero-content__eyebrow {
				margin-bottom: 24px;
				font-size: 11px;
				letter-spacing: 0.19em;
			}

			.ve-hero-content__title {
				max-width: 100%;
				font-size: clamp(38px, 11vw, 46px);
				line-height: 1.04;
				letter-spacing: -0.03em;
			}

			.ve-hero-content__supporting {
				max-width: 430px;
				margin-top: 26px;
				font-size: 16px;
				line-height: 1.55;
			}

			.ve-hero-content__actions {
				align-items: stretch;
				flex-direction: column;
				gap: 18px;
				margin-top: 36px;
			}

			.ve-button--primary {
				width: 100%;
				min-height: 52px;
			}

			.ve-button--secondary {
				align-self: flex-start;
				padding: 10px 0;
			}
		}

		/* Reduced motion */

		@media (prefers-reduced-motion: reduce) {

			.ve-hero-content__eyebrow,
			.ve-hero-content__title,
			.ve-hero-content__supporting,
			.ve-hero-content__actions {
				animation: none;
			}

			.ve-button,
			.ve-button__arrow {
				transition: none;
			}
		}
	</style>

	<?php
	return ob_get_clean();
}
