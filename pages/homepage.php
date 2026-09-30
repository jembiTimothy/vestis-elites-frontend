<?php
/**
 * Vestis Elites — Commercial Homepage
 *
 * Homepage presentation layer.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vestis_elites_homepage() {

	ob_start();
	?>

	<main class="ve-homepage">

		<!-- HERO -->
		<section class="ve-hero">
			<div class="ve-container">
				<p class="ve-eyebrow">VESTIS ELITES</p>

				<h1>COMMAND<br>YOUR<br>PRESENCE.</h1>

				<p class="ve-lead">
					Personal presentation designed around the individual.
				</p>

				<a class="ve-button" href="<?php echo esc_url( home_url( '/private-consultation/' ) ); ?>">
					Private Consultation
				</a>
			</div>
		</section>


		<!-- THE HOUSE -->
		<section class="ve-house">
			<div class="ve-container">

				<p class="ve-eyebrow">THE HOUSE</p>

				<h2>
					Personal presentation,<br>
					considered differently.
				</h2>

				<p>
					Vestis Elites is a men's personal presentation house
					creating considered clothing and grooming solutions
					around the individual.
				</p>

				<p>
					From what you wear to how you present yourself,
					every detail is approached with intention.
				</p>

			</div>
		</section>


		<!-- THE ATELIER -->
		<section class="ve-atelier">
			<div class="ve-container">

				<p class="ve-eyebrow">THE ATELIER</p>

				<h2>
					Designed for the way
					you intend to be seen.
				</h2>

				<div class="ve-offer-grid">

					<article class="ve-offer">
						<span>01</span>
						<h3>Tailored Clothing</h3>
						<p>
							Considered garments designed around your
							measurements, presence and purpose.
						</p>
					</article>

					<article class="ve-offer">
						<span>02</span>
						<h3>Personal Presentation</h3>
						<p>
							Guidance on clothing, grooming and the details
							that shape how you are perceived.
						</p>
					</article>

					<article class="ve-offer">
						<span>03</span>
						<h3>Private Consultation</h3>
						<p>
							Begin with a conversation centred around you,
							your needs and how you want to present yourself.
						</p>
					</article>

				</div>

			</div>
		</section>


		<!-- BEGIN HERE -->
		<section class="ve-consultation">
			<div class="ve-container">

				<p class="ve-eyebrow">BEGIN HERE</p>

				<h2>
					Your presentation<br>
					starts with a conversation.
				</h2>

				<p>
					Every client begins differently. A Private Consultation
					allows us to understand your requirements before
					recommending the right direction.
				</p>

				<a class="ve-button ve-button-light"
					href="<?php echo esc_url( home_url( '/private-consultation/' ) ); ?>">
					Book Private Consultation
				</a>

			</div>
		</section>

	</main>

	<?php

	return ob_get_clean();
}
