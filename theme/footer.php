<?php get_template_part('template-parts/sprite'); ?>

    </div><!-- #page -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-widgets">
                <div class="footer-widget">
                    
                    <a href="/">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer_logo.svg" alt="logo">
                    </a>

                    <h3 class="widget-title visually-hidden"><?php pll_e('Social Networks'); ?></h3>
                    
                    <div class="social-links">
                        <?php
                        $social_networks = array(
                            'facebook' => array(
                                'url' => voice_smm_get_contact('facebook'),
                                'label' => 'Facebook'
                            ),
                            'instagram' => array(
                                'url' => voice_smm_get_contact('instagram'),
                                'label' => 'Instagram'
                            ),
                            'whatsapp' => array(
                                'url' => 'https://wa.me/' . preg_replace('/[^0-9]/', '', voice_smm_get_contact('whatsapp')),
                                'label' => 'WhatsApp'
                            ),
                            'telegram' => array(
                                'url' => voice_smm_get_contact('telegram'),
                                'label' => 'Telegram'
                            )
                        );

                        if($social_networks['facebook']['url']): ?>
                            <a href="<?php echo esc_url($social_networks['facebook']['url']); ?>" class="social-link facebook" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($social_networks['facebook']['label']); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/social-facebook.png" alt="<?php echo esc_attr($social_networks['facebook']['label']); ?>">
                            </a>
                        <?php endif; ?>
                        <?php if($social_networks['instagram']['url']): ?>
                            <a href="<?php echo esc_url($social_networks['instagram']['url']); ?>" class="social-link instagram" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($social_networks['instagram']['label']); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/social-instagram.png" alt="<?php echo esc_attr($social_networks['instagram']['label']); ?>">
                            </a>
                        <?php endif; ?>
                        <?php if($social_networks['whatsapp']['url']): ?>
                            <a href="<?php echo esc_url($social_networks['whatsapp']['url']); ?>" class="social-link whatsapp" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($social_networks['whatsapp']['label']); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/social-whatsup.png" alt="<?php echo esc_attr($social_networks['whatsapp']['label']); ?>">
                            </a>
                        <?php endif; ?> 
                        <?php if($social_networks['telegram']['url']): ?>
                            <a href="<?php echo esc_url($social_networks['telegram']['url']); ?>" class="social-link telegram" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($social_networks['telegram']['label']); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/social-telegram.png" alt="<?php echo esc_attr($social_networks['telegram']['label']); ?>">
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <h3 class="widget-title visually-hidden"><?php pll_e('Language Switcher'); ?></h3>
                    <ul>
                        <li><a href="/"><?php esc_html_e('UA', 'voice-smm-theme'); ?></a></li>
                        <li><a href="/ru"><?php esc_html_e('RU', 'voice-smm-theme'); ?></a></li>
                        <li><a href="/en"><?php esc_html_e('EN', 'voice-smm-theme'); ?></a></li>
                    </ul>
                </div>

                <div class="footer-widget">
                    <h3 class="widget-title visually-hidden"><?php pll_e('Contacts'); ?></h3>
                    <?php if ($phone = voice_smm_get_contact('phone')) : ?>
                        <p class="contact-item">
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>">
                                <?php echo esc_html($phone); ?>
                            </a>
                        </p>
                    <?php endif; ?>

                    <?php if ($email = voice_smm_get_contact('email')) : ?>
                        <p class="contact-item">
                            <a href="mailto:<?php echo esc_attr($email); ?>">
                                <?php echo esc_html($email); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="footer-widget"><?php esc_html_e('Column', 'voice-smm-theme'); ?></div>
                <div class="footer-widget">Col</div>
            </div>

            <div class="site-info">
                <?php
                printf(
                    pll__('© %d %s. All rights reserved.'),
                    date('Y'),
                    get_bloginfo('name')
                );
                ?>
            </div>
            
            <nav class="footer-navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'depth'          => 1,
                    )
                );
                ?>
            </nav>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html> 