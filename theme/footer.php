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

                        foreach ($social_networks as $network => $data) {
                            if (!empty($data['url'])) {
                                printf(
                                    '<a href="%s" class="social-link %s" target="_blank" rel="noopener noreferrer" aria-label="%s"><svg class="social-icon"><use xlink:href="#%s"></use></svg></a>',
                                    esc_url($data['url']),
                                    esc_attr($network),
                                    esc_attr($data['label']),
                                    esc_attr($network)
                                );
                            }
                        }
                        ?>
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