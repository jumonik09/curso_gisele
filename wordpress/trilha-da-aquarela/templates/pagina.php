<?php

defined('ABSPATH') || exit;

get_header();

$assets_url = trailingslashit(plugins_url('assets', dirname(__DIR__) . '/trilha-da-aquarela.php'));
$video_url = get_post_meta(get_queried_object_id(), 'gv_aquarela_video_url', true);
if (!$video_url && is_readable(dirname(__DIR__) . '/assets/previa.mp4')) {
    $video_url = $assets_url . 'previa.mp4';
}
$content = file_get_contents(__DIR__ . '/conteudo.html');

echo strtr($content, array(
    '{{assets}}'       => esc_url($assets_url),
    '{{video_source}}' => $video_url ? 'data-source="' . esc_url($video_url) . '"' : '',
));

get_footer();
