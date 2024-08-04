<?php
class Auto_Language_Polylang {
    public function init() {
        add_action('save_post', array($this, 'detect_and_set_language'), 10, 1);
    }

    public function detect_and_set_language($post_id) {
        if (wp_is_post_revision($post_id) || !current_user_can('edit_post', $post_id)) {
            return;
        }

        $post_content = get_post_field('post_content', $post_id);
        if (empty($post_content)) {
            return;
        }

        $detected_lang = $this->detect_language($post_content);
        if (!$detected_lang) {
            return;
        }

        if (function_exists('pll_set_post_language')) {
            pll_set_post_language($post_id, $detected_lang);
        }
    }

    private function detect_language($text) {

        $lang_patterns = array(
            'fr' => '/\b(le|la|les|un|une|des|est|sont|et|ou)\b/i',
            'en' => '/\b(the|a|an|is|are|and|or)\b/i',
        );

        $max_count = 0;
        $detected_lang = '';

        foreach ($lang_patterns as $lang => $pattern) {
            $count = preg_match_all($pattern, $text);
            if ($count > $max_count) {
                $max_count = $count;
                $detected_lang = $lang;
            }
        }

        return $detected_lang;
    }
}