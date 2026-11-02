<?php
/**
 * Vestis Elites — Babin Capability Showcase
 *
 * File: pages/babin.php
 * Shortcode to register in the main plugin loader:
 * [vestis_babin]
 *
 * This is an interactive concept build. Service options and booking fields are
 * illustrative until the business confirms the final service menu and process.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'vestis_elites_babin_body_class' ) ) {
    function vestis_elites_babin_body_class( $classes ) {
        if ( is_singular() ) {
            global $post;
            if ( $post instanceof WP_Post && has_shortcode( $post->post_content, 'vestis_babin' ) ) {
                $classes[] = 've-coded-babin';
            }
        }
        return $classes;
    }
    add_filter( 'body_class', 'vestis_elites_babin_body_class' );
}

if ( ! function_exists( 'vestis_elites_babin_page' ) ) {
    function vestis_elites_babin_page() {
        $whatsapp_number = '2347032681868';
        $phone_number    = '+2347032681868';
        $base_message    = 'Hello Vestis Elites. I would like to enquire about a Babin mobile grooming visit.';
        $whatsapp_url    = 'https://wa.me/' . $whatsapp_number . '?text=' . rawurlencode( $base_message );
        $phone_url       = 'tel:' . $phone_number;

        ob_start();
        ?>
        <main class="ve-babin" id="ve-babin">
            <div class="ve-progress" aria-hidden="true"><span id="ve-progress-bar"></span></div>

            <header class="ve-nav" id="ve-nav">
                <a class="ve-wordmark" href="#ve-home" aria-label="Vestis Elites Babin home">
                    <span class="ve-wordmark-main">VESTIS <i>ELITES</i></span>
                    <span class="ve-wordmark-sub">GROOMING SUITE / BABIN</span>
                </a>
                <nav class="ve-nav-links" aria-label="Main navigation">
                    <a href="#ve-experience">The experience</a>
                    <a href="#ve-services">Grooming</a>
                    <a href="#ve-process">The process</a>
                </nav>
                <div class="ve-nav-actions">
                    <button class="ve-mode-toggle" id="ve-mode-toggle" type="button" aria-label="Toggle display mode">
                        <span class="ve-mode-icon">◐</span><span class="ve-mode-label">Display</span>
                    </button>
                    <a class="ve-nav-cta" href="#ve-request">Request a visit <span>↗</span></a>
                    <button class="ve-menu-toggle" id="ve-menu-toggle" type="button" aria-expanded="false" aria-controls="ve-mobile-menu" aria-label="Open menu">
                        <span></span><span></span>
                    </button>
                </div>
            </header>

            <div class="ve-mobile-menu" id="ve-mobile-menu" hidden>
                <a href="#ve-experience">The experience</a>
                <a href="#ve-services">Grooming</a>
                <a href="#ve-process">The process</a>
                <a href="#ve-request">Request a visit</a>
            </div>

            <section class="ve-hero" id="ve-home">
                <div class="ve-hero-image" role="img" aria-label="A refined contemporary barbershop interior"></div>
                <div class="ve-hero-grain"></div>
                <div class="ve-hero-content">
                    <p class="ve-eyebrow ve-reveal"><span class="ve-eyebrow-line"></span> VESTIS ELITES GROOMING SUITE</p>
                    <h1 class="ve-hero-title ve-reveal">The barbershop<br><em>comes to you.</em></h1>
                    <p class="ve-hero-copy ve-reveal">A considered grooming experience, delivered to the place you choose. Your space. Your time. A more personal standard.</p>
                    <div class="ve-hero-actions ve-reveal">
                        <a class="ve-button ve-button-light" href="#ve-request">Explore a grooming visit <span>↗</span></a>
                        <a class="ve-text-link ve-text-link-light" href="#ve-experience">Discover Babin <span>↓</span></a>
                    </div>
                </div>
                <div class="ve-hero-side-note"><span>01 / 04</span><span>PERSONAL GROOMING, RECONSIDERED</span></div>
                <div class="ve-hero-bottom">
                    <span>SCROLL TO EXPLORE</span>
                    <span class="ve-scroll-line"></span>
                    <span>LAGOS · NIGERIA</span>
                </div>
                <div class="ve-hero-orbit" aria-hidden="true"><span>BE WELL PRESENTED · BE WELL PRESENTED · </span></div>
            </section>

            <section class="ve-intro ve-section" id="ve-experience">
                <div class="ve-section-index ve-reveal">A DIFFERENT KIND OF CONVENIENCE <span>01 — 04</span></div>
                <div class="ve-intro-grid">
                    <div class="ve-intro-heading ve-reveal">
                        <p class="ve-kicker">INTRODUCING BABIN</p>
                        <h2>Good grooming<br>should fit <em>your life.</em></h2>
                    </div>
                    <div class="ve-intro-body ve-reveal">
                        <p class="ve-large-copy">Babin brings the grooming visit to your chosen location, whether that is your home, office or another suitable space.</p>
                        <p>No unnecessary journey. No crowded waiting area. Just a personal service arranged around your schedule and delivered with the attention expected of Vestis Elites.</p>
                        <a class="ve-underlined-link" href="#ve-process">See how it works <span>↗</span></a>
                    </div>
                </div>
                <div class="ve-feature-strip">
                    <div class="ve-feature ve-reveal"><span class="ve-feature-no">01</span><strong>Your location</strong><small>Choose a suitable place for your visit.</small></div>
                    <div class="ve-feature ve-reveal"><span class="ve-feature-no">02</span><strong>Your schedule</strong><small>Request a time that works for you.</small></div>
                    <div class="ve-feature ve-reveal"><span class="ve-feature-no">03</span><strong>Your experience</strong><small>Personal attention, without the usual trip.</small></div>
                </div>
            </section>

            <section class="ve-image-break">
                <div class="ve-image-break-photo"></div>
                <div class="ve-image-break-caption"><span>THE DETAILS MATTER</span><span>CRAFT / CARE / PRESENCE</span></div>
                <div class="ve-image-break-quote">“Presentation is not an occasion.<br><em>It is a standard.</em>”</div>
            </section>

            <section class="ve-services ve-section" id="ve-services">
                <div class="ve-section-index ve-reveal">THE GROOMING EDIT <span>02 — 04</span></div>
                <div class="ve-services-head">
                    <div class="ve-reveal">
                        <p class="ve-kicker">A PERSONAL GROOMING MENU</p>
                        <h2>Choose your<br><em>grooming focus.</em></h2>
                    </div>
                    <p class="ve-services-note ve-reveal">Explore the service concepts below. The final service menu can be refined before launch.</p>
                </div>
                <div class="ve-service-grid">
                    <button class="ve-service-card ve-reveal" type="button" data-service="Haircut">
                        <span class="ve-service-image ve-service-image-one"></span>
                        <span class="ve-service-card-bottom"><span><small>01 / THE ESSENTIAL</small><strong>The Haircut</strong></span><i>↗</i></span>
                    </button>
                    <button class="ve-service-card ve-reveal" type="button" data-service="Haircut and beard">
                        <span class="ve-service-image ve-service-image-two"></span>
                        <span class="ve-service-card-bottom"><span><small>02 / THE COMPLETE</small><strong>Hair & Beard</strong></span><i>↗</i></span>
                    </button>
                    <button class="ve-service-card ve-reveal" type="button" data-service="Beard refinement">
                        <span class="ve-service-image ve-service-image-three"></span>
                        <span class="ve-service-card-bottom"><span><small>03 / THE FINISH</small><strong>Beard Refinement</strong></span><i>↗</i></span>
                    </button>
                </div>
                <p class="ve-concept-note">SERVICE CONCEPTS — FINAL OFFERING TO BE CONFIRMED</p>
            </section>

            <section class="ve-showcase ve-section">
                <div class="ve-section-index ve-reveal">INTERACTIVE DETAIL <span>03 — 04</span></div>
                <div class="ve-showcase-head ve-reveal">
                    <p class="ve-kicker">THE FINISHING TOUCH</p>
                    <h2>See the difference<br><em>in the details.</em></h2>
                    <p>Move the control to explore this interactive before-and-after style demonstration. Replace these concept images with approved client work before publication.</p>
                </div>
                <div class="ve-before-after ve-reveal" id="ve-before-after">
                    <div class="ve-ba-after"></div>
                    <div class="ve-ba-before" id="ve-ba-before"></div>
                    <div class="ve-ba-label ve-ba-label-before">BEFORE / CONCEPT</div>
                    <div class="ve-ba-label ve-ba-label-after">AFTER / CONCEPT</div>
                    <div class="ve-ba-divider" id="ve-ba-divider"><span>↔</span></div>
                    <input type="range" id="ve-ba-range" min="5" max="95" value="50" aria-label="Compare before and after images">
                </div>
                <div class="ve-ba-caption"><span>DRAG TO COMPARE</span><span>INTERACTIVE IMAGE REVEAL</span></div>
            </section>

            <section class="ve-process ve-section" id="ve-process">
                <div class="ve-section-index ve-reveal">A SIMPLE ARRANGEMENT <span>04 — 04</span></div>
                <div class="ve-process-grid">
                    <div class="ve-process-title ve-reveal">
                        <p class="ve-kicker">HOW BABIN WORKS</p>
                        <h2>Three steps.<br><em>One less errand.</em></h2>
                        <p>Appointments are arranged directly with our team. No automated calendar or instant confirmation is implied by this demonstration.</p>
                    </div>
                    <div class="ve-steps">
                        <div class="ve-step ve-reveal"><span>01</span><div><h3>Make an enquiry</h3><p>Tell us the grooming service you have in mind.</p></div><b>↗</b></div>
                        <div class="ve-step ve-reveal"><span>02</span><div><h3>Share your details</h3><p>Choose your preferred location, date and time.</p></div><b>↗</b></div>
                        <div class="ve-step ve-reveal"><span>03</span><div><h3>Confirm directly</h3><p>Our team will discuss the request and confirm the arrangement with you.</p></div><b>↗</b></div>
                    </div>
                </div>
            </section>

            <section class="ve-request ve-section" id="ve-request">
                <div class="ve-request-bg"></div>
                <div class="ve-request-inner">
                    <div class="ve-request-copy ve-reveal">
                        <p class="ve-kicker">YOUR NEXT GROOMING VISIT</p>
                        <h2>Let us come<br><em>to your space.</em></h2>
                        <p>Build a visit request below. Your selections will be placed into a WhatsApp message for you to review and send. This is a request, not a confirmed booking.</p>
                        <div class="ve-contact-direct">
                            <a href="<?php echo esc_url( $phone_url ); ?>">Prefer to call? <strong>+234 703 268 1868</strong> <span>↗</span></a>
                        </div>
                    </div>
                    <form class="ve-request-form ve-reveal" id="ve-request-form">
                        <div class="ve-form-top"><span>VISIT REQUEST</span><span>01 / 03</span></div>
                        <label for="ve-service-select">01 — Grooming focus</label>
                        <select id="ve-service-select" name="service" required>
                            <option value="">Select a service concept</option>
                            <option>Haircut</option>
                            <option>Haircut and beard</option>
                            <option>Beard refinement</option>
                            <option>I'd like to discuss my requirements</option>
                        </select>
                        <label for="ve-location">02 — Preferred location</label>
                        <input id="ve-location" name="location" type="text" placeholder="e.g. Lekki Phase 1, Lagos" required>
                        <div class="ve-form-row">
                            <div><label for="ve-date">03 — Preferred date</label><input id="ve-date" name="date" type="date"></div>
                            <div><label for="ve-time">Preferred time</label><input id="ve-time" name="time" type="time"></div>
                        </div>
                        <label for="ve-name">04 — Your name</label>
                        <input id="ve-name" name="name" type="text" placeholder="Your full name">
                        <label for="ve-extra">Anything else we should know? <small>OPTIONAL</small></label>
                        <textarea id="ve-extra" name="extra" rows="3" placeholder="Add a note about your request"></textarea>
                        <button class="ve-button ve-button-dark ve-submit" type="submit">Prepare WhatsApp request <span>↗</span></button>
                        <p class="ve-form-disclaimer">Your WhatsApp app will open with the details you entered. Nothing is submitted until you send the message.</p>
                        <div class="ve-form-status" id="ve-form-status" role="status" aria-live="polite"></div>
                    </form>
                </div>
            </section>

            <section class="ve-faq ve-section">
                <div class="ve-faq-heading ve-reveal"><p class="ve-kicker">A FEW DETAILS</p><h2>Before you<br><em>make a request.</em></h2></div>
                <div class="ve-faq-list">
                    <details class="ve-faq-item ve-reveal"><summary>Where can I request a visit? <span>+</span></summary><p>You may request a visit at your home, office or another suitable location. The location will be discussed when you make your enquiry.</p></details>
                    <details class="ve-faq-item ve-reveal"><summary>Can I choose my preferred time? <span>+</span></summary><p>Yes. Include your preferred date and time in the request. The team will confirm whether the arrangement can be accommodated.</p></details>
                    <details class="ve-faq-item ve-reveal"><summary>Is my appointment confirmed immediately? <span>+</span></summary><p>No. Sending an enquiry is not a confirmed appointment. Your visit is confirmed only after the details have been agreed directly with the team.</p></details>
                </div>
            </section>

            <footer class="ve-footer">
                <div class="ve-footer-top">
                    <div><span class="ve-footer-overline">VESTIS ELITES GROOMING SUITE</span><h2>Make room for<br><em>better presentation.</em></h2></div>
                    <a class="ve-footer-cta" href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener">Enquire on WhatsApp <span>↗</span></a>
                </div>
                <div class="ve-footer-bottom">
                    <a class="ve-footer-brand" href="#ve-home">VESTIS <i>ELITES</i></a>
                    <span>PEOPLE. BUSINESSES. SOLUTIONS.</span>
                    <span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> VESTIS ELITES</span>
                    <a href="#ve-home">BACK TO TOP ↑</a>
                </div>
            </footer>

            <div class="ve-cursor" id="ve-cursor" aria-hidden="true"></div>
        </main>

        <style>
        /* All styles are scoped to .ve-babin. */
        body.ve-coded-babin #content, body.ve-coded-babin .site-content,
        body.ve-coded-babin .ast-container, body.ve-coded-babin #primary,
        body.ve-coded-babin .content-area { width:100%; max-width:none; margin:0; padding:0; }
        body.ve-coded-babin .site-content { display:block; }
        body.ve-coded-babin .entry-header, body.ve-coded-babin .entry-footer,
        body.ve-coded-babin .ast-page-builder-template .entry-header { display:none; }
        body.ve-coded-babin .site-main { margin:0; }
        body.ve-coded-babin .ast-container { padding-left:0; padding-right:0; }
        .ve-babin { --ink:#171916; --paper:#f1efe9; --white:#fff; --muted:#777970; --green:#1f4d3a; --line:rgba(23,25,22,.17); --serif:Georgia,'Times New Roman',serif; --sans:Arial,Helvetica,sans-serif; background:var(--paper); color:var(--ink); font-family:var(--sans); overflow:hidden; position:relative; }
        .ve-babin * { box-sizing:border-box; }
        .ve-babin a { color:inherit; text-decoration:none; }
        .ve-babin button,.ve-babin input,.ve-babin select,.ve-babin textarea { font:inherit; }
        .ve-babin button { cursor:pointer; }
        .ve-progress { position:fixed; z-index:1002; top:0; left:0; width:100%; height:3px; background:transparent; }
        .ve-progress span { display:block; width:0; height:100%; background:var(--green); }
        .ve-nav { position:absolute; z-index:50; top:0; left:0; width:100%; min-height:92px; padding:0 5.5vw; display:flex; align-items:center; justify-content:space-between; color:#fff; border-bottom:1px solid rgba(255,255,255,.22); transition:background .35s,color .35s,min-height .35s; }
        .ve-nav.ve-nav-scrolled { position:fixed; min-height:72px; color:var(--ink); background:rgba(241,239,233,.94); backdrop-filter:blur(18px); border-color:var(--line); }
        .ve-wordmark { display:flex; flex-direction:column; gap:5px; }
        .ve-wordmark-main,.ve-footer-brand { font-family:var(--serif); font-size:20px; letter-spacing:.13em; }
        .ve-wordmark-main i,.ve-footer-brand i { font-style:normal; font-weight:400; }
        .ve-wordmark-sub { font-size:8px; letter-spacing:.23em; }
        .ve-nav-links { display:flex; gap:34px; margin-left:10%; }
        .ve-nav-links a,.ve-nav-cta,.ve-mode-toggle { font-size:10px; letter-spacing:.12em; text-transform:uppercase; }
        .ve-nav-links a { opacity:.8; transition:opacity .2s; }
        .ve-nav-links a:hover { opacity:1; }
        .ve-nav-actions { display:flex; align-items:center; gap:22px; }
        .ve-mode-toggle { border:0; background:transparent; color:inherit; display:flex; gap:8px; align-items:center; padding:10px 0; }
        .ve-mode-icon { font-size:17px; }
        .ve-nav-cta { border:1px solid currentColor; padding:13px 17px; }
        .ve-nav-cta span { margin-left:14px; }
        .ve-menu-toggle { display:none; border:0; background:transparent; color:inherit; padding:8px; }
        .ve-menu-toggle span { display:block; width:22px; height:1px; background:currentColor; margin:6px 0; }
        .ve-mobile-menu { position:fixed; z-index:49; top:72px; left:0; width:100%; padding:22px 6vw 30px; background:var(--paper); color:var(--ink); }
        .ve-mobile-menu a { display:block; padding:15px 0; border-bottom:1px solid var(--line); text-transform:uppercase; font-size:11px; letter-spacing:.12em; }
        .ve-hero { min-height:790px; height:min(900px,100svh); position:relative; display:flex; align-items:center; padding:140px 11vw 100px; background:#1c211d; color:#fff; isolation:isolate; }
        .ve-hero-image { position:absolute; z-index:-3; inset:0; background:linear-gradient(90deg,rgba(10,14,11,.84) 0%,rgba(10,14,11,.56) 48%,rgba(10,14,11,.13) 100%),url('https://images.unsplash.com/photo-1503951914875-452162b0f3f1?auto=format&fit=crop&w=2200&q=85
