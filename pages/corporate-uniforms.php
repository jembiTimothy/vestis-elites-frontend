
<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the Vestis Elites Branded Clothing & Uniform Solutions page.
 *
 * Page: Branded Clothing & Uniform Solutions
 * Shortcode: [vestis_corporate_uniforms]
 */

function vestis_elites_corporate_uniforms_page() {

	ob_start();

	$corporate_whatsapp_message = "Hello Vestis Elites,\n\nI would like to make an enquiry about your Branded Clothing & Uniform Solutions.\n\nI would like to discuss my clothing requirements and the available options.\n\nPlease guide me on the next steps.";

	$corporate_whatsapp_url = 'https://wa.me/2347032681868?text=' . rawurlencode( $corporate_whatsapp_message );

	$corporate_hero_image = 'https://vestiselites.com.ng/wp-content/uploads/2026/11/vestis-elites-branded-corporate-uniforms-team.webp';

	$individuals_image = 'https://vestiselites.com.ng/wp-content/uploads/2026/11/vestis-elites-personalised-clothing-individuals.webp';

	?>

	<!-- =========================================================
	     SECTION 1 — HERO INTRODUCTION
	========================================================= -->

	<section
		class="ve-corporate-hero"
		aria-labelledby="ve-corporate-hero-title"
	>

		<div class="ve-corporate-hero__inner">

			<p class="ve-corporate-hero__eyebrow">
				VESTIS ELITES
			</p>

			<h1
				id="ve-corporate-hero-title"
				class="ve-corporate-hero__title"
			>
				Branded Clothing &amp; Uniform Solutions
			</h1>

			<p class="ve-corporate-hero__supporting">
				We design and produce uniforms, branded clothing,
				event T-shirts and sports jerseys for businesses,
				schools, organisations and teams.
			</p>

			<div class="ve-corporate-hero__actions">

				<a
					class="ve-corporate-hero__cta"
					href="<?php echo esc_url( $corporate_whatsapp_url ); ?>"
					target="_blank"
					rel="noopener noreferrer"
				>
					Book a Private Consultation
					<span aria-hidden="true">→</span>
				</a>

			</div>

		</div>

	</section>


	<!-- =========================================================
	     SECTION 2 — HERO IMAGE
	========================================================= -->

	<section
		class="ve-corporate-hero-image"
		aria-label="Vestis Elites branded corporate clothing"
	>

		<div class="ve-corporate-hero-image__inner">

			<img
				class="ve-corporate-hero-image__media"
				src="<?php echo esc_url( $corporate_hero_image ); ?>"
				alt="Five Nigerian professionals wearing coordinated Vestis Elites branded corporate polo shirts in emerald green and black, collaborating in a modern office."
				width="1672"
				height="941"
				loading="eager"
				fetchpriority="high"
				decoding="async"
			>

		</div>

	</section>


	<!-- =========================================================
	     SECTION 3 — WHO WE SERVE
	========================================================= -->

	<section
		class="ve-who-we-serve"
		aria-labelledby="ve-who-we-serve-title"
	>

		<div class="ve-who-we-serve__container">

			<h2
				id="ve-who-we-serve-title"
				class="ve-who-we-serve__heading"
			>
				Who We Serve
			</h2>


			<!-- =============================================
			     CATEGORY 1 — INDIVIDUALS
			============================================== -->

			<article
				class="ve-individuals"
				aria-labelledby="ve-individuals-title"
			>

				<div class="ve-individuals__main">

					<div class="ve-individuals__image-wrap">

						<img
							class="ve-individuals__image"
							src="<?php echo esc_url( $individuals_image ); ?>"
							alt="Vestis Elites personalised clothing featuring custom polo shirts, sports jerseys, hoodies, caps and matching T-shirts."
							width="1536"
							height="1024"
							loading="lazy"
							decoding="async"
						>

					</div>


					<div class="ve-individuals__content">

						<h3
							id="ve-individuals-title"
							class="ve-individuals__title"
						>
							Individuals
						</h3>

						<p class="ve-individuals__statement">
							Your clothing should reflect the standard
							you choose to present to the world.
						</p>

						<p class="ve-individuals__story">
							Imagine heading out for a relaxed weekend
							with friends, wearing a polo shirt designed
							around your personal taste, with your name
							or nickname embroidered on it. Perhaps you
							want a customised jersey to wear while
							watching your favourite team, or a matching
							set of T-shirts for a special occasion.
							Sometimes, it's simply about having
							something made that feels unmistakably yours.
						</p>


						<details class="ve-individuals__details">

							<summary class="ve-individuals__read-more">

								<span>Read More</span>

								<svg
									class="ve-individuals__read-icon"
									viewBox="0 0 24 24"
									width="20"
									height="20"
									fill="none"
									aria-hidden="true"
								>
									<path
										d="M6 9L12 15L18 9"
										stroke="currentColor"
										stroke-width="2"
										stroke-linecap="round"
										stroke-linejoin="round"
									/>
								</svg>

							</summary>


							<div class="ve-individuals__expanded">

								<div class="ve-individuals__expanded-copy">

									<p>
										At Vestis Elites, you can have
										clothing made to suit your personal
										style, your ideas and your needs.
									</p>

									<p>
										You can choose personalised
										T-shirts and polo shirts,
										customised sports jerseys,
										sweatshirts and hoodies, matching
										clothing for couples, friends and
										family, or other clothing designs
										you have in mind.
									</p>

									<p>
										You can bring us your own design
										or reference, or simply explain
										what you would like. We will
										discuss the available options,
										design details and production
										requirements with you.
									</p>

									<p>
										Whether you need one piece or a
										small personal order, we aim to
										make the process straightforward
										and give attention to the details
										of your clothing.
									</p>

								</div>


								<div
									class="ve-individuals__options"
									aria-label="Personalised clothing options"
								>

									<div class="ve-individuals__option">

										<span
											class="ve-individuals__option-number"
											aria-hidden="true"
										>
											01
										</span>

										<span>
											Personalised<br>
											T-shirts
										</span>

									</div>


									<div class="ve-individuals__option">

										<span
											class="ve-individuals__option-number"
											aria-hidden="true"
										>
											02
										</span>

										<span>
											Personalised<br>
											Polo Shirts
										</span>

									</div>


									<div class="ve-individuals__option">

										<span
											class="ve-individuals__option-number"
											aria-hidden="true"
										>
											03
										</span>

										<span>
											Customised<br>
											Jerseys
										</span>

									</div>


									<div class="ve-individuals__option">

										<span
											class="ve-individuals__option-number"
											aria-hidden="true"
										>
											04
										</span>

										<span>
											Sweatshirts<br>
											&amp; Hoodies
										</span>

									</div>


									<div class="ve-individuals__option">

										<span
											class="ve-individuals__option-number"
											aria-hidden="true"
										>
											05
										</span>

										<span>
											Matching Clothing<br>
											<small>Couples, Friends &amp; Family</small>
										</span>

									</div>


									<div class="ve-individuals__option">

										<span
											class="ve-individuals__option-number"
											aria-hidden="true"
										>
											06
										</span>

										<span>
											Other Individual<br>
											Custom Clothing Requests
										</span>

									</div>

								</div>


								<button
									class="ve-individuals__close"
									type="button"
								>

									<svg
										viewBox="0 0 24 24"
										width="18"
										height="18"
										fill="none"
										aria-hidden="true"
									>
										<path
											d="M6 15L12 9L18 15"
											stroke="currentColor"
											stroke-width="2"
											stroke-linecap="round"
											stroke-linejoin="round"
										/>
									</svg>

									<span>Close</span>

								</button>

							</div>

						</details>

					</div>

				</div>

			</article>

		</div>

	</section>


	<style>

	/* =========================================================
	   CORPORATE HERO — BASE
	========================================================= */

	.ve-corporate-hero,
	.ve-corporate-hero *,
	.ve-corporate-hero-image,
	.ve-corporate-hero-image * {
		box-sizing: border-box;
	}

	.ve-corporate-hero {
		width: 100%;
		background: #000000;
		color: #F7F5EF;
		overflow: hidden;
	}

	.ve-corporate-hero__inner {
		width: min(100%, 1180px);
		margin: 0 auto;
		padding:
			clamp(140px, 14vw, 190px)
			32px
			76px;
	}

	.ve-corporate-hero__eyebrow {
		margin: 0 0 40px;
		color: #5E9B7D;
		font-size: 12px;
		font-weight: 600;
		line-height: 1.2;
		letter-spacing: 0.20em;
		text-transform: uppercase;

		animation: veCorporateReveal 1500ms
			cubic-bezier(0.22, 1, 0.36, 1) both;
		animation-delay: 0ms;
	}

	.ve-corporate-hero__title {
		max-width: 900px;
		margin: 0;
		color: #F7F5EF;
		font-size: clamp(42px, 5.2vw, 68px);
		font-weight: 500;
		line-height: 1.10;
		letter-spacing: -0.035em;

		animation: veCorporateReveal 1500ms
			cubic-bezier(0.22, 1, 0.36, 1) both;
		animation-delay: 300ms;
	}

	.ve-corporate-hero__supporting {
		max-width: 620px;
		margin: 42px 0 0;
		color: rgba(247, 245, 239, 0.76);
		font-size: clamp(16px, 1.4vw, 18px);
		line-height: 1.65;

		animation: veCorporateReveal 1500ms
			cubic-bezier(0.22, 1, 0.36, 1) both;
		animation-delay: 600ms;
	}

	.ve-corporate-hero__actions {
		display: flex;
		align-items: center;
		margin-top: 58px;

		animation: veCorporateReveal 1500ms
			cubic-bezier(0.22, 1, 0.36, 1) both;
		animation-delay: 900ms;
	}


	/* =========================================================
	   CORPORATE HERO — WHATSAPP CTA
	========================================================= */

	.ve-corporate-hero__cta,
	.ve-corporate-hero__cta:visited {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 14px;
		min-height: 54px;
		padding: 0 30px;
		background: #F7F5EF;
		color: #000000;
		border: 1px solid #F7F5EF;
		font-size: 14px;
		font-weight: 600;
		line-height: 1;
		text-decoration: none !important;
		transition:
			background-color 260ms ease,
			color 260ms ease,
			border-color 260ms ease,
			transform 260ms ease;
	}

	.ve-corporate-hero__cta:hover,
	.ve-corporate-hero__cta:focus-visible {
		background: #1F4D3A;
		color: #FFFFFF;
		border-color: #1F4D3A;
		transform: translateY(-2px);
	}

	.ve-corporate-hero__cta span {
		transition: transform 260ms ease;
	}

	.ve-corporate-hero__cta:hover span {
		transform: translateX(5px);
	}


	/* =========================================================
	   CORPORATE HERO — IMAGE
	========================================================= */

	.ve-corporate-hero-image {
		width: 100%;
		background: #000000;
		overflow: hidden;
	}

	.ve-corporate-hero-image__inner {
		width: min(100%, 1180px);
		margin: 0 auto;
		padding: 0 32px 90px;
	}

	.ve-corporate-hero-image__media {
		display: block;
		width: 100%;
		height: auto;
		aspect-ratio: 1672 / 941;
		object-fit: cover;
		object-position: center;
		border: 0;
		border-radius: 0;
	}


	/* =========================================================
	   HERO REVEAL ANIMATION
	========================================================= */

	@keyframes veCorporateReveal {
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
	   WHO WE SERVE — SECTION BASE
	========================================================= */

	.ve-who-we-serve,
	.ve-who-we-serve * {
		box-sizing: border-box;
	}

	.ve-who-we-serve {
		width: 100%;
		background: #F7F5EF;
		color: #000000;
		padding: 95px 24px 110px;
	}

	.ve-who-we-serve__container {
		width: min(100%, 1180px);
		margin: 0 auto;
	}

	.ve-who-we-serve__heading {
		margin: 0 0 58px;
		color: #000000;
		font-family: Georgia, "Times New Roman", serif;
		font-size: clamp(38px, 5vw, 58px);
		font-weight: 400;
		line-height: 1.12;
		letter-spacing: -0.035em;
		text-align: center;
	}


	/* =========================================================
	   INDIVIDUALS — MAIN CARD
	========================================================= */

	.ve-individuals {
		width: 100%;
		padding: 28px;
		border: 1px solid #D5D0C2;
		border-radius: 10px;
		background: rgba(255, 255, 255, 0.28);
	}

	.ve-individuals__main {
		display: grid;
		grid-template-columns: minmax(0, 0.88fr) minmax(0, 1.12fr);
		gap: 48px;
		align-items: start;
	}

	.ve-individuals__image-wrap {
		width: 100%;
		overflow: hidden;
		background: #E9E3D6;
	}

	.ve-individuals__image {
		display: block;
		width: 100%;
		height: auto;
		aspect-ratio: 3 / 2;
		object-fit: cover;
		object-position: center;
	}

	.ve-individuals__content {
		min-width: 0;
		padding: 5px 0 0;
	}

	.ve-individuals__title {
		margin: 0 0 12px;
		color: #000000;
		font-family: Georgia, "Times New Roman", serif;
		font-size: clamp(38px, 4vw, 54px);
		font-weight: 400;
		line-height: 1.08;
		letter-spacing: -0.03em;
	}

	.ve-individuals__statement {
		margin: 0 0 18px;
		color: #1F4D3A;
		font-size: clamp(18px, 1.8vw, 22px);
		font-weight: 600;
		line-height: 1.45;
	}

	.ve-individuals__story {
		margin: 0;
		color: #282823;
		font-size: 16px;
		line-height: 1.75;
	}


	/* =========================================================
	   INDIVIDUALS — READ MORE
	========================================================= */

	.ve-individuals__details {
		margin-top: 22px;
	}

	.ve-individuals__read-more {
		display: inline-flex;
		align-items: center;
		gap: 12px;
		width: fit-content;
		color: #1F4D3A;
		font-size: 17px;
		font-weight: 600;
		line-height: 1.5;
		cursor: pointer;
		list-style: none;
	}

	.ve-individuals__read-more::-webkit-details-marker {
		display: none;
	}

	.ve-individuals__read-more::marker {
		display: none;
		content: "";
	}

	.ve-individuals__read-more:focus-visible,
	.ve-individuals__close:focus-visible {
		outline: 2px solid #1F4D3A;
		outline-offset: 5px;
	}

	.ve-individuals__read-icon {
		flex: 0 0 auto;
		transition: transform 280ms ease;
	}

	.ve-individuals__details[open] .ve-individuals__read-icon {
		transform: rotate(180deg);
	}

	.ve-individuals__expanded {
		margin-top: 24px;
		padding: 28px;
		background: #EFEEE4;
		border: 1px solid #E0DFD2;
		border-radius: 10px;
		animation: veIndividualsExpand 350ms ease both;
	}

	.ve-individuals__expanded-copy p {
		margin: 0 0 14px;
		color: #282823;
		font-size: 15px;
		line-height: 1.8;
	}

	.ve-individuals__expanded-copy p:last-child {
		margin-bottom: 0;
	}


	/* =========================================================
	   INDIVIDUALS — CLOTHING OPTIONS
	========================================================= */

	.ve-individuals__options {
		display: grid;
		grid-template-columns: repeat(3, minmax(0, 1fr));
		margin-top: 32px;
		border-top: 1px solid #D2D0C1;
		border-left: 1px solid #D2D0C1;
	}

	.ve-individuals__option {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		gap: 10px;
		min-height: 112px;
		padding: 18px 12px;
		border-right: 1px solid #D2D0C1;
		border-bottom: 1px solid #D2D0C1;
		color: #11110E;
		font-size: 14px;
		font-weight: 600;
		line-height: 1.5;
		text-align: center;
	}

	.ve-individuals__option-number {
		color: #1F4D3A;
		font-family: Georgia, "Times New Roman", serif;
		font-size: 25px;
		font-weight: 400;
		line-height: 1;
	}

	.ve-individuals__option small {
		font-size: 11px;
		font-weight: 400;
	}


	/* =========================================================
	   INDIVIDUALS — CLOSE CONTROL
	========================================================= */

	.ve-individuals__close {
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 10px;
		margin: 26px auto 0;
		padding: 8px 14px;
		background: transparent;
		border: 0;
		color: #1F4D3A;
		font-family: inherit;
		font-size: 16px;
		font-weight: 600;
		cursor: pointer;
	}

	.ve-individuals__close svg {
		flex: 0 0 auto;
	}


	/* =========================================================
	   EXPANSION ANIMATION
	========================================================= */

	@keyframes veIndividualsExpand {
		from {
			opacity: 0;
			transform: translateY(8px);
		}

		to {
			opacity: 1;
			transform: translateY(0);
		}
	}


	/* =========================================================
	   MOBILE RESPONSIVENESS
	========================================================= */

	@media (max-width: 760px) {

		.ve-who-we-serve {
			padding: 70px 20px 80px;
		}

		.ve-who-we-serve__heading {
			margin-bottom: 38px;
		}

		.ve-individuals {
			padding: 18px;
		}

		.ve-individuals__main {
			grid-template-columns: 1fr;
			gap: 28px;
		}

		.ve-individuals__image-wrap {
			max-width: 100%;
		}

		.ve-individuals__content {
			padding-top: 0;
		}

		.ve-individuals__title {
			font-size: 40px;
		}

		.ve-individuals__statement {
			font-size: 19px;
		}

		.ve-individuals__story {
			font-size: 15px;
			line-height: 1.75;
		}

		.ve-individuals__expanded {
			padding: 20px;
		}

		.ve-individuals__options {
			grid-template-columns: repeat(2, minmax(0, 1fr));
			margin-top: 25px;
		}

		.ve-individuals__option {
			min-height: 105px;
			padding: 15px 8px;
			font-size: 13px;
		}

	}

	@media (max-width: 420px) {

		.ve-individuals {
			padding: 13px;
		}

		.ve-individuals__expanded {
			padding: 16px;
		}

		.ve-individuals__option {
			font-size: 12px;
		}

	}


	/* =========================================================
	   ACCESSIBILITY — REDUCED MOTION
	========================================================= */

	@media (prefers-reduced-motion: reduce) {

		.ve-corporate-hero__eyebrow,
		.ve-corporate-hero__title,
		.ve-corporate-hero__supporting,
		.ve-corporate-hero__actions,
		.ve-individuals__expanded {
			animation: none !important;
		}

		.ve-corporate-hero__cta,
		.ve-corporate-hero__cta span,
		.ve-individuals__read-icon {
			transition: none !important;
		}

	}

	</style>


	<script>
	(function () {

		'use strict';

		var detailsElements = document.querySelectorAll(
			'.ve-individuals__details'
		);

		detailsElements.forEach(function (details) {

			var closeButton = details.querySelector(
				'.ve-individuals__close'
			);

			if (!closeButton) {
				return;
			}

			closeButton.addEventListener('click', function () {

				details.open = false;

				var summary = details.querySelector('summary');

				if (summary) {
					summary.focus();
				}

			});

		});

	})();
	</script>

	<?php

	return ob_get_clean();

}
