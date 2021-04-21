<?php 
// Setup conditional testimonial item classes to pass to post_class()
$entry_class = 'entry testimonial-item';
$entry_class .= ( $display_type === 'slider' ) ? ' splide__slide' : '';

if ( $testimonials_loop->have_posts() ) : ?>

    <div id="orgnk-testimonials-<?php echo $instance ?>" class="orgnk-testimonials type-<?php echo $display_type ?>">
        <div class="testimonials-list<?php echo ( $display_type === 'slider' ) ? ' splide splide-dot-pagination' : '' ?>">

            <?php
            // Add wrappers for Splide slider
            if ( $display_type === 'slider' ) : ?>
                <div class="splide__track">
                <div class="splide__list">
            <?php endif ?>

            <?php while ( $testimonials_loop->have_posts() ) : $testimonials_loop->the_post();

                if ( $display_type === 'list' && $testimonials_loop->current_post > 0 ) echo '<hr>';

                // Variables
                $name           = esc_html( get_the_title() );
                $position       = esc_html( get_post_meta( get_the_ID(), 'testimonial_position', true ) );
                $company        = esc_html( get_post_meta( get_the_ID(), 'testimonial_company', true ) );
                $attribute      = array( $name, $position, $company );

                // Only display the testimonial if it has a quote (content) set
                if ( get_the_content() ) : ?>

                    <div <?php post_class( $entry_class ) ?>>
                        <blockquote>
                            <?php echo wpautop( wp_kses_post( get_the_content() ) ) ?>
                            <p class="attribution"><?php echo implode( ', ', array_filter( $attribute ) ) ?></p>
                        </blockquote>
                    </div>
                <?php endif; 
            endwhile; wp_reset_postdata() ?>

            <?php
            // Close Splide slider wrappers
            if ( $display_type === 'slider' ) : ?>
                </div>
                </div>
            <?php endif ?>
        </div>
    </div>

<?php endif;
