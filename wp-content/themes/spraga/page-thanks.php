<?php get_header(); ?>

<body class="succesful-order-page">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W3387M6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="fluid-wrapper">
        <main class="order-main">
            <?php get_template_part('parts/_header'); ?>

            <div class="succesful-fluid">
                <div class="succesful-content">
                    <div class="succesful-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100" fill="none"><g clip-path="url(#clip0_1319_8224)"><path fill-rule="evenodd" clip-rule="evenodd" d="M44.6427 59.1957L66.5401 37.2984C67.7602 36.0783 69.7396 36.0783 70.9597 37.2984C72.1798 38.5185 72.1798 40.4979 70.9597 41.718L46.8526 65.8251C45.6325 67.0452 43.653 67.0452 42.4329 65.8251L29.0401 52.4323C27.82 51.2122 27.82 49.2327 29.0401 48.0127C30.2602 46.7926 32.2396 46.7926 33.4597 48.0127L44.6427 59.1957Z" fill="#00C100"/><path fill-rule="evenodd" clip-rule="evenodd" d="M74.3065 74.3059C60.8918 87.7206 39.1085 87.7206 25.6938 74.3059C12.2791 60.8912 12.2791 39.1079 25.6938 25.6932C39.1085 12.2785 60.8918 12.2785 74.3065 25.6932C84.8813 36.2679 87.122 52.0426 81.0245 64.8196C80.2807 66.3774 80.9422 68.2429 82.4974 68.9867C84.0539 69.7291 85.9221 69.0675 86.6646 67.511C93.8691 52.4125 91.224 33.7701 78.7268 21.2729C62.8726 5.41867 37.1277 5.41865 21.2735 21.2729C5.4193 37.1271 5.41932 62.872 21.2735 78.7262C37.1277 94.5804 62.8726 94.5804 78.7268 78.7262C79.9466 77.5064 79.9466 75.5256 78.7268 74.3059C77.5071 73.0861 75.5263 73.0861 74.3065 74.3059Z" fill="#00C100"/></g><defs><clipPath id="clip0_1319_8224"><rect width="100" height="100" fill="white"/></clipPath></defs></svg>
                    </div>
                    <?php $text = get_field('success_title', \PS::$option_page); if($text): ?>
                        <div class="succesful-title"><?php echo $text; ?></div>
                    <?php endif; ?>
                    <?php $text = get_field('success_text', \PS::$option_page); if($text): ?>
                        <div class="succesful-description"><?php echo $text; ?></div>
                    <?php endif; ?>
                </div>
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