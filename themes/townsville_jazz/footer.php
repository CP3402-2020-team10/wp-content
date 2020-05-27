<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package townsvillejazz
 */

?>

<footer id="colophon" class="site-footer" role="contentinfo">
    <nav class="social-menu">
        <?php wp_nav_menu(array('theme_location' => 'social')); ?>
    </nav>
        <?php
        echo date_i18n(_x('Y', 'copyright date format', 'Townsville Jazz Club'));
        ?>

        <?php
        if (function_exists('the_privacy_policy_link')) {
            the_privacy_policy_link('', '<span role="separator" aria-hidden="true"></span>');
        }
        ?>
    </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
