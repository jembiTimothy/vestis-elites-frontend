<?php
/**
 * Vestis Elites — Alterations & Refinement
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vestis_elites_alterations_page() {

    ob_start();
    ?>

    <section class="ve-alterations-hero">

        <div class="ve-alterations-hero-content">

            <span class="ve-alterations-eyebrow">
                VESTIS ELITES · ALTERATIONS & REFINEMENT
            </span>

            <h1>
                A Better Fit.<br>
                A More Refined Finish.
            </h1>

            <p>
                Your wardrobe deserves more than ordinary repairs.
                We refine the fit, finish and presentation of your
                existing garments.
            </p>

            <a href="#alteration-request"
               class="ve-alterations-cta">
                Request a Consultation
            </a>

        </div>

    </section>

    <style>
        .ve-alterations-hero {
            background: #080808;
            color: #ffffff;
            padding: 110px 7%;
            min-height: 480px;
            display: flex;
            align-items: center;
        }

        .ve-alterations-hero-content {
            max-width: 850px;
            margin: 0 auto;
            width: 100%;
        }

        .ve-alterations-eyebrow {
            color: #1F4D3A;
            font-size: 12px;
            letter-spacing: 3px;
            font-weight: 600;
        }

        .ve-alterations-hero h1 {
            color: #ffffff;
            font-family: Georgia, serif;
            font-size: clamp(42px, 6vw, 76px);
            line-height: 1.12;
            margin: 28px 0;
            font-weight: 400;
        }

        .ve-alterations-hero p {
            color: #c5c5c5;
            font-size: 17px;
            line-height: 1.8;
            max-width: 580px;
            margin-bottom: 35px;
        }

        .ve-alterations-cta {
            display: inline-block;
            background: #1F4D3A;
            color: #ffffff !important;
            padding: 16px 26px;
            text-decoration: none;
            font-size: 13px;
            letter-spacing: 1px;
        }

        .ve-alterations-cta:hover {
            background: #28634b;
        }

        @media (max-width: 600px) {
            .ve-alterations-hero {
                padding: 85px 7%;
                min-height: 430px;
            }

            .ve-alterations-hero p {
                font-size: 15px;
            }
        }
    </style>

    <?php

    return ob_get_clean();
}
