<?php
/**
 * Plugin Name: Vestis Elites Frontend
 * Description: Custom-coded frontend for Vestis Elites.
 * Version: 1.1.1
 * Author: Vestis Elites
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Vestis Elites Homepage
 */
function vestis_elites_frontend_shortcode() {

    ob_start();
    ?>

    <main class="ve-homepage">

        <!-- HERO -->
        <section class="ve-hero">
            <div class="ve-hero-content">

                <p class="ve-eyebrow">
                    VESTIS ELITES
                </p>

                <h1>
                    COMMAND<br>
                    YOUR PRESENCE.
                </h1>

                <p class="ve-hero-text">
                    Personal presentation designed around the individual.
                </p>

                <a
                    href="<?php echo esc_url( home_url( '/private-consultation/' ) ); ?>"
                    class="ve-button ve-button-primary"
                >
                    Private Consultation
                </a>

            </div>
        </section>


        <!-- THE HOUSE -->
        <section class="ve-section ve-house">

            <div class="ve-section-inner">

                <p class="ve-eyebrow">
                    THE HOUSE
                </p>

                <h2>
                    Personal presentation,
                    considered differently.
                </h2>

                <div class="ve-copy">
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

            </div>

        </section>


        <!-- OFFER -->
        <section class="ve-section ve-offer">

            <div class="ve-section-inner">

                <p class="ve-eyebrow">
                    THE ATELIER
                </p>

                <h2>
                    Designed for the way
                    you intend to be seen.
                </h2>

                <div class="ve-offer-grid">

                    <a
                        href="<?php echo esc_url( home_url( '/atelier/' ) ); ?>"
                        class="ve-offer-card"
                    >
                        <span>01</span>
                        <h3>Tailored Clothing</h3>
                        <p>
                            Considered garments designed around your
                            measurements, presence and purpose.
                        </p>
                    </a>

                    <a
                        href="<?php echo esc_url( home_url( '/journal/' ) ); ?>"
                        class="ve-offer-card"
                    >
                        <span>02</span>
                        <h3>Personal Presentation</h3>
                        <p>
                            Guidance on clothing, grooming and the details
                            that shape how you are perceived.
                        </p>
                    </a>

                    <a
                        href="<?php echo esc_url( home_url( '/private-consultation/' ) ); ?>"
                        class="ve-offer-card"
                    >
                        <span>03</span>
                        <h3>Private Consultation</h3>
                        <p>
                            Begin with a conversation centred around you,
                            your needs and how you want to present yourself.
                        </p>
                    </a>

                </div>

            </div>

        </section>


        <!-- CONSULTATION -->
        <section class="ve-section ve-consultation">

            <div class="ve-section-inner ve-consultation-inner">

                <p class="ve-eyebrow">
                    BEGIN HERE
                </p>

                <h2>
                    Your presentation
                    starts with a conversation.
                </h2>

                <p class="ve-consultation-text">
                    Every client begins differently.
                    A Private Consultation allows us to understand
                    your requirements before recommending the right
                    direction.
                </p>

                <a
                    href="<?php echo esc_url( home_url( '/private-consultation/' ) ); ?>"
                    class="ve-button ve-button-light"
                >
                    Book Private Consultation
                </a>

            </div>

        </section>


    </main>


    <style>

        /* =========================================
           GLOBAL
        ========================================= */

        .ve-homepage {
            background: #050505;
            color: #f5f3ee;
            font-family: inherit;
            overflow: hidden;
        }

        .ve-homepage *,
        .ve-homepage *::before,
        .ve-homepage *::after {
            box-sizing: border-box;
        }


        /* =========================================
           HERO
        ========================================= */

        .ve-hero {
            min-height: 88vh;
            display: flex;
            align-items: flex-end;
            position: relative;
            background:
                linear-gradient(
                    180deg,
                    rgba(0,0,0,0.08) 0%,
                    rgba(0,0,0,0.55) 100%
                );
        }

        .ve-hero-content {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 120px 32px 90px;
        }

        .ve-eyebrow {
            margin: 0 0 24px;
            font-size: 11px;
            line-height: 1.4;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #b7b4ac;
        }

        .ve-hero h1 {
            margin: 0;
            max-width: 900px;
            font-size: clamp(54px, 8vw, 120px);
            line-height: 0.92;
            font-weight: 400;
            letter-spacing: -0.04em;
        }

        .ve-hero-text {
            max-width: 520px;
            margin: 34px 0 36px;
            font-size: 18px;
            line-height: 1.7;
            color: #d1cec6;
        }


        /* =========================================
           BUTTONS
        ========================================= */

        .ve-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 52px;
            padding: 0 28px;
            border: 1px solid #f5f3ee;
            text-decoration: none !important;
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            transition:
                background-color 180ms ease,
                color 180ms ease,
                border-color 180ms ease;
        }

        .ve-button-primary {
            background: #f5f3ee;
            color: #050505 !important;
        }

        .ve-button-primary:hover {
            background: #0b4d3c;
            border-color: #0b4d3c;
            color: #fff !important;
        }

        .ve-button-light {
            background: transparent;
            color: #f5f3ee !important;
        }

        .ve-button-light:hover {
            background: #f5f3ee;
            color: #050505 !important;
        }


        /* =========================================
           GENERAL SECTIONS
        ========================================= */

        .ve-section {
            padding: 130px 32px;
        }

        .ve-section-inner {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
        }

        .ve-section h2 {
            max-width: 850px;
            margin: 0;
            font-size: clamp(42px, 6vw, 76px);
            line-height: 1;
            font-weight: 400;
            letter-spacing: -0.035em;
        }


        /* =========================================
           THE HOUSE
        ========================================= */

        .ve-house {
            background: #f5f3ee;
            color: #111;
        }

        .ve-house .ve-eyebrow {
            color: #55534e;
        }

        .ve-copy {
            max-width: 650px;
            margin: 50px 0 0 auto;
        }

        .ve-copy p {
            margin: 0 0 22px;
            font-size: 18px;
            line-height: 1.8;
        }


        /* =========================================
           OFFER
        ========================================= */

        .ve-offer {
            background: #050505;
        }

        .ve-offer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            margin-top: 80px;
            background: #333;
        }

        .ve-offer-card {
            display: block;
            min-height: 320px;
            padding: 38px;
            background: #050505;
            color: #f5f3ee !important;
            text-decoration: none !important;
            transition: background-color 180ms ease;
        }

        .ve-offer-card:hover {
            background: #0b4d3c;
        }

        .ve-offer-card span {
            display: block;
            margin-bottom: 80px;
            font-size: 11px;
            letter-spacing: 2px;
            color: #aaa;
        }

        .ve-offer-card h3 {
            margin: 0 0 16px;
            font-size: 25px;
            font-weight: 400;
        }

        .ve-offer-card p {
            max-width: 360px;
            margin: 0;
            color: #bcbab3;
            line-height: 1.7;
        }


        /* =========================================
           CONSULTATION
        ========================================= */

        .ve-consultation {
            background: #0b4d3c;
        }

        .ve-consultation-inner {
            max-width: 950px;
        }

        .ve-consultation h2 {
            max-width: 850px;
        }

        .ve-consultation-text {
            max-width: 600px;
            margin: 38px 0;
            font-size: 18px;
            line-height: 1.8;
            color: #dce8e3;
        }


        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 800px) {

            .ve-hero {
                min-height: 82vh;
            }

            .ve-hero-content {
                padding: 100px 22px 60px;
            }

            .ve-section {
                padding: 90px 22px;
            }

            .ve-offer-grid {
                grid-template-columns: 1fr;
                margin-top: 55px;
            }

            .ve-offer-card {
                min-height: 260px;
            }

            .ve-offer-card span {
                margin-bottom: 55px;
            }

            .ve-copy {
                margin: 40px 0 0;
            }

        }

    </style>

    <?php

    return ob_get_clean();
}
require_once __DIR__ . '/pages/homepage.php';

add_shortcode(
    'vestis_frontend',
    'vestis_elites_homepage'
);
