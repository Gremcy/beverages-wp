<?php get_header(); ?>

<body class="information-page">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W3387M6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="fluid-wrapper">
        <main class="information-main">
            <?php get_template_part('parts/_header'); ?>

            <div class="information-fluid">
                <?php if(get_field('active_1')): ?>
                    <div class="information-block">
                        <?php $text = get_field('title_1'); if($text): ?>
                            <div class="information-left"><?php echo $text; ?></div>
                        <?php endif; ?>

                        <div class="information-right">
                            <?php $list = get_field('list_1'); if(is_array($list) && count($list)): ?>
                                <?php foreach ($list as $m => $li): ?>
                                    <div class="information-right-text">
                                        <?php if(is_array($li['icon']) && count($li['icon'])): ?>
                                            <img src="<?php echo $li['icon']['sizes']['480x0']; ?>" alt="" loading="lazy">
                                        <?php endif; ?>
                                        <span><?php echo $li['title']; ?></span>
                                    </div>
                                    <?php if($m === 0): ?>
                                        <?php echo str_ireplace(['<p>', '</p>', '<ul>'], ['<div class="information-right-gray-text">', '</div>', '<ul class="information-right-list">'], $li['text']); ?>
                                    <?php else: ?>
                                        <?php echo str_ireplace(['<ul>'], ['<ul class="information-right-list">'], $li['text']); ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php $list = get_field('list_1_2'); if(is_array($list) && count($list)): ?>
                                <div class="information-right-frame">
                                    <?php foreach ($list as $m => $li): ?>
                                        <?php if($li['title']): ?>
                                            <p class="information-right-frame-black"><?php echo $li['title']; ?></p>
                                        <?php endif; ?>
                                        <?php if($li['text']): ?>
                                            <?php echo $li['text']; ?>
                                        <?php endif; ?>
                                        <?php if($li['text_2']): ?>
                                            <div class="information-right-frame-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9 0C4.02833 0 0 4.02796 0 9C0 13.972 4.02796 18 9 18C13.972 18 18 13.9698 18 9C18 4.03017 13.972 0 9 0ZM10.2877 14.0762C10.2877 14.7824 9.70824 15.3618 9.00202 15.3618C8.29581 15.3618 7.71634 14.7824 7.71634 14.0762V8.93341C7.71634 8.22719 8.29581 7.64772 9.00202 7.64772C9.70824 7.64772 10.2877 8.22719 10.2877 8.93341V14.0762ZM9.00202 5.20714C8.29176 5.20714 7.71634 4.63168 7.71634 3.92145C7.71634 3.21122 8.2918 2.63576 9.00202 2.63576C9.71229 2.63576 10.2877 3.21122 10.2877 3.92145C10.2877 4.63168 9.71225 5.20714 9.00202 5.20714Z" fill="#9F9F9F"/></svg>
                                                <span><?php _e( 'Зверніть увагу!', \PS::$theme_name ); ?></span>
                                            </div>
                                            <?php if($m === 0): ?>
                                                <?php echo str_ireplace('<p>', '<p class="mb-30">', $li['text_2']); ?>
                                            <?php else: ?>
                                                <?php echo $li['text_2']; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="information-atention">
                                <?php $text = get_field('title_1_3'); if($text): ?>
                                    <div class="information-atention-title"><?php echo $text; ?></div>
                                <?php endif; ?>
                                <?php $text = get_field('text_1_3'); if($text): ?>
                                    <div class="information-atention-description"><?php echo $text; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(get_field('active_2')): ?>
                    <div class="information-block">
                        <?php $text = get_field('title_2'); if($text): ?>
                            <div class="information-left"><?php echo $text; ?></div>
                        <?php endif; ?>
                        <?php $text = get_field('text_2'); if($text): ?>
                            <div class="information-right"><?php echo str_ireplace(['<p>', '</p>'], ['<div class="information-right-text"><span>', '</span></div>'], $text); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if(get_field('active_3')): ?>
                    <div class="information-block">
                        <?php $text = get_field('title_3'); if($text): ?>
                            <div class="information-left"><?php echo $text; ?></div>
                        <?php endif; ?>
                        <?php $text = get_field('text_3'); if($text): ?>
                            <div class="information-right"><?php echo str_ireplace(['<p>', '</p>'], ['<div class="information-right-text"><span>', '</span></div>'], $text); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php get_template_part('parts/_footer'); ?>
        </main>

        <?php get_template_part('parts/_popups'); ?>
    </div>

    <?php /* DON'T REMOVE THIS */ ?>
    <?php get_footer(); ?>
    <?php /* END */ ?>

    <?php /* WRITE SCRIPTS HERE */ ?>

    <?php /* END */ ?>

</body>
</html>