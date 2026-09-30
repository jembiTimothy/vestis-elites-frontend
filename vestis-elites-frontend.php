<?php
/**
 * Plugin Name: Vestis Elites Frontend
 * Description: Custom-coded frontend components for Vestis Elites.
 * Version: 1.0.0
 * Author: Vestis Elites
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vestis_elites_frontend_shortcode() {
    ob_start();
    ?>

    <section class="ve-frontend">
        <div class="ve-frontend-inner">
            <p class="ve-eyebrow">VESTIS ELITES</p>

            <h1>The House</h1>

            <p class="ve-intro">
                A new coded frontend for Vestis Elites.
            </p>

            <a href="#" class="ve-button">
                Explore
            </a>
        </div>
    </section>

    <style>
        .ve-frontend {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            color: #fff;
            text-align: center;
            padding: 80px 24px;
        }

        .ve-frontend-inner {
            max-width: 800px;
            width: 100%;
        }

        .ve-eyebrow {
            font-size: 12px;
            letter-spacing: 4px;
            margin-bottom: 24px;
        }

        .ve-frontend h1 {
            font-size: clamp(48px, 8vw, 96px);
            font-weight: 400;
            margin: 0 0 24px;
        }

        .ve-intro {
            font-size: 18px;
            line-height: 1.7;
            margin-bottom: 36px;
        }

        .ve-button {
            display: inline-block;
            padding: 14px 28px;
            border: 1px solid #fff;
            color: #fff;
            text-decoration: none;
        }
    </style>

    <?php
    return ob_get_clean();
}

add_shortcode( 'vestis_frontend', 'vestis_elites_frontend_shortcode' );
