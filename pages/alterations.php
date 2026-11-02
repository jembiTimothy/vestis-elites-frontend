
<?php
/**
 * Vestis Elites — Alterations & Refinement
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Identify the Alterations page for page-specific layout styling.
 */
function vestis_elites_alterations_body_class( $classes ) {

    if ( is_page() ) {
        $page_id      = get_queried_object_id();
        $page_content = get_post_field( 'post_content', $page_id );

        if ( $page_content && has_shortcode( $page_content, 'vestis_alterations' ) ) {
            $classes[] = 've-coded-alterations';
        }
    }

    return $classes;
}

add_filter(
    'body_class',
    'vestis_elites_alterations_body_class'
);


/**
 * Render the Alterations & Refinement page.
 */
function vestis_elites_alterations_page() {

    ob_start();
    ?>

    <div class="ve-alterations-page">

        <!-- SECTION 1 — HERO -->

        <section
            class="ve-alterations-hero"
            aria-labelledby="ve-alterations-hero-title"
        >
            <div class="ve-alterations-hero__inner">

                <p class="ve-alterations-hero__eyebrow">
                    ALTERATIONS &amp; REFINEMENT
                </p>

                <h1
                    id="ve-alterations-hero-title"
                    class="ve-alterations-hero__title"
                >
                    A Better Fit. A Better Standard.
                </h1>

                <p class="ve-alterations-hero__supporting">
                    From clothing repairs and size adjustments to improving
                    the fit and finish of your garments, we help you look
                    your best in the clothes you own.
                </p>

                <div class="ve-alterations-hero__actions">
                    <a
                        class="ve-alterations-button"
                        href="#alteration-consultation"
                    >
                        Request an Alteration Consultation
                    </a>
                </div>

            </div>
        </section>


        <!-- SECTION 2 — ATELIER IMAGE -->

        <section
            class="ve-alterations-image"
            aria-label="The Vestis Elites alterations atelier"
        >
            <img
                src="https://vestiselites.com.ng/wp-content/uploads/2026/11/vestis-elites-clothing-alterations-tailoring-atelier.webp"
                alt="Tailoring atelier with garments, fabrics and tools used for clothing alterations and refinement"
                width="1671"
                height="941"
                loading="eager"
                fetchpriority="high"
                decoding="async"
            >
        </section>

        <!-- SECTION 3 — OUR ALTERATION SERVICES -->

        <section
            class="ve-alterations-services"
            aria-labelledby="ve-alterations-services-title"
        >
            <div class="ve-alterations-services__inner">

                <p class="ve-alterations-services__eyebrow">
                    OUR ALTERATION SERVICES
                </p>

                <h2
                    id="ve-alterations-services-title"
                    class="ve-alterations-services__title"
                >
                    Refinement for the clothes you own.
                </h2>

                <p class="ve-alterations-services__intro">
                    Thoughtful adjustments and finishing that help your
                    garments fit and present better.
                </p>

                <div class="ve-alterations-services__list">

                    <article class="ve-alterations-service">
                        <span class="ve-alterations-service__number">01</span>
                        <div>
                            <h3>Repairs &amp; Restoration</h3>
                            <p>
                                Addressing worn, damaged or weakened areas
                                to restore the usability and appearance
                                of your garments.
                            </p>
                        </div>
                    </article>

                    <article class="ve-alterations-service">
                        <span class="ve-alterations-service__number">02</span>
                        <div>
                            <h3>Size Adjustments</h3>
                            <p>
                                Adjusting garment dimensions where possible
                                to achieve a more appropriate fit.
                            </p>
                        </div>
                    </article>

                    <article class="ve-alterations-service">
                        <span class="ve-alterations-service__number">03</span>
                        <div>
                            <h3>Fit &amp; Finish Refinement</h3>
                            <p>
                                Improving proportions, finishing details
                                and the overall presentation of existing
                                garments.
                            </p>
                        </div>
                    </article>

                </div>

                <div class="ve-alterations-services__garments">
                    <p>GARMENTS WE WORK WITH</p>
                    <span>
                        Shirts <i>·</i> Trousers <i>·</i> Jackets
                        <i>·</i> Suits <i>·</i> Traditional Wear
                        <i>·</i> Casual Wear
                    </span>
                </div>

            </div>
        </section>
  
        <!-- SECTION 4 — ALTERATION CONSULTATION -->

        <section
            id="alteration-consultation"
            class="ve-alterations-consultation"
            aria-labelledby="ve-alterations-consultation-title"
        >
            <div class="ve-alterations-consultation__inner">

                <!-- HOW IT WORKS -->

                <div class="ve-alterations-consultation__process">

                    <h2
                        id="ve-alterations-consultation-title"
                        class="ve-alterations-consultation__heading"
                    >
                        How It Works
                    </h2>

                    <div class="ve-alterations-consultation__steps">

                        <article class="ve-alterations-consultation__step">
                            <span class="ve-alterations-consultation__number">01</span>
                            <div>
                                <h3>Submit Your Request</h3>
                                <p>
                                    Tell us about your garment and the work you need.
                                </p>
                            </div>
                        </article>

                        <article class="ve-alterations-consultation__step">
                            <span class="ve-alterations-consultation__number">02</span>
                            <div>
                                <h3>We Review It</h3>
                                <p>
                                    We assess your request and determine how we can help.
                                </p>
                            </div>
                        </article>

                        <article class="ve-alterations-consultation__step">
                            <span class="ve-alterations-consultation__number">03</span>
                            <div>
                                <h3>We Contact You</h3>
                                <p>
                                    We discuss the work, pricing and next steps.
                                </p>
                            </div>
                        </article>

                    </div>

                </div>

                <!-- CONSULTATION FORM PLACEHOLDER -->

                <div class="ve-alterations-consultation__form">

                    <h3 class="ve-alterations-consultation__form-title">
                        Submit Your Alteration Request
                    </h3>

                    <p class="ve-alterations-consultation__form-intro">
                        Please provide the following details.
                    </p>

                    <!-- BREVO FORM SHORTCODE WILL BE INSERTED HERE -->

                    <div class="ve-alterations-consultation__form-placeholder">
                        <p>
                            Consultation request form will appear here.
                        </p>
                    </div>

                    <p class="ve-alterations-consultation__disclaimer">
                        Submitting a request does not confirm an appointment
                        or commit you to the service. We will review your
                        enquiry and contact you to discuss the details.
                    </p>

                </div>

            </div>
                                                           </section>
        
    </div>


    <style>

        /* =====================================================
           ASTRA LAYOUT RESET — ALTERATIONS PAGE ONLY
           ===================================================== */

        body.ve-coded-alterations .site-content > .ast-container {
            display: block !important;
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        body.ve-coded-alterations .site-content .ast-row,
        body.ve-coded-alterations .site-content #primary,
        body.ve-coded-alterations .site-content .hentry,
        body.ve-coded-alterations .site-content .entry-content {
            display: block !important;
            float: none !important;
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        body.ve-coded-alterations .site-content #primary {
            flex: none !important;
        }

        body.ve-coded-alterations .site-content #secondary {
            display: none !important;
        }


        /* =====================================================
           SHARED PAGE CONTAINER
           ===================================================== */

        .ve-alterations-page,
        .ve-alterations-page * {
            box-sizing: border-box;
        }

        .ve-alterations-page {
            width: 90%;
            max-width: 1440px;
            margin: 80px auto 30px;
            color: #F7F5EF;
        }


        /* =====================================================
           SECTION 1 — HERO
           ===================================================== */

        .ve-alterations-hero {
            display: block;
            width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #000000;
            color: #F7F5EF;
        }

        .ve-alterations-hero__inner {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            padding:
                clamp(140px, 14vw, 190px)
                32px
                clamp(150px, 15vw, 210px);
        }

        .ve-alterations-hero__eyebrow {
            margin: 0 0 40px;
            color: #5E9B7D;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.2;
            letter-spacing: 0.20em;
            text-transform: uppercase;
            animation: veAlterationsReveal 1200ms ease both;
        }

        .ve-alterations-hero__title {
            max-width: 760px;
            margin: 0;
            color: #F7F5EF;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(42px, 5.2vw, 68px);
            font-weight: 500;
            line-height: 1.10;
            letter-spacing: -0.035em;
            animation: veAlterationsReveal 1500ms ease 200ms both;
        }

        .ve-alterations-hero__supporting {
            max-width: 540px;
            margin: 42px 0 0;
            color: rgba(247, 245, 239, 0.76);
            font-size: clamp(16px, 1.4vw, 18px);
            line-height: 1.65;
            animation: veAlterationsReveal 1500ms ease 400ms both;
        }

        .ve-alterations-hero__actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 58px;
            animation: veAlterationsReveal 1500ms ease 600ms both;
        }

        .ve-alterations-button,
        .ve-alterations-button:visited {
            display: inline-flex;
            min-height: 54px;
            align-items: center;
            justify-content: center;
            padding: 0 30px;
            border: 1px solid #F7F5EF;
            background: #F7F5EF;
            color: #000000;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.3;
            text-align: center;
            text-decoration: none;
            transition:
                background-color 260ms ease,
                color 260ms ease,
                border-color 260ms ease,
                transform 260ms ease;
        }

        .ve-alterations-button:hover,
        .ve-alterations-button:focus-visible {
            border-color: #1F4D3A;
            background: #1F4D3A;
            color: #FFFFFF;
            transform: translateY(-2px);
        }

        .ve-alterations-button:focus-visible {
            outline: 2px solid #5E9B7D;
            outline-offset: 4px;
        }


        /* =====================================================
           SECTION 2 — IMAGE
           ===================================================== */

        .ve-alterations-image {
            width: 100%;
            margin: 48px 0 0;
            padding: 0;
            overflow: hidden;
        }

        .ve-alterations-image img {
            display: block;
            width: 100%;
            height: auto;
            aspect-ratio: 1671 / 941;
            object-fit: cover;
            object-position: center;
            border: 0;
            border-radius: 0;
            animation: veAlterationsImageReveal 1400ms ease both;
        }


        /* =====================================================
           SECTION 3 — OUR ALTERATION SERVICES
           ===================================================== */

        .ve-alterations-services {
            width: 100%;
            margin: 48px 0 0;
            padding: 0;
            background: #F7F5EF;
            color: #111111;
        }

        .ve-alterations-services__inner {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            padding: clamp(65px, 9vw, 110px) 32px;
        }

        .ve-alterations-services__eyebrow {
            margin: 0 0 26px;
            color: #1F4D3A;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.19em;
            text-transform: uppercase;
        }

        .ve-alterations-services__title {
            max-width: 700px;
            margin: 0;
            color: #111111;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(36px, 4.5vw, 56px);
            font-weight: 500;
            line-height: 1.12;
            letter-spacing: -0.025em;
        }

        .ve-alterations-services__intro {
            max-width: 540px;
            margin: 24px 0 0;
            color: #555555;
            font-size: 16px;
            line-height: 1.7;
        }

        .ve-alterations-services__list {
            margin-top: 65px;
            border-top: 1px solid #D5D1C8;
        }

        .ve-alterations-service {
            display: grid;
            grid-template-columns: 75px 1fr;
            gap: 20px;
            padding: 32px 0;
            border-bottom: 1px solid #D5D1C8;
        }

        .ve-alterations-service__number {
            padding-top: 5px;
            color: #1F4D3A;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.08em;
        }

        .ve-alterations-service h3 {
            margin: 0;
            color: #111111;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(23px, 2.5vw, 30px);
            font-weight: 500;
            line-height: 1.25;
        }

        .ve-alterations-service p {
            max-width: 560px;
            margin: 12px 0 0;
            color: #555555;
            font-size: 15px;
            line-height: 1.7;
        }

        .ve-alterations-services__garments {
            margin-top: 55px;
        }

        .ve-alterations-services__garments p {
            margin: 0 0 16px;
            color: #1F4D3A;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.17em;
        }

        .ve-alterations-services__garments span {
            color: #222222;
            font-size: 14px;
            line-height: 2;
        }

        .ve-alterations-services__garments i {
            padding: 0 5px;
            color: #1F4D3A;
            font-style: normal;
        }

        @media (max-width: 767px) {

            .ve-alterations-services {
                margin-top: 32px;
            }

            .ve-alterations-services__inner {
                padding: 65px 24px;
            }

            .ve-alterations-services__list {
                margin-top: 45px;
            }

            .ve-alterations-service {
                grid-template-columns: 38px 1fr;
                gap: 12px;
                padding: 27px 0;
            }

            .ve-alterations-service p {
                font-size: 14px;
            }

            .ve-alterations-services__garments {
                margin-top: 40px;
            }
        }
        
        /* =====================================================
           ANIMATIONS
           ===================================================== */

        @keyframes veAlterationsReveal {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes veAlterationsImageReveal {
            from {
                opacity: 0;
                transform: scale(1.025);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }


        /* =====================================================
           MOBILE
           ===================================================== */

        @media (max-width: 767px) {

            .ve-alterations-page {
                width: 90%;
                margin-top: 80px;
                margin-bottom: 30px;
            }

            .ve-alterations-hero__inner {
                padding:
                    clamp(105px, 22vw, 140px)
                    24px
                    clamp(110px, 22vw, 150px);
            }

            .ve-alterations-hero__eyebrow {
                margin-bottom: 30px;
                font-size: 11px;
                letter-spacing: 0.17em;
            }

            .ve-alterations-hero__title {
                font-size: clamp(40px, 10vw, 54px);
                line-height: 1.12;
            }

            .ve-alterations-hero__supporting {
                margin-top: 30px;
                font-size: 16px;
                line-height: 1.65;
            }

            .ve-alterations-hero__actions {
                margin-top: 42px;
            }

            .ve-alterations-button {
                width: 100%;
                min-height: 56px;
                padding: 12px 18px;
            }

            .ve-alterations-image {
                margin-top: 32px;
            }
        }


        /* =====================================================
           REDUCED MOTION ACCESSIBILITY
           ===================================================== */

        @media (prefers-reduced-motion: reduce) {

            .ve-alterations-page * {
                animation: none !important;
                transition: none !important;
            }

            .ve-alterations-button:hover,
            .ve-alterations-button:focus-visible {
                transform: none;
            }
        }

    </style>

    <?php

    return ob_get_clean();
}
