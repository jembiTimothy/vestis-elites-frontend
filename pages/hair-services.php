<?php
/**
 * Vestis Elites — Hair Services
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add a page-specific body class.
 */
function vestis_elites_hair_services_body_class( $classes ) {
    if ( is_singular() ) {
        global $post;

        if ( $post && has_shortcode( $post->post_content, 'vestis_hair_services' ) ) {
            $classes[] = 've-coded-hair-services';
        }
    }

    return $classes;
}
add_filter( 'body_class', 'vestis_elites_hair_services_body_class' );


/**
 * Render Hair Services page.
 */
function vestis_elites_hair_services_page() {

    $whatsapp_number = '2347032681868';
    $phone_number    = '+2347032681868';

    $message = rawurlencode(
        'Hello Vestis Elites, I would like to request a hair service appointment. Please assist me with the booking process.'
    );

    $whatsapp_url = 'https://wa.me/' . $whatsapp_number . '?text=' . $message;
    $phone_url    = 'tel:' . $phone_number;

    ob_start();
    ?>

    <main class="ve-hair-page">

        <section class="ve-hair-hero">
            <div class="ve-hair-container">
                <span class="ve-hair-eyebrow">VESTIS ELITES · PERSONAL GROOMING</span>

                <h1>Hair care, <em>considered.</em></h1>

                <p>
                    Professional hair services delivered at your preferred location.
                    A convenient, personal grooming experience, arranged around you.
                </p>

                <button class="ve-hair-button ve-hair-open-booking" type="button">
                    Request a Booking
                </button>
            </div>
        </section>

        <section class="ve-hair-image">
            <img
                src="https://vestiselites.com.ng/wp-content/uploads/2026/11/vestis-elites-professional-mens-haircut-lagos.webp"
                alt="Vestis Elites professional barber providing a men's haircut in Lagos"
                width="1774"
                height="887"
                loading="lazy"
                decoding="async"
            >
        </section>
        <section class="ve-hair-services ve-hair-section">
            <div class="ve-hair-container">

                <div class="ve-hair-section-heading">
                    <span class="ve-hair-eyebrow">OUR SERVICES</span>
                    <h2>Grooming, <em>your way.</em></h2>
                    <p>
                        Explore our hair service categories and tell us what you need.
                        Available options can be discussed when you make your request.
                    </p>
                </div>

                <div class="ve-hair-service-grid">

                    <article class="ve-hair-service-card">
                        <span class="ve-hair-number">01</span>
                        <h3>Haircuts &amp; Styling</h3>
                        <p>
                            Personal grooming and haircut services, including classic
                            cuts, fades, afro cuts, shape-ups and styling.
                        </p>
                    </article>

                    <article class="ve-hair-service-card">
                        <span class="ve-hair-number">02</span>
                        <h3>Dreadlocks</h3>
                        <p>
                            Loc grooming and maintenance, including retwisting,
                            starter locs and styling.
                        </p>
                    </article>

                    <article class="ve-hair-service-card">
                        <span class="ve-hair-number">03</span>
                        <h3>Braids &amp; Protective Hairstyles</h3>
                        <p>
                            Selected braiding and protective styling options,
                            including cornrows, twists and individual plaits.
                        </p>
                    </article>

                    <article class="ve-hair-service-card">
                        <span class="ve-hair-number">04</span>
                        <h3>Hair Treatment &amp; Scalp Care</h3>
                        <p>
                            Hair and scalp care services, including washing,
                            conditioning and moisturising treatments.
                        </p>
                    </article>

                    <article class="ve-hair-service-card">
                        <span class="ve-hair-number">05</span>
                        <h3>Hair Colouring</h3>
                        <p>
                            Hair colouring options, including grey coverage,
                            colour changes and selected colour treatments.
                        </p>
                    </article>

                </div>
            </div>
        </section>


        <section class="ve-hair-location ve-hair-section">
            <div class="ve-hair-container ve-hair-location-inner">

                <div>
                    <span class="ve-hair-eyebrow">PERSONAL SERVICE</span>
                    <h2>Your location.<br><em>Our professionals.</em></h2>
                </div>

                <div class="ve-hair-location-copy">
                    <p>
                        You do not have to travel to a salon. Our professionals
                        come to your preferred location within Lagos.
                    </p>
                    <p>
                        Every request is reviewed individually so that the service,
                        location and appointment arrangements can be properly
                        established before confirmation.
                    </p>
                </div>

            </div>
        </section>


        <section class="ve-hair-process ve-hair-section">
            <div class="ve-hair-container">

                <div class="ve-hair-section-heading">
                    <span class="ve-hair-eyebrow">THE BOOKING PROCESS</span>
                    <h2>Simple by <em>design.</em></h2>
                </div>

                <div class="ve-hair-steps">

                    <article>
                        <span>01</span>
                        <h3>Make a request</h3>
                        <p>Choose your preferred service and contact our team.</p>
                    </article>

                    <article>
                        <span>02</span>
                        <h3>Share your details</h3>
                        <p>Tell us your location, requirements and preferred appointment time.</p>
                    </article>

                    <article>
                        <span>03</span>
                        <h3>Receive your quotation</h3>
                        <p>
                            We review your request and provide a quotation based
                            on the service and logistics involved.
                        </p>
                    </article>

                    <article>
                        <span>04</span>
                        <h3>Confirm your appointment</h3>
                        <p>
                            Once the quotation and appointment details are agreed,
                            your booking is confirmed.
                        </p>
                    </article>

                </div>

                <p class="ve-hair-note">
                    Submitting a booking request does not automatically confirm
                    an appointment. Confirmation follows agreement on the service,
                    quotation and appointment details.
                </p>

            </div>
        </section>


        <section class="ve-hair-final-cta">
            <div class="ve-hair-container">
                <span class="ve-hair-eyebrow">VESTIS ELITES</span>
                <h2>Make room for<br><em>better grooming.</em></h2>
                <p>Tell us what you need. We will take it from there.</p>

                <button class="ve-hair-button ve-hair-open-booking" type="button">
                    Request a Booking
                </button>
            </div>
        </section>


        <div class="ve-hair-modal" aria-hidden="true">
            <div class="ve-hair-modal-backdrop"></div>

            <div class="ve-hair-modal-dialog"
                 role="dialog"
                 aria-modal="true"
                 aria-labelledby="ve-hair-modal-title">

                <button class="ve-hair-modal-close" type="button" aria-label="Close booking options">
                    &times;
                </button>

                <span class="ve-hair-eyebrow">BOOKING ENQUIRY</span>
                <h2 id="ve-hair-modal-title">How would you like to reach us?</h2>
                <p>Choose your preferred way to make a booking request.</p>

                <a class="ve-hair-contact-option" href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener">
                    <span>WhatsApp</span>
                    <span class="ve-hair-contact-description">Start a booking conversation</span>
                </a>

                <a class="ve-hair-contact-option" href="<?php echo esc_url( $phone_url ); ?>">
                    <span>Call Us</span>
                    <span class="ve-hair-contact-description">Speak directly with our team</span>
                </a>

            </div>
        </div>

    </main>

    <style>
        .ve-coded-hair-services .site-content {
            padding-top: 0;
            padding-bottom: 0;
        }

        .ve-hair-page {
            --ve-black: #11110f;
            --ve-ivory: #f5f2eb;
            --ve-white: #fff;
            --ve-green: #1f4d3a;
            --ve-muted: #77756f;
            background: var(--ve-ivory);
            color: var(--ve-black);
            font-family: inherit;
        }

        .ve-hair-page * {
            box-sizing: border-box;
        }

        .ve-hair-container {
            width: min(1120px, calc(100% - 48px));
            margin: 0 auto;
        }

        .ve-hair-section {
            padding: 100px 0;
        }

        .ve-hair-eyebrow {
            display: block;
            font-size: 10px;
            letter-spacing: 3px;
            font-weight: 600;
            color: var(--ve-green);
            margin-bottom: 22px;
        }

        .ve-hair-hero {
            background: var(--ve-black);
            color: var(--ve-white);
            padding: 150px 0 140px;
            text-align: center;
        }
                .ve-hair-image {
            width: 100%;
            overflow: hidden;
            background: #11110f;
        }

        .ve-hair-image img {
            display: block;
            width: 100%;
            height: auto;
            max-height: 620px;
            object-fit: cover;
            object-position: center;
        }

        .ve-hair-hero .ve-hair-eyebrow,
        .ve-hair-final-cta .ve-hair-eyebrow {
            color: #a9bcae;
        }

        .ve-hair-hero h1,
        .ve-hair-final-cta h2 {
            color: var(--ve-white);
            font-family: Georgia, serif;
            font-size: clamp(48px, 7vw, 88px);
            font-weight: 400;
            line-height: 1.05;
            margin: 0 0 25px;
        }

        .ve-hair-hero h1 em,
        .ve-hair-final-cta h2 em,
        .ve-hair-section-heading h2 em,
        .ve-hair-location h2 em {
            font-weight: 400;
            color: #b8c9bb;
        }

        .ve-hair-hero p {
            max-width: 580px;
            margin: 0 auto 35px;
            color: #c9c8c1;
            font-size: 16px;
            line-height: 1.9;
        }

        .ve-hair-button {
            display: inline-block;
            border: 1px solid var(--ve-green);
            background: var(--ve-green);
            color: #fff;
            padding: 17px 30px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background .2s ease, border-color .2s ease;
        }

        .ve-hair-button:hover {
            background: #173b2c;
            border-color: #173b2c;
            color: #fff;
        }

        .ve-hair-section-heading {
            max-width: 650px;
            margin-bottom: 55px;
        }

        .ve-hair-section-heading h2,
        .ve-hair-location h2 {
            font-family: Georgia, serif;
            font-size: clamp(38px, 5vw, 58px);
            line-height: 1.12;
            font-weight: 400;
            margin: 0 0 20px;
            color: var(--ve-black);
        }

        .ve-hair-section-heading h2 em,
        .ve-hair-location h2 em {
            color: var(--ve-green);
        }

        .ve-hair-section-heading p,
        .ve-hair-location-copy p {
            color: var(--ve-muted);
            line-height: 1.9;
            font-size: 15px;
        }

        .ve-hair-service-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1px;
            background: #dedbd3;
            border: 1px solid #dedbd3;
        }

        .ve-hair-service-card {
            background: var(--ve-ivory);
            padding: 38px 32px;
            min-height: 220px;
        }

        .ve-hair-number {
            display: block;
            color: var(--ve-green);
            font-size: 11px;
            letter-spacing: 2px;
            margin-bottom: 28px;
        }

        .ve-hair-service-card h3,
        .ve-hair-steps h3 {
            font-family: Georgia, serif;
            font-size: 23px;
            font-weight: 400;
            margin: 0 0 15px;
            color: var(--ve-black);
        }

        .ve-hair-service-card p,
        .ve-hair-steps p {
            color: var(--ve-muted);
            font-size: 14px;
            line-height: 1.8;
            margin: 0;
        }

        .ve-hair-location {
            background: #e9e6de;
        }

        .ve-hair-location-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .ve-hair-location-copy p {
            margin: 0 0 18px;
        }

        .ve-hair-steps {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 30px;
        }

        .ve-hair-steps article {
            border-top: 1px solid #bdb9af;
            padding-top: 25px;
        }

        .ve-hair-steps article > span {
            display: block;
            color: var(--ve-green);
            font-size: 11px;
            letter-spacing: 2px;
            margin-bottom: 25px;
        }

        .ve-hair-steps h3 {
            font-size: 20px;
        }

        .ve-hair-note {
            margin-top: 40px;
            padding-left: 18px;
            border-left: 2px solid var(--ve-green);
            color: var(--ve-muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .ve-hair-final-cta {
            background: var(--ve-black);
            color: #fff;
            padding: 110px 0;
            text-align: center;
        }

        .ve-hair-final-cta h2 {
            font-size: clamp(42px, 6vw, 72px);
        }

        .ve-hair-final-cta p {
            color: #c9c8c1;
            margin: 0 0 32px;
            line-height: 1.8;
        }

        .ve-hair-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 999999;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .ve-hair-modal.is-open {
            display: flex;
        }

        .ve-hair-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .75);
        }

        .ve-hair-modal-dialog {
            position: relative;
            z-index: 1;
            width: min(480px, 100%);
            padding: 45px 35px;
            background: var(--ve-ivory);
            color: var(--ve-black);
        }

        .ve-hair-modal-close {
            position: absolute;
            top: 12px;
            right: 16px;
            border: 0;
            background: transparent;
            color: var(--ve-black);
            font-size: 30px;
            cursor: pointer;
        }

        .ve-hair-modal-dialog h2 {
            font-family: Georgia, serif;
            font-size: 32px;
            font-weight: 400;
            line-height: 1.2;
            margin: 0 0 15px;
        }

        .ve-hair-modal-dialog > p {
            color: var(--ve-muted);
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .ve-hair-contact-option {
            display: block;
            padding: 18px 20px;
            margin-top: 12px;
            border: 1px solid #d5d1c8;
            color: var(--ve-black);
            text-decoration: none;
        }

        .ve-hair-contact-option:hover {
            border-color: var(--ve-green);
            color: var(--ve-green);
        }

        .ve-hair-contact-option > span:first-child {
            display: block;
            font-family: Georgia, serif;
            font-size: 21px;
        }

        .ve-hair-contact-description {
            display: block;
            color: var(--ve-muted);
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 800px) {
            .ve-hair-section {
                padding: 75px 0;
            }

            .ve-hair-hero {
                padding: 115px 0 105px;
            }

            .ve-hair-service-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ve-hair-location-inner {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .ve-hair-steps {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                row-gap: 40px;
            }
        }

        @media (max-width: 520px) {
            .ve-hair-container {
                width: min(100% - 36px, 1120px);
            }

            .ve-hair-service-grid,
            .ve-hair-steps {
                grid-template-columns: 1fr;
            }

            .ve-hair-service-card {
                min-height: auto;
                padding: 30px 25px;
            }

            .ve-hair-modal-dialog {
                padding: 42px 24px 28px;
            }
        }
    </style>

    <script>
    (function () {
        const script = document.currentScript;
        const page = document.querySelector('.ve-hair-page');

        if (!page) return;

        const modal = page.querySelector('.ve-hair-modal');
        const openButtons = page.querySelectorAll('.ve-hair-open-booking');
        const closeButton = page.querySelector('.ve-hair-modal-close');
        const backdrop = page.querySelector('.ve-hair-modal-backdrop');

        if (!modal || !closeButton || !backdrop) return;

        let lastFocusedElement = null;

        function openModal() {
            lastFocusedElement = document.activeElement;
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            closeButton.focus();
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';

            if (lastFocusedElement) {
                lastFocusedElement.focus();
            }
        }

        openButtons.forEach(function (button) {
            button.addEventListener('click', openModal);
        });

        closeButton.addEventListener('click', closeModal);
        backdrop.addEventListener('click', closeModal);

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                closeModal();
            }
        });
    })();
    </script>

    <?php
    return ob_get_clean();
}

add_shortcode( 'vestis_hair_services', 'vestis_elites_hair_services_page' );
