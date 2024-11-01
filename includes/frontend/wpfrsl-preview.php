<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <title><?php wp_title( '|', true, 'right' ); ?></title>
          <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
         <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <div class="wpfrsl-preview-container">
    <div id="content" class="site-content ">
      <h1 id="logo" style="text-align: center">
      <img src='<?php echo esc_attr(WPFRSL_BACKEND_IMG_DIR); ?>wpfrsl-logo.png' alt="plugin-logo" />
      </h1>
      <h2 style="text-align: center">Preview Mode</h2>
      <p style="text-align: center">You are simply viewing this preview page.</p>

      <div class="wpfrsl-review-preview">
          <?php 
            if(isset($_GET['reviewid']))
            {
              $id = intval(sanitize_text_field($_GET['reviewid']));
              echo do_shortcode("[wpfrsl_reviews id='".$id."']"); 
            }
          ?>
      </div>
    </div>
  </div>
<?php wp_footer();?>
</body>
</html>
