<?php
/**
 * Vestis Elites — Men's Hair Services
 *
 * Shortcode: [vestis_mens_hair_services]
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'vestis_elites_babin_page' ) ) {

    function vestis_elites_babin_page() {

        $whatsapp_number = '2347032681868';

        $message = rawurlencode(
            'Hello Vestis Elites. I would like to enquire about your Men’s Hair Services.'
        );

        $whatsapp_url = 'https://wa.me/' . $whatsapp_number . '?text=' . $message;

        ob_start();
        ?>

        <main class="ve-hair-services">

            <section class="ve-hair-hero">

                <div class="ve-hair-container">

                    <p class="ve-hair-eyebrow">
                        VESTIS ELITES — PERSONAL GROOMING
                    </p>

                    <h1>
                        Men's Hair Services
                    </h1>

                    <p class="ve-hair-description">
                        Personal grooming, arranged around your schedule.
                        Enjoy professional men's hair services at your
                        preferred location.
                    </p>

                    <a
                        class="ve-hair-button"
                        href="<?php echo esc_url( $whatsapp_url ); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        Make an Enquiry
                        <span>↗</span>
                    </a>

                </div>

            </section>

        </main>

        <style>
            .ve-hair-services {
                background: #F7F5EF;
                color: #171717;
                width: 100%;
                font-family: inherit;
            }

            .ve-hair-services * {
                box-sizing: border-box;
            }

            .ve-hair-hero {
                background: #000;
                color: #F7F5EF;
                min-height: 570px;
                display: flex;
                align-items: center;
                padding: 100px 7%;
                text-align: center;
            }

            .ve-hair-container {
                width: 100%;
                max-width: 850px;
                margin: 0 auto;
            }

            .ve-hair-eyebrow {
                color: #A9B9AE;
                font-size: 10px;
                letter-spacing: 3px;
                margin-bottom: 30px;
            }

            .ve-hair-hero h1 {
                color: #F7F5EF;
                font-family: Georgia, "Times New Roman", serif;
                font-size: clamp(42px, 7vw, 76px);
                font-weight: 400;
                line-height: 1.1;
                margin: 0 0 25px;
            }

            .ve-hair-description {
                color: #C4C4BD;
                font-size: 15px;
                line-height: 1.9;
                max-width: 570px;
                margin: 0 auto 35px;
            }

            .ve-hair-button {
                display: inline-flex;
                align-items: center;
                gap: 30px;
                padding: 17px 24px;
                background: #1F4D3A;
                color: #fff !important;
                font-size: 11px;
                letter-spacing: 1px;
                text-decoration: none !important;
                transition: background .2s ease;
            }

            .ve-hair-button:hover {
                background: #286349;
            }

            @media (max-width: 600px) {
                .ve-hair-hero {
                    min-height: 520px;
                    padding: 80px 7%;
                }

                .ve-hair-description {
                    font-size: 13px;
                }
            }
        </style>

        <?php

        return ob_get_clean();
    }
}
