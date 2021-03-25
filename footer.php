<footer class="footer">
    <div class="container">
            <div class="footer-menu-bar">
                <?php dynamic_sidebar( 'sidebar-footer' ); ?>
            </div><!-- #secondary -->
            <div class="footer-info">
            <?php
            wp_nav_menu( [
                'theme_location'  => 'footer_menu',
                'container'       => 'nav',
                'menu_class'      => 'footer-nav', 
                'echo'            => true,
            ] );
            $instance = array(
                'social_link_fb' => 'https://fb.com/',
                'social_link_youtube' => 'https://youtube.com/',
                'social_link_twitter' => 'https://twitter.com/',
                'title' => '',
            );
            $args = array(
                'before_widget' => '<div class="footer-social">',
                'after_widget' => '</div>',
            );
            the_widget( 'Social_Widget', $instance, $args ); ?>
            </div>
            <div class="footer-text-wrapper">
                <?php dynamic_sidebar( 'sidebar-footer-text' ); ?>
                <span class="footer-copyright"><?php echo '2021' . '&copy' . get_bloginfo( 'name' ); ?></span>
            </div>
    </div>
</footer>    
    <?php wp_footer(); ?>
    </body>
</html>
