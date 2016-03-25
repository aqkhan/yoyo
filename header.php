<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="<?php bloginfo('name'); ?><?php wp_title('|', true, 'right'); ?>" />
    <meta property="og:url" content="<?php echo "{http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]}"; ?>" />
    <meta property="og:image" content="<?php bloginfo('template_url'); ?>/images/logo.png" />
    <meta property="og:type" content="website">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_meta();?>
    <title><?php bloginfo('name'); ?><?php wp_title('|', true, ''); ?></title>
    <?php wp_head(); ?>
</head>