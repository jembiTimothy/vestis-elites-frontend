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
		   TABLET
		========================================================= */

		@media (max-width: 900px) {

			.ve-hero-content__inner,
			.ve-house__inner {

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


			/* Section 3 */

			.ve-house__inner {

				padding:
					100px
					22px
					110px;
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

	</style>

	<?php

	return ob_get_clean();
}
