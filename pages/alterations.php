
<?php
/**
 * Vestis Elites — Alterations & Refinement
 *
 * Section 1: Hero content.
 * Subsequent sections will be added independently.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vestis_elites_alterations_page() {

    ob_start();
    ?>

    <div class="ve-alterations-page">

        <!-- =====================================================
             SECTION 1 — HERO CONTENT
             ===================================================== -->

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
                    A Better Fit.<br>
                    A Better Standard.
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

    </div>

    <style>
        /* =========================================================
           VESTIS ELITES — ALTERATIONS PAGE / SECTION 1
           All styling is scoped to this page.
           ========================================================= */

        .ve-alterations-page,
        .ve-alterations-page * {
            box-sizing: border-box;
        }

        .ve-alterations-page {
            width: 100%;
            margin: 0;
            color: #F7F5EF;
        }

        .ve-alterations-page .ve-alterations-hero {
            display: block;
            width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #000000;
            color: #F7F5EF;
        }

        .ve-alterations-page .ve-alterations-hero__inner {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding:
                clamp(140px, 14vw, 190px)
                32px
                clamp(150px, 15vw, 210px);
        }

        .ve-alterations-page .ve-alterations-hero__eyebrow {
            margin: 0 0 40px;
            color: #5E9B7D;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.2;
            letter-spacing: 0.20em;
            text-transform: uppercase;
            animation: veAlterationsHeroReveal 1200ms cubic-bezier(0.22, 1, 0.36, 1) both;
            animation-delay: 0ms;
        }

        .ve-alterations-page .ve-alterations-hero__title {
            max-width: 760px;
            margin: 0;
            color: #F7F5EF;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(42px, 5.2vw, 68px);
            font-weight: 500;
            line-height: 1.10;
            letter-spacing: -0.035em;
            animation: veAlterationsHeroReveal 1500ms cubic-bezier(0.22, 1, 0.36, 1) both;
            animation-delay: 250ms;
        }

        .ve-alterations-page .ve-alterations-hero__supporting {
            max-width: 540px;
            margin: 42px 0 0;
            color: rgba(247, 245, 239, 0.76);
            font-size: clamp(16px, 1.4vw, 18px);
            line-height: 1.65;
            animation: veAlterationsHeroReveal 1500ms cubic-bezier(0.22, 1, 0.36, 1) both;
            animation-delay: 500ms;
        }

        .ve-alterations-page .ve-alterations-hero__actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 24px;
            margin-top: 58px;
            animation: veAlterationsHeroReveal 1500ms cubic-bezier(0.22, 1, 0.36, 1) both;
            animation-delay: 750ms;
        }

        .ve-alterations-page .ve-alterations-button,
        .ve-alterations-page .ve-alterations-button:visited {
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

        .ve-alterations-page .ve-alterations-button:hover,
        .ve-alterations-page .ve-alterations-button:focus-visible {
            border-color: #1F4D3A;
            background: #1F4D3A;
            color: #FFFFFF;
            transform: translateY(-2px);
        }

        .ve-alterations-page .ve-alterations-button:focus-visible {
            outline: 2px solid #5E9B7D;
            outline-offset: 4px;
        }

        @keyframes veAlterationsHeroReveal {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* MOBILE */

        @media (max-width: 767px) {

            .ve-alterations-page .ve-alterations-hero__inner {
                padding:
                    clamp(105px, 22vw, 140px)
                    24px
                    clamp(110px, 22vw, 150px);
            }

            .ve-alterations-page .ve-alterations-hero__eyebrow {
                margin-bottom: 30px;
                font-size: 11px;
                letter-spacing: 0.17em;
            }

            .ve-alterations-page .ve-alterations-hero__title {
                font-size: clamp(40px, 10vw, 54px);
                line-height: 1.12;
            }

            .ve-alterations-page .ve-alterations-hero__supporting {
                margin-top: 30px;
                font-size: 16px;
                line-height: 1.65;
            }

            .ve-alterations-page .ve-alterations-hero__actions {
                margin-top: 42px;
            }

            .ve-alterations-page .ve-alterations-button {
                width: 100%;
                min-height: 56px;
                padding: 12px 18px;
            }
        }

        /* ACCESSIBILITY — REDUCED MOTION */

        @media (prefers-reduced-motion: reduce) {

            .ve-alterations-page .ve-alterations-hero__eyebrow,
            .ve-alterations-page .ve-alterations-hero__title,
            .ve-alterations-page .ve-alterations-hero__supporting,
            .ve-alterations-page .ve-alterations-hero__actions {
                animation: none !important;
                transition: none !important;
            }

            .ve-alterations-page .ve-alterations-button:hover,
            .ve-alterations-page .ve-alterations-button:focus-visible {
                transform: none;
            }
        }

    </style>

    <?php

    return ob_get_clean();
}
