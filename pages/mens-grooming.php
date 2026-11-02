<?php
/**
 * Vestis Elites — Manicure & Pedicure
 *
 * Shortcode: [vestis_mens_grooming]
 * Page title: Manicure & Pedicure
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vestis_elites_mens_grooming_page() {

    $whatsapp_number = '2347032681868';
    $phone_number    = '+2347032681868';

    $whatsapp_message = rawurlencode(
        'Hello Vestis Elites. I would like to make an enquiry about your mobile Manicure & Pedicure service.'
    );

    $whatsapp_url = 'https://wa.me/' . $whatsapp_number . '?text=' . $whatsapp_message;
    $phone_url    = 'tel:' . $phone_number;

    ob_start();
    ?>

    <div class="ve-grooming-page">

        <style>
            .ve-grooming-page {
                --ve-black: #000000;
                --ve-ivory: #F7F5EF;
                --ve-green: #1F4D3A;
                --ve-muted: #77766F;

                background: var(--ve-ivory);
                color: var(--ve-black);
                font-family: inherit;
                width: 100%;
                overflow: hidden;
            }

            .ve-grooming-page *,
            .ve-grooming-page *::before,
            .ve-grooming-page *::after {
                box-sizing: border-box;
            }

            .ve-grooming-page a {
                text-decoration: none !important;
            }

            .ve-grooming-container {
                width: min(1120px, 90%);
                margin: 0 auto;
            }

            .ve-grooming-hero {
                background: var(--ve-black);
                color: var(--ve-ivory);
                padding: 120px 0 110px;
                text-align: center;
            }

            .ve-grooming-eyebrow {
                color: #A9B9AE;
                font-size: 11px;
                letter-spacing: 4px;
                text-transform: uppercase;
                margin-bottom: 28px;
                display: block;
            }

            .ve-grooming-hero h1 {
                color: var(--ve-ivory);
                font-family: Georgia, "Times New Roman", serif;
                font-size: clamp(42px, 7vw, 76px);
                font-weight: 400;
                line-height: 1.12;
                letter-spacing: -2px;
                margin: 0 auto 25px;
                max-width: 850px;
            }

            .ve-grooming-hero p {
                color: #C4C4BD;
                font-size: 16px;
                line-height: 1.9;
                max-width: 590px;
                margin: 0 auto;
            }

            .ve-grooming-divider {
                width: 48px;
                height: 2px;
                background: var(--ve-green);
                margin: 35px auto;
            }

            .ve-grooming-section {
                padding: 95px 0;
            }

            .ve-grooming-intro {
                text-align: center;
                max-width: 760px;
                margin: 0 auto;
            }

            .ve-grooming-label {
                color: var(--ve-green);
                font-size: 11px;
                letter-spacing: 3px;
                text-transform: uppercase;
                display: block;
                margin-bottom: 22px;
            }

            .ve-grooming-section h2 {
                font-family: Georgia, "Times New Roman", serif;
                font-size: clamp(32px, 5vw, 48px);
                font-weight: 400;
                line-height: 1.2;
                color: var(--ve-black);
                margin: 0 0 25px;
            }

            .ve-grooming-section p {
                color: #55554F;
                font-size: 15px;
                line-height: 1.95;
                margin-bottom: 18px;
            }

            .ve-grooming-services {
                background: #FFFFFF;
            }

            .ve-grooming-service-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 35px;
                margin-top: 55px;
            }

            .ve-grooming-service {
                border-top: 1px solid #D9D8D1;
                padding: 30px 10px 15px 0;
            }

            .ve-grooming-service-number {
                color: var(--ve-green);
                font-size: 12px;
                letter-spacing: 2px;
                margin-bottom: 22px;
                display: block;
            }

            .ve-grooming-service h3 {
                font-family: Georgia, "Times New Roman", serif;
                font-size: 30px;
                font-weight: 400;
                color: var(--ve-black);
                margin: 0 0 16px;
            }

            .ve-grooming-service p {
                max-width: 440px;
                margin: 0;
            }

            .ve-grooming-mobile {
                background: var(--ve-black);
                color: var(--ve-ivory);
                text-align: center;
            }

            .ve-grooming-mobile h2 {
                color: var(--ve-ivory);
            }

            .ve-grooming-mobile p {
                color: #C4C4BD;
                max-width: 650px;
                margin-left: auto;
                margin-right: auto;
            }

            .ve-grooming-location {
                color: #A9B9AE;
                font-size: 12px;
                letter-spacing: 3px;
                text-transform: uppercase;
                margin-top: 30px;
                display: block;
            }

            .ve-grooming-booking {
                text-align: center;
                padding: 100px 0;
            }

            .ve-grooming-booking-content {
                max-width: 700px;
                margin: 0 auto;
            }

            .ve-grooming-booking h2 {
                margin-bottom: 20px;
            }

            .ve-grooming-booking p {
                max-width: 570px;
                margin: 0 auto 35px;
            }

            .ve-grooming-actions {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;
                gap: 14px;
                margin-top: 30px;
            }

            .ve-grooming-button {
                display: inline-flex;
                justify-content: center;
                align-items: center;
                min-width: 190px;
                padding: 17px 27px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: 1.5px;
                text-transform: uppercase;
                transition: all 0.25s ease;
            }

            .ve-grooming-button-primary {
                background: var(--ve-green);
                color: #FFFFFF !important;
                border: 1px solid var(--ve-green);
            }

            .ve-grooming-button-primary:hover {
                background: #173B2C;
                border-color: #173B2C;
                color: #FFFFFF !important;
            }

            .ve-grooming-button-secondary {
                background: transparent;
                color: var(--ve-black) !important;
                border: 1px solid #BDBCB4;
            }

            .ve-grooming-button-secondary:hover {
                border-color: var(--ve-green);
                color: var(--ve-green) !important;
            }

            .ve-grooming-note {
                font-size: 12px !important;
                color: var(--ve-muted) !important;
                margin-top: 28px !important;
            }

            .ve-grooming-footer {
                background: #000000;
                color: #BDBDB5;
                padding: 28px 15px;
                text-align: center;
                font-size: 10px;
                letter-spacing: 3px;
                text-transform: uppercase;
            }

            .ve-grooming-footer span {
                color: #A9B9AE;
            }

            @media (max-width: 700px) {

                .ve-grooming-hero {
                    padding: 90px 0 85px;
                }

                .ve-grooming-hero h1 {
                    letter-spacing: -1px;
                }

                .ve-grooming-hero p {
                    font-size: 14px;
                }

                .ve-grooming-section {
                    padding: 70px 0;
                }

                .ve-grooming-service-grid {
                    grid-template-columns: 1fr;
                    gap: 25px;
                    margin-top: 40px;
                }

                .ve-grooming-service h3 {
                    font-size: 27px;
                }

                .ve-grooming-booking {
                    padding: 75px 0;
                }

                .ve-grooming-actions {
                    flex-direction: column;
                }

                .ve-grooming-button {
                    width: 100%;
                    max-width: 320px;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .ve-grooming-page *,
                .ve-grooming-page *::before,
                .ve-grooming-page *::after {
                    transition: none !important;
                    animation: none !important;
                    scroll-behavior: auto !important;
                }
            }
        </style>

        <!-- HERO -->

        <section class="ve-grooming-hero">
            <div class="ve-grooming-container">

                <span class="ve-grooming-eyebrow">
                    Vestis Elites · Personal Grooming
                </span>

                <h1>Manicure &amp; Pedicure</h1>

                <div class="ve-grooming-divider"></div>

                <p>
                    Personal grooming is part of personal presentation.
                    Give attention to the details that complete a well-kept appearance.
                </p>

            </div>
        </section>


        <!-- INTRODUCTION -->

        <section class="ve-grooming-section">
            <div class="ve-grooming-container">

                <div class="ve-grooming-intro">

                    <span class="ve-grooming-label">
                        The Details Matter
                    </span>

                    <h2>
                        A considered approach to personal care.
                    </h2>

                    <p>
                        Good presentation extends beyond what you wear.
                        The condition and appearance of your hands and feet
                        are also part of how you present yourself.
                    </p>

                    <p>
                        Vestis Elites offers manicure and pedicure services
                        for men, with the convenience of service delivered
                        at your location in Lagos.
                    </p>

                </div>

            </div>
        </section>


        <!-- SERVICES -->

        <section class="ve-grooming-section ve-grooming-services">
            <div class="ve-grooming-container">

                <div class="ve-grooming-intro">

                    <span class="ve-grooming-label">
                        Our Services
                    </span>

                    <h2>
                        Essential grooming. Considered presentation.
                    </h2>

                    <p>
                        Dedicated attention to the care and appearance
                        of your hands and feet.
                    </p>

                </div>

                <div class="ve-grooming-service-grid">

                    <div class="ve-grooming-service">

                        <span class="ve-grooming-service-number">
                            01 / HAND CARE
                        </span>

                        <h3>Manicure</h3>

                        <p>
                            Focused care for the hands and nails,
                            supporting a neat and well-maintained appearance.
                        </p>

                    </div>


                    <div class="ve-grooming-service">

                        <span class="ve-grooming-service-number">
                            02 / FOOT CARE
                        </span>

                        <h3>Pedicure</h3>

                        <p>
                            Attention to the feet and toenails as part
                            of a consistent personal grooming routine.
                        </p>

                    </div>

                </div>

            </div>
        </section>


        <!-- MOBILE SERVICE -->

        <section class="ve-grooming-section ve-grooming-mobile">
            <div class="ve-grooming-container">

                <div class="ve-grooming-intro">

                    <span class="ve-grooming-label">
                        At Your Convenience
                    </span>

                    <h2>
                        Grooming, delivered to your location.
                    </h2>

                    <p>
                        Our manicure and pedicure service is mobile.
                        You can make an appointment enquiry and arrange
                        to receive the service at your location in Lagos.
                    </p>

                    <span class="ve-grooming-location">
                        Lagos, Nigeria
                    </span>

                </div>

            </div>
        </section>


        <!-- BOOKING -->

        <section class="ve-grooming-booking">
            <div class="ve-grooming-container">

                <div class="ve-grooming-booking-content">

                    <span class="ve-grooming-label">
                        Appointments &amp; Enquiries
                    </span>

                    <h2>
                        Make time for the details.
                    </h2>

                    <p>
                        Contact Vestis Elites to enquire about an appointment.
                        Share your location and the service you require.
                        Availability and pricing will be communicated
                        during your enquiry.
                    </p>

                    <div class="ve-grooming-actions">

                        <a
                            class="ve-grooming-button ve-grooming-button-primary"
                            href="<?php echo esc_url( $whatsapp_url ); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Enquire about an appointment on WhatsApp"
                        >
                            Enquire on WhatsApp
                        </a>

                        <a
                            class="ve-grooming-button ve-grooming-button-secondary"
                            href="<?php echo esc_url( $phone_url ); ?>"
                            aria-label="Call Vestis Elites"
                        >
                            Book with a Call
                        </a>

                    </div>

                    <p class="ve-grooming-note">
                        Service availability and pricing are confirmed
                        during appointment enquiries.
                    </p>

                </div>

            </div>
        </section>


        <!-- FOOTER -->

        <div class="ve-grooming-footer">
            <span>Vestis Elites</span>
            &nbsp; · &nbsp;
            Command Your Presence.
        </div>

    </div>

    <?php

    return ob_get_clean();
}
