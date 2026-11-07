
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * VESTIS ELITES
 * Branded Clothing & Uniform Solutions — Hero Section
 */

$corporate_whatsapp_message = "Hello Vestis Elites,\n\nI would like to make an enquiry about your Branded Clothing & Uniform Solutions.\n\nI would like to discuss my organisation's clothing requirements and the available options.\n\nPlease guide me on the next steps.";

$corporate_whatsapp_url = 'https://wa.me/2347032681868?text=' . rawurlencode( $corporate_whatsapp_message );
?>

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


<style>
	/* =========================================================
	   CORPORATE HERO
	========================================================= */

	.ve-corporate-hero,
	.ve-corporate-hero * {
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
			clamp(150px, 15vw, 210px);
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

	@media (max-width: 640px) {

		.ve-corporate-hero__inner {
			padding: 120px 22px 130px;
		}

		.ve-corporate-hero__eyebrow {
			margin-bottom: 30px;
			font-size: 10px;
		}

		.ve-corporate-hero__title {
			font-size: clamp(38px, 10.5vw, 48px);
			line-height: 1.10;
		}

		.ve-corporate-hero__supporting {
			margin-top: 28px;
			font-size: 16px;
			line-height: 1.7;
		}

		.ve-corporate-hero__actions {
			margin-top: 38px;
		}

		.ve-corporate-hero__cta {
			width: 100%;
			min-height: 56px;
		}
	}

	@media (prefers-reduced-motion: reduce) {
		.ve-corporate-hero__eyebrow,
		.ve-corporate-hero__title,
		.ve-corporate-hero__supporting,
		.ve-corporate-hero__actions {
			animation: none;
		}

		.ve-corporate-hero__cta,
		.ve-corporate-hero__cta span {
			transition: none;
		}
	}
</style>
  
