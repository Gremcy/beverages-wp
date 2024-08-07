<!DOCTYPE html>
<html lang="<?php echo \PS::$current_language; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<title><?php $wp_title = wp_title('', false); echo $wp_title; ?></title>
    <meta name="description" content='<?php $context = PS::get_context(); echo $context['seo_description']; ?>'>

    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo \PS::$assets_url; ?>images/favicon.png" />
					
    <meta property="og:title" content="<?php echo $wp_title; ?>"/>					
    <meta property="og:description" content="<?php echo $context['seo_description']; ?>"/>					
    <meta property="og:type" content="website" />					
	
	<?php $img = get_field('img'); if(is_array($img) && count($img)): ?>
        <meta property="og:image" content="<?php echo $img['sizes']['960x0']; ?>" />
    <?php else: ?>
        <?php $og_img = get_field('og_img', \PS::$option_page); if(is_array($og_img) && count($og_img)): ?>
            <meta property="og:image" content="<?php echo $og_img['sizes']['960x0']; ?>" />
        <?php endif; ?>
    <?php endif; ?>

    <meta name="facebook-domain-verification" content="3aajapn09xpqmdnkrdoagliojrueir" />

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-W3387M6');</script>
    <!-- End Google Tag Manager -->

	<?php /* DON'T REMOVE THIS */ ?>
	<?php wp_head(); ?>
	<?php /* END */ ?>
</head>