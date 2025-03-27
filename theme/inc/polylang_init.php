<?php

// Register strings for translation in Polylang
function voice_smm_register_strings() {
    if (function_exists('pll_register_string')) {
        // Заголовки
        pll_register_string('social-networks', 'Social Networks', 'voice-smm-theme');
        pll_register_string('language-switcher', 'Language Switcher', 'voice-smm-theme');
        pll_register_string('contacts', 'Contacts', 'voice-smm-theme');

        // Копирайт
        pll_register_string('copyright', '© %d %s. All rights reserved.', 'voice-smm-theme');

        // Названия социальных сетей
        pll_register_string('facebook', 'Facebook', 'voice-smm-theme');
        pll_register_string('instagram', 'Instagram', 'voice-smm-theme');
        pll_register_string('whatsapp', 'WhatsApp', 'voice-smm-theme');
        pll_register_string('telegram', 'Telegram', 'voice-smm-theme');
    }
}
add_action('init', 'voice_smm_register_strings');
