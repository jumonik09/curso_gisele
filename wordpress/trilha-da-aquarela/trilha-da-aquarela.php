<?php
/**
 * Plugin Name: Trilha da Aquarela — Giselle Vargas
 * Description: Página do curso com o cabeçalho, o rodapé e o menu principal do site.
 * Version: 1.3.2
 */

defined('ABSPATH') || exit;

const GV_AQUARELA_VERSION = '1.3.2';
const GV_AQUARELA_SLUG = 'curso-de-aquarela';
const GV_AQUARELA_TEMPLATE = 'gv-trilha-da-aquarela.php';

register_activation_hook(__FILE__, 'gv_aquarela_create_page');

function gv_aquarela_create_page() {
    if (get_page_by_path(GV_AQUARELA_SLUG, OBJECT, 'page')) {
        return;
    }

    $page_id = wp_insert_post(array(
        'post_title'    => 'Trilha da Aquarela',
        'post_name'     => GV_AQUARELA_SLUG,
        'post_type'     => 'page',
        'post_status'   => 'publish',
        'page_template' => GV_AQUARELA_TEMPLATE,
    ), true);

    if (is_wp_error($page_id)) {
        wp_die(esc_html($page_id->get_error_message()));
    }
}

add_filter('theme_page_templates', function ($templates) {
    $templates[GV_AQUARELA_TEMPLATE] = 'Trilha da Aquarela';
    return $templates;
});

add_filter('template_include', function ($template) {
    return is_page_template(GV_AQUARELA_TEMPLATE)
        ? __DIR__ . '/templates/pagina.php'
        : $template;
});

add_filter('body_class', function ($classes) {
    if (is_page_template(GV_AQUARELA_TEMPLATE)) {
        $classes[] = 'gv-aquarela-page';
    }

    return $classes;
});

add_action('wp_enqueue_scripts', function () {
    if (!is_page_template(GV_AQUARELA_TEMPLATE)) {
        return;
    }

    wp_enqueue_style('gv-aquarela', plugins_url('assets/estilo.css', __FILE__), array(), GV_AQUARELA_VERSION);
    wp_enqueue_script('gv-aquarela', plugins_url('assets/pagina.js', __FILE__), array(), GV_AQUARELA_VERSION, true);
});

add_filter('wp_nav_menu_items', function ($items, $args) {
    if (!in_array($args->theme_location, array('primary', 'mobile_menu'), true)) {
        return $items;
    }

    $page = get_page_by_path(GV_AQUARELA_SLUG, OBJECT, 'page');
    if (!$page || 'publish' !== $page->post_status) {
        return $items;
    }

    $url = get_permalink($page);
    if (!$url || strpos($items, esc_url($url)) !== false) {
        return $items;
    }

    $current = is_page($page->ID);
    return $items . sprintf(
        '<li class="menu-item%s"><a class="menu-link" href="%s"%s>Trilha da Aquarela</a></li>',
        $current ? ' current-menu-item' : '',
        esc_url($url),
        $current ? ' aria-current="page"' : ''
    );
}, 10, 2);

add_action('add_meta_boxes_page', function ($page) {
    if (GV_AQUARELA_SLUG !== $page->post_name) {
        return;
    }

    add_meta_box('gv-aquarela-preview', 'Vídeo da Trilha da Aquarela', function ($page) {
        wp_nonce_field('gv_aquarela_save_video', 'gv_aquarela_video_nonce');
        $url = get_post_meta($page->ID, 'gv_aquarela_video_url', true);
        echo '<p><label for="gv-aquarela-video-url">URL direta do vídeo (MP4)</label></p>';
        printf('<input class="widefat" id="gv-aquarela-video-url" name="gv_aquarela_video_url" type="url" value="%s">', esc_attr($url));
        echo '<p>Envie o vídeo oficial pela Biblioteca de mídia e cole aqui o URL do arquivo.</p>';
    }, 'page', 'normal');
});

add_action('save_post_page', function ($page_id) {
    if (!isset($_POST['gv_aquarela_video_nonce'], $_POST['gv_aquarela_video_url'])
        || !is_string($_POST['gv_aquarela_video_nonce'])
        || !is_string($_POST['gv_aquarela_video_url'])
        || wp_is_post_autosave($page_id)
        || wp_is_post_revision($page_id)
        || !current_user_can('edit_post', $page_id)
        || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['gv_aquarela_video_nonce'])), 'gv_aquarela_save_video')) {
        return;
    }

    $url = esc_url_raw(trim(wp_unslash($_POST['gv_aquarela_video_url'])), array('https', 'http'));
    if ('' === $url) {
        delete_post_meta($page_id, 'gv_aquarela_video_url');
        return;
    }

    update_post_meta($page_id, 'gv_aquarela_video_url', $url);
});
