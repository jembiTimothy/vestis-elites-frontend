
<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Vestis Elites — Branded Clothing & Uniform Solutions
 * Shortcode: [vestis_corporate_uniforms]
 */

function vestis_elites_corporate_uniforms_page() {

	ob_start();

	$whatsapp_number = '2347032681868';

	$hero_image = 'https://vestiselites.com.ng/wp-content/uploads/2026/11/vestis-elites-branded-corporate-uniforms-team.webp';

	$individuals_image = 'https://vestiselites.com.ng/wp-content/uploads/2026/11/vestis-elites-personalised-clothing-individuals.webp';

	$general_message = "Hello Vestis Elites,\n\nI would like to make an enquiry about your Branded Clothing & Uniform Solutions.\n\nPlease guide me on the available options and next steps.";

	$general_whatsapp = 'https://wa.me/' . $whatsapp_number . '?text=' . rawurlencode( $general_message );


	/*
	 * ---------------------------------------------------------
	 * AUDIENCE CATEGORIES
	 * ---------------------------------------------------------
	 */

	$audiences = array(

		array(
			'number'      => '01',
			'title'       => 'Individuals',
			'intro'       => 'From personalised T-shirts and polo shirts to custom jerseys and matching outfits, we make clothing that reflects your personal style.',
			'image'       => $individuals_image,
			'image_alt'   => 'Personalised T-shirts, polo shirts, sports jerseys, hoodies and matching clothing by Vestis Elites.',
			'image_label' => '',
			'details'     => array(
				'Personalised T-shirts and polo shirts',
				'Customised sports jerseys',
				'Sweatshirts and hoodies',
				'Matching clothing for couples, friends and family',
				'Other individual custom clothing requests',
			),
			'extra'       => 'Bring your own design or tell us what you have in mind. We will guide you through the available options and help you place your order.',
			'cta'         => 'Book Now',
			'message'     => "Hello Vestis Elites,\n\nI would like to book a personalised clothing order as an individual.\n\nPlease guide me on the available options and next steps.",
		),

		array(
			'number'      => '02',
			'title'       => 'Small Businesses & Entrepreneurs',
			'intro'       => 'Give your business a consistent look with branded T-shirts, polo shirts and clothing for your team.',
			'image'       => '',
			'image_alt'   => '',
			'image_label' => 'BRANDED CLOTHING FOR GROWING BUSINESSES',
			'details'     => array(
				'Branded T-shirts and polo shirts',
				'Staff uniforms',
				'Clothing for customer-facing teams',
				'Promotional clothing',
				'Custom clothing for business activities',
			),
			'extra'       => 'Whether you are ordering for yourself or a small team, we can discuss your design, quantity and clothing needs.',
			'cta'         => 'Make an Enquiry',
			'message'     => "Hello Vestis Elites,\n\nI am making an enquiry on behalf of a small business.\n\nI would like to discuss branded clothing or uniforms for my business.\n\nPlease guide me on the available options and next steps.",
		),

		array(
			'number'      => '03',
			'title'       => 'Companies & Corporate Organisations',
			'intro'       => 'Create a coordinated professional appearance with uniforms and branded clothing for your organisation.',
			'image'       => '',
			'image_alt'   => '',
			'image_label' => 'CORPORATE UNIFORMS & TEAM CLOTHING',
			'details'     => array(
				'Corporate uniforms',
				'Branded polo shirts and T-shirts',
				'Departmental and staff clothing',
				'Event and promotional clothing',
				'Custom uniform requirements',
			),
			'extra'       => 'Share your organisation’s requirements, preferred designs and estimated quantities. We can discuss suitable clothing options and the next steps for your order.',
			'cta'         => 'Discuss Your Requirements',
			'message'     => "Hello Vestis Elites,\n\nI am making an enquiry on behalf of a company or corporate organisation.\n\nI would like to discuss uniform or branded clothing requirements for our organisation.\n\nPlease guide me on the available options and next steps.",
		),

		array(
			'number'      => '04',
			'title'       => 'Schools & Educational Institutions',
			'intro'       => 'Bring students, staff and school teams together with coordinated clothing made for your institution.',
			'image'       => '',
			'image_alt'   => '',
			'image_label' => 'SCHOOL & INSTITUTIONAL CLOTHING',
			'details'     => array(
				'School and staff uniforms',
				'School event T-shirts',
				'Sports jerseys and team kits',
				'Club and society clothing',
				'Special school clothing orders',
			),
			'extra'       => 'Tell us about your institution, the people you are ordering for and the clothing you need. We will help you discuss the available options.',
			'cta'         => 'Discuss Your Requirements',
			'message'     => "Hello Vestis Elites,\n\nI am making an enquiry on behalf of a school or educational institution.\n\nI would like to discuss uniforms, event clothing or sportswear for our institution.\n\nPlease guide me on the available options and next steps.",
		),

		array(
			'number'      => '05',
			'title'       => 'Events, Associations & Communities',
			'intro'       => 'Make your next gathering more coordinated with matching T-shirts and clothing designed for your group.',
			'image'       => '',
			'image_alt'   => '',
			'image_label' => 'EVENT & GROUP CLOTHING',
			'details'     => array(
				'Event T-shirts',
				'Association and community clothing',
				'Conference and programme shirts',
				'Matching group outfits',
				'Custom clothing for special occasions',
			),
			'extra'       => 'Let us know the type of event or group, your preferred design and how many people you are ordering for. We will discuss the next steps with you.',
			'cta'         => 'Plan Your Clothing',
			'message'     => "Hello Vestis Elites,\n\nI am making an enquiry about clothing for an event, association or community.\n\nI would like to discuss our clothing needs, design and quantity.\n\nPlease guide me on the available options and next steps.",
		),

		array(
			'number'      => '06',
			'title'       => 'Sports Teams & Clubs',
			'intro'       => 'Give your team a coordinated identity with customised jerseys, training wear and team clothing.',
			'image'       => '',
			'image_alt'   => '',
			'image_label' => 'CUSTOM TEAMWEAR & SPORTS JERSEYS',
			'details'     => array(
				'Custom sports jerseys',
				'Team kits',
				'Training shirts',
				'Club and supporters’ clothing',
				'Custom team clothing',
			),
			'extra'       => 'Share your team colours, preferred design and the number of players or members. We will help you discuss suitable options for your team.',
			'cta'         => 'Discuss Teamwear',
			'message'     => "Hello Vestis Elites,\n\nI am making an enquiry on behalf of a sports team or club.\n\nI would like to discuss customised jerseys, team kits or other team clothing.\n\nPlease guide me on the available options and next steps.",
		),

		array(
			'number'      => '07',
			'title'       => 'Other Organisations & Special Requirements',
			'intro'       => 'Have a clothing requirement that does not fit the categories above? Tell us what you have in mind.',
			'image'       => '',
			'image_alt'   => '',
			'image_label' => 'CUSTOM CLOTHING SOLUTIONS',
			'details'     => array(
				'Organisation-specific clothing',
				'Special uniform requests',
				'Custom branded clothing',
				'Clothing made from supplied designs',
				'Other special clothing requirements',
			),
			'extra'       => 'Describe what you need, who the clothing is for and any design ideas you already have. We will review your request and discuss the available options.',
			'cta'         => 'Make an Enquiry',
			'message'     => "Hello Vestis Elites,\n\nI have a special clothing requirement that I would like to discuss.\n\nPlease let me explain what I need and guide me on the available options.",
		),

	);


	/*
	 * ---------------------------------------------------------
	 * SERVICE GROUPS
	 * ---------------------------------------------------------
	 */

	$services = array(
		array(
			'number' => '01',
			'title'  => 'Corporate Uniforms',
			'text'   => 'Coordinated clothing for companies, businesses and professional teams.',
		),
		array(
			'number' => '02',
			'title'  => 'Branded T-shirts & Polo Shirts',
			'text'   => 'Custom clothing featuring your brand, message or preferred design.',
		),
		array(
			'number' => '03',
			'title'  => 'Event Clothing',
			'text'   => 'Matching clothing for events, conferences, associations and group activities.',
		),
		array(
			'number' => '04',
			'title'  => 'Sports Jerseys & Teamwear',
			'text'   => 'Custom jerseys, team kits and clothing for sports teams and clubs.',
		),
		array(
			'number' => '05',
			'title'  => 'Personalised Clothing',
			'text'   => 'Individual clothing orders made around your ideas and preferences.',
		),
		array(
			'number' => '06',
			'title'  => 'Custom Clothing Production',
			'text'   => 'Clothing made from your own design, reference or specific requirements.',
		),
	);


	/*
	 * ---------------------------------------------------------
	 * PRODUCTION PROCESS
	 * ---------------------------------------------------------
	 */

	$process = array(
		array(
			'number' => '01',
			'title'  => 'Consultation',
			'text'   => 'Tell us what you need and who the clothing is for.',
		),
		array(
			'number' => '02',
			'title'  => 'Design & Selection',
			'text'   => 'Discuss the design, clothing options and order details.',
		),
		array(
			'number' => '03',
			'title'  => 'Production',
			'text'   => 'Once the details are agreed, we proceed with production.',
		),
		array(
			'number' => '04',
			'title'  => 'Collection or Delivery',
			'text'   => 'Your completed order is prepared for collection or delivery.',
		),
	);

	?>

	<main class="ve-uniform-page">

		<!-- =====================================================
		     1. HERO
		====================================================== -->

		<section class="ve-uniform-hero" aria-labelledby="ve-uniform-hero-title">

			<div class="ve-uniform-shell ve-uniform-hero__inner">

				<p class="ve-uniform-eyebrow">VESTIS ELITES</p>

				<h1 id="ve-uniform-hero-title">
					Branded Clothing
					<span>&amp; Uniform Solutions</span>
				</h1>

				<p class="ve-uniform-hero__intro">
					We design and produce uniforms, branded clothing,
					event T-shirts and sports jerseys for businesses,
					schools, organisations and teams.
				</p>

				<a
					class="ve-uniform-button ve-uniform-button--light"
					href="<?php echo esc_url( $general_whatsapp ); ?>"
					target="_blank"
					rel="noopener noreferrer"
				>
					Book a Private Consultation
					<span aria-hidden="true">↗</span>
				</a>

			</div>

			<div class="ve-uniform-shell ve-uniform-hero__image-wrap">
				<img
					src="<?php echo esc_url( $hero_image ); ?>"
					alt="Professionals wearing coordinated Vestis Elites branded corporate polo shirts."
					width="1672"
					height="941"
					fetchpriority="high"
					decoding="async"
				>
			</div>

		</section>


		<!-- =====================================================
		     2. WHO WE SERVE
		====================================================== -->

		<section
			class="ve-uniform-audiences"
			aria-labelledby="ve-uniform-audiences-title"
		>

			<div class="ve-uniform-shell">

				<div class="ve-uniform-section-heading">
					<p class="ve-uniform-eyebrow ve-uniform-eyebrow--green">
						OUR CLIENTS
					</p>

					<h2 id="ve-uniform-audiences-title">Who We Serve</h2>
				</div>


				<div class="ve-uniform-audience-grid">

					<?php foreach ( $audiences as $audience ) : ?>

						<?php
						$audience_whatsapp = 'https://wa.me/' . $whatsapp_number . '?text=' . rawurlencode( $audience['message'] );
						$audience_id       = 've-audience-' . $audience['number'];
						?>

						<article
							class="ve-audience-card"
							aria-labelledby="<?php echo esc_attr( $audience_id ); ?>"
						>

							<div class="ve-audience-card__visual">

								<?php if ( ! empty( $audience['image'] ) ) : ?>

									<img
										src="<?php echo esc_url( $audience['image'] ); ?>"
										alt="<?php echo esc_attr( $audience['image_alt'] ); ?>"
										loading="lazy"
										decoding="async"
									>

								<?php else : ?>

									<div class="ve-audience-card__placeholder">
										<span class="ve-audience-card__visual-number">
											<?php echo esc_html( $audience['number'] ); ?>
										</span>

										<span class="ve-audience-card__visual-label">
											<?php echo esc_html( $audience['image_label'] ); ?>
										</span>

										<span class="ve-audience-card__visual-mark" aria-hidden="true">
											VE
										</span>
									</div>

								<?php endif; ?>

							</div>


							<div class="ve-audience-card__content">

								<p class="ve-audience-card__number">
									<?php echo esc_html( $audience['number'] ); ?>
									<span> / 07</span>
								</p>

								<h3 id="<?php echo esc_attr( $audience_id ); ?>">
									<?php echo esc_html( $audience['title'] ); ?>
								</h3>

								<p class="ve-audience-card__intro">
									<?php echo esc_html( $audience['intro'] ); ?>
								</p>


								<details class="ve-audience-details">

									<summary class="ve-audience-details__summary">
										<span>Read More</span>
										<svg
											viewBox="0 0 24 24"
											width="18"
											height="18"
											fill="none"
											aria-hidden="true"
										>
											<path
												d="M6 9L12 15L18 9"
												stroke="currentColor"
												stroke-width="1.8"
												stroke-linecap="round"
												stroke-linejoin="round"
											/>
										</svg>
									</summary>


									<div class="ve-audience-details__body">

										<p class="ve-audience-details__label">
											WHAT YOU CAN ORDER
										</p>

										<ul>
											<?php foreach ( $audience['details'] as $detail ) : ?>
												<li><?php echo esc_html( $detail ); ?></li>
											<?php endforeach; ?>
										</ul>

										<p class="ve-audience-details__extra">
											<?php echo esc_html( $audience['extra'] ); ?>
										</p>

										<button
											class="ve-audience-details__close"
											type="button"
										>
											<svg
												viewBox="0 0 24 24"
												width="17"
												height="17"
												fill="none"
												aria-hidden="true"
											>
												<path
													d="M6 15L12 9L18 15"
													stroke="currentColor"
													stroke-width="1.8"
													stroke-linecap="round"
													stroke-linejoin="round"
												/>
											</svg>
											Close
										</button>

									</div>

								</details>


								<a
									class="ve-audience-card__cta"
									href="<?php echo esc_url( $audience_whatsapp ); ?>"
									target="_blank"
									rel="noopener noreferrer"
								>
									<?php echo esc_html( $audience['cta'] ); ?>
									<span aria-hidden="true">↗</span>
								</a>

							</div>

						</article>

					<?php endforeach; ?>

				</div>

			</div>

		</section>


		<!-- =====================================================
		     3. OUR SERVICES
		====================================================== -->

		<section
			class="ve-uniform-services"
			aria-labelledby="ve-uniform-services-title"
		>

			<div class="ve-uniform-shell">

				<div class="ve-uniform-section-heading ve-uniform-section-heading--light">
					<p class="ve-uniform-eyebrow">WHAT WE DO</p>
					<h2 id="ve-uniform-services-title">Our Services</h2>
					<p>
						Clothing solutions for individuals, teams
						and organisations.
					</p>
				</div>


				<div class="ve-uniform-service-grid">

					<?php foreach ( $services as $service ) : ?>

						<article class="ve-uniform-service">

							<span class="ve-uniform-service__number">
								<?php echo esc_html( $service['number'] ); ?>
							</span>

							<h3><?php echo esc_html( $service['title'] ); ?></h3>

							<p><?php echo esc_html( $service['text'] ); ?></p>

						</article>

					<?php endforeach; ?>

				</div>

			</div>

		</section>


		<!-- =====================================================
		     4. OUR WORK
		====================================================== -->

		<section
			class="ve-uniform-work"
			aria-labelledby="ve-uniform-work-title"
		>

			<div class="ve-uniform-shell">

				<div class="ve-uniform-section-heading">
					<p class="ve-uniform-eyebrow ve-uniform-eyebrow--green">
						CLOTHING POSSIBILITIES
					</p>

					<h2 id="ve-uniform-work-title">Our Work</h2>

					<p>
						Explore the different clothing styles and
						design directions available through Vestis Elites.
					</p>
				</div>


				<div class="ve-uniform-work-grid">

					<figure class="ve-uniform-work__image ve-uniform-work__image--large">
						<img
							src="<?php echo esc_url( $hero_image ); ?>"
							alt="Coordinated branded polo shirts worn by a professional team."
							loading="lazy"
							decoding="async"
						>
						<figcaption>Corporate Clothing</figcaption>
					</figure>

					<figure class="ve-uniform-work__image">
						<img
							src="<?php echo esc_url( $individuals_image ); ?>"
							alt="Personalised T-shirts, polo shirts, hoodies and sports jerseys."
							loading="lazy"
							decoding="async"
						>
						<figcaption>Personalised Clothing</figcaption>
					</figure>

				</div>

				<p class="ve-uniform-work__note">
					Have a different design in mind? We can discuss
					your own design or reference.
				</p>

			</div>

		</section>


		<!-- =====================================================
		     5. OUR PRODUCTION PROCESS
		====================================================== -->

		<section
			class="ve-uniform-process"
			aria-labelledby="ve-uniform-process-title"
		>

			<div class="ve-uniform-shell">

				<div class="ve-uniform-section-heading">
					<p class="ve-uniform-eyebrow ve-uniform-eyebrow--green">
						HOW IT WORKS
					</p>

					<h2 id="ve-uniform-process-title">
						Our Production Process
					</h2>

					<p>
						From your first enquiry to your completed order.
					</p>
				</div>


				<div class="ve-uniform-process-grid">

					<?php foreach ( $process as $step ) : ?>

						<article class="ve-uniform-process-step">

							<span><?php echo esc_html( $step['number'] ); ?></span>

							<h3><?php echo esc_html( $step['title'] ); ?></h3>

							<p><?php echo esc_html( $step['text'] ); ?></p>

						</article>

					<?php endforeach; ?>

				</div>

			</div>

		</section>


		<!-- =====================================================
		     6. WHY VESTIS ELITES
		====================================================== -->

		<section
			class="ve-uniform-why"
			aria-labelledby="ve-uniform-why-title"
		>

			<div class="ve-uniform-shell ve-uniform-why__inner">

				<div class="ve-uniform-why__heading">

					<p class="ve-uniform-eyebrow">THE VESTIS ELITES STANDARD</p>

					<h2 id="ve-uniform-why-title">
						Clothing deserves
						<span>careful attention.</span>
					</h2>

				</div>


				<div class="ve-uniform-why__content">

					<p>
						We approach every order with attention to the
						design, the people who will wear it and the
						purpose it is meant to serve.
					</p>

					<ul>
						<li>Clothing made around your requirements.</li>
						<li>Attention to design and presentation.</li>
						<li>Options for individuals and organisations.</li>
						<li>A clear consultation and ordering process.</li>
					</ul>

				</div>

			</div>

		</section>


		<!-- =====================================================
		     7. FINAL CONSULTATION CTA
		====================================================== -->

		<section
			class="ve-uniform-final"
			aria-labelledby="ve-uniform-final-title"
		>

			<div class="ve-uniform-shell ve-uniform-final__inner">

				<p class="ve-unifo
