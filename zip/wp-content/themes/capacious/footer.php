<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package capacious
 */
 $copyright_text= capacious_get_option( 'capacious_copyright_text_option');
 
?>
 <!-- Footer Section Start Here -->
  <footer id="footer">
    <section class="footer-section">
     <?php 
   if(!empty($copyright_text))
    {
    ?>
      <div class="footer-bottom">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
              <p class="copyright "><?php echo wp_kses_post($copyright_text); ?> </p>
            </div>
          </div>
        </div>
      </div>
  <?php } ?>

    </section>
  </footer>
  <!-- End footer -->
  <a class="scroll-top fa fa-angle-up" href="javascript:void(0)"></a>

<?php wp_footer(); ?>

</body>
</html>
