<?php
    define("THEME_VERSION", "2.1.2");
    // Racine du thème dans l'arborescence
    $temp = explode("wp-content/themes/", get_bloginfo("template_url"));
    define("THEME_ROOT", get_theme_root()."/".$temp[1]);
    define("SITE_URL", get_bloginfo("wpurl"));

    require_once(__DIR__."/core/lib/Date_Difference.class.php");
    require_once(__DIR__."/core/lib/adminMetaBoxes.php");
    require_once(__DIR__."/functions.thumbnail.php");

    // Add the pear directory to the include_path configuration directive
    set_include_path(get_include_path() . PATH_SEPARATOR . '/home/branchet/php');

    // Load Cache Lite from Pear
    include_once 'Cache/Lite.php';
    if ( class_exists("Cache_Lite") ) {
      $Cache_Lite = new Cache_Lite(array("lifeTime" => 60*60*24));
    }

    // Add theme support for thumbnail
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size(200, 200, true);

    add_filter('tiny_mce_before_init', 'add_iframe');
    add_filter('the_excerpt', 'get_post_rss');
    add_filter('the_content', 'get_post_rss');
    add_filter('pre_option_posts_per_page', 'limit_posts_per_page');
    add_filter( 'excerpt_length', 'matilda_excerpt_length', 999 );
    add_filter('excerpt_more', 'matilda_excerpt_more');


    // permet d'afficher les messages d'erreur
    if( isset($_GET['debug']) ) {

      ini_set('display_errors', 1);
      ini_set('log_errors', 1);
      error_reporting(E_ALL);

    } else {
      ini_set('display_errors', 0);
      ini_set('log_errors', 0);
      error_reporting(null);
    }

    function add_iframe($arr) {
        $arr['extended_valid_elements'] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
        return $arr;
    }


    function more_allowedposttags($allowedposttags) {

        $allowedposttags += array(
          'iframe' => array(
            'src' => array(),
            'height' => array(),
            'width' => array(),
            'style' => array(),
            'id' => array(),
               'type' => array (),
               'name' => array ()
          ),
          'object' => array (
             'id' => array (),
             'classid' => array (),
             'data' => array (),
             'type' => array (),
             'width' => array (),
             'height' => array (),
             'allowfullscreen' => array ()),
          'param' => array (
             'name' => array (),
             'value' => array ()),
          'embed' => array (
             'id' => array (),
             'style' => array (),
             'src' => array (),
             'type' => array (),
             'height' => array (),
             'width' => array (),
             'quality' => array (),
             'name' => array (),
             'flashvars' => array (),
             'allowscriptaccess' => array (),
             'allowfullscreen' => array ())
          );

        return $allowedposttags;
    }

    /**
     * SORRY, have to be called after the function declaration
     */
    global $allowedposttags;
    $allowedposttags = more_allowedposttags($allowedposttags);

    function matilda_excerpt_length( $length ) {
      return 56;
    }

    function matilda_excerpt_more( $more ) {

      global $post;
      return '...&nbsp;<a href="'. get_permalink($post->ID) . '">Lire&nbsp;la&nbsp;suite&nbsp;‣</a>';
    }

    function limit_posts_per_page() {
      return 24; // default: 12 posts per page
    }

    function get_timestamp() {
        global $post;
        return strtotime($post->post_date);
    }

    function get_pretty_date($t = false) {
        $time = ! $t ? get_timestamp() : (int) $t;
        return Date_Difference::getString( new DateTime("@".$time) );
    }

    function matilda_the_image($width = 100, $height = 100, $p = false, $fallback=true) {
      global $post;

      if($p === false) {
        $p = $post;
      }

      // Gets the featured image
      if( $thumb = get_post_thumbnail_id($p->ID, 'full') ) {

        $thumb = wp_get_attachment_image_src( $thumb );
        // Take the first line (URL)
        $thumb = (string) $thumb[0];
        // Remove the hostname
        $thumb = str_replace(get_bloginfo("home"), "", $thumb );

      }

      // Or gets the image from the custom value "Image"
      if( !$thumb && $values = get_post_custom_values("Image", $p->id) ) {

        $thumb  = $values[0];

      }

      // Or take the first attached image
      if( !$thumb ) {

        // Find all attachment
        $attachment = get_posts( array(
          'post_type' => 'attachment',
          'posts_per_page' => -1,
          'post_parent' => $p->ID
        ) );

        // Looks for an image
        foreach($attachment as & $a) {

          // Is there an image ?
          if( $a->post_mime_type == "image/jpeg" || $a->post_mime_type == "image/png" ) {

            $thumb = $a->guid;
            // Remove the hostname
            $thumb = str_replace(get_bloginfo("home"), "", $thumb );
            // Breaks the loop
            break;
          }

        }
      }

      if($fallback && !$thumb) {

        $attachments = get_posts(
          array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_parent' => $post->ID
          )
        );

        $thumb = get_bloginfo('template_url')."/core/img/bg-dark.jpg";
        foreach($attachments as $attach) {
          // Is it a valid image ?
          if(in_array($attach["post_mime_type"], array("image/jpeg", "image/png") ) ) {
            $thumb = $attach["guid"];
            break;
          }
        }

      }

      if(!$thumb) return false;
      else {
        $thumb = SITE_URL . "/" . $thumb;
        $img = matthewruddy_image_resize($thumb, $width, $height, true, true);
        return $img["url"];
      }

    }


    function get_post_rss($content) {
    	if(is_feed())
    	{
    		// ajoute le sous-titre
    		if( get_post_custom_values("sub_title") )
    		{
    			$sub_title = get_post_custom_values("sub_title");
    			$content = "<h2>".$sub_title[0]."</h2>".$content;
    		}

    		// message pour mp3s et vidéos
    		if( in_category('mp3'))
    		{
    			$content = $content."<br /><i>[ si le lecteur ne s'affiche pas, consultez le mp3 directement sur la <a href=\"".get_permalink()."\">page originale de l'article</a> ]</i>";
    		}
    		elseif( in_category('videos'))
    		{
    			$content = $content."<br /><i>[ si le la vidéo ne s'affiche pas, visionnez la directement sur la <a href=\"".get_permalink()."\">page originale de l'article</a> ]</i>";
    		}
    	}
      return $content;
    }


    function matilda_facebook_like_meta() {
      global $post;

      if(is_single()) {
          ?>
              <meta property="og:title" content="<? the_title(); ?>"/>
              <meta property="og:image" content="<?= matilda_the_image(120, 120)?>"/>
          <?php
      } ?>

      <meta property="og:image" content="<?php echo bloginfo('template_url'); ?>/core/img/mg.png"/>
      <meta property="og:site_name" content="Branche ton Sonotone"/>
      <meta property="fb:app_id" content="121928381175000"/>

      <?php
    }


    function get_article_layout_class() {

    	$layout = get_post_custom_values("article_layout");

    	switch($layout[0]) {

    		case "2-col":
    			return array("js-columnize", "js-col2", "left-10");
    			break;

    		case "3-col":
    			return array("js-columnize", "js-col3", "left-10");
    			break;

    		case "disabled":
    			return array("left-10");
    			break;

        default:
          // Return a special class for the mp3s
          return is_mp3_layout() ? array("auto", "left-10") : array("left-10");
          break;

    	}

    }

    /**
     *
     */
    function is_mp3_layout() {

      // Layout format
      $layout = get_post_custom_values("article_layout");

      return in_category("mp3")
          // Legacy support for no auto formating
          && ! get_post_custom_values("no_auto_format")
          // Avoid dupplicate formating
          && ! in_array("disabled", $layout)
          && ! in_array("3-col", $layout)
          && ! in_array("2-col", $layout);
    }

    function matilda_comment($comment, $args, $depth) {

      $GLOBALS['comment'] = $comment; ?>

      <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

        <div id="comment-<?php comment_ID(); ?>">

          <div class="comment-avatar">
            <?php echo get_avatar($comment,$size='32',$default='mm' ); ?>
          </div>

          <div class="comment-text">
            <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
            <?php comment_text() ?>

            <?php if ($comment->comment_approved == '0') : ?>
             <em><?php _e('Ton commentaire va être modéré. Patience petit scarabée.') ?></em>
             <br />
            <?php endif; ?>
          </div>

          <div class="comment-meta commentmetadata">
            <a title="<?php comment_date('l j F Y') ?> à <?php comment_time() ?>"
               href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
              <?php echo get_pretty_date( get_comment_date( strtotime("{$comment->comment_date_gmt} GMT") ) ) ?>
            </a>
            <?php edit_comment_link(__('(Edit)'), ' · ','') ?>
          </div>

          <div class="reply">
            <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
          </div>

        </div>

      <?php // Without closing tag </li> because add it automaticly
    }

    function matilda_post_meta($prefix = "", $suffix = "") {

        global $post;
        echo $prefix; ?>

        <?php if( ! is_page() ) : ?>

          <abbr title="<?php the_time('l j F Y') ?> à <?php the_time() ?>">
            <?php echo get_pretty_date(); ?>
          </abbr>
            dans <span class="categories"><?php the_category(', ') ?></span>
            par <?php the_author_posts_link(); ?>


          <?php
          if( get_post_custom_values("views") && is_user_logged_in() ) {
               $views = get_post_custom_values("views");
               echo ' · '.$views[0].' visites';
          }

          edit_post_link(__('(Edit)'), ' · ','');

        endif;
        echo $suffix;
    }


    function matilda_chronique_block() {

      global $post;

      $layout = get_post_custom_values("article_layout");

      // Not a chronique
      if( ! in_category('chroniques')
      // or auto format disabled
      || $layout === "disabled"
      // or legacy format isabled
      || get_post_custom_values("no_auto_format") ) return;

      ?>
      <div class="chronique-block">
        <div class="row-fluid">
          <div class="span3 cover">
            <img src="<?php echo matilda_the_image(130,130, $post, true); ?>" alt="" />

            <?php if( get_post_custom_values("Note") ) {
              $note = get_post_custom_values("Note");
              echo '<img src="'.get_bloginfo('template_url').'/core/img/note/'.$note[0].'.png" alt="'.$note[0].'/10" class="note" />';
            } ?>

          </div>
          <div class="offset3">
            <?php

            if( get_post_custom_values("Album") && get_post_custom_values("Artiste") ) {

              $artist = get_post_custom_values("Artiste");
              $slug = slugify($artist[0]);
              $album = get_post_custom_values("Album");
              echo "<p class='album'>{$album[0]}</p>";
              echo "<p class='artist'>Par <a href='/tag/{$slug}'>{$artist[0]}</a></p>";

            }

            if( get_post_custom_values("Année") ) {

              $annee = get_post_custom_values("Année");
              echo "<p>";
                echo '<i class="icon icon-calendar"></i>';
                echo '<strong>Année </strong>: '.$annee[0];
              echo "</p>";

            }

            if( get_post_custom_values("Genre") ) {

              $genre = get_post_custom_values("Genre");

              echo "<p>";
                echo '<i class="icon icon-tags"></i>';
                echo '<strong>Genre </strong>: '.$genre[0];
              echo "</p>";

            }

            if(get_post_custom_values("chansons preferees")) {

              $chansons = get_post_custom_values("chansons preferees");

              echo "<p>";
                echo '<i class="icon icon-heart"></i>';
                echo _n('<strong>Chanson préférée</strong> : ', '<strong>Chansons préférées</strong> : ', count(explode(",", $chansons[0]) ) );
                echo $chansons[0];
              echo '</p>';
            }

            ?>
         </div>
        </div>
      </div>
      <?php
    }


    function nb_posts()  {

      global $Cache_Lite;

      if( $Cache_Lite && ! $count_posts = $Cache_Lite->get("count_posts") ) {
        $num_posts = wp_count_posts( 'post' );
        $count_posts = $num_posts->publish;
        $Cache_Lite->save( $count_posts, "count_posts");
        return number_format_i18n( $count_posts );
      }

      return 0;

    }

    function nb_tags()  {

      global $Cache_Lite;

      if( $Cache_Lite && ! $count_tags = $Cache_Lite->get("count_tags") ) {
        $count_tags = count( get_tags() );
        $Cache_Lite->save( $count_tags, "count_tags");
        return number_format_i18n( $count_tags );
      }

      return 0;

    }

    function nb_comments()  {

      global $wpdb, $Cache_Lite;

      if( $Cache_Lite && ! $count_comments = $Cache_Lite->get("count_comments") ) {

        $count_comments = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '1'");
        $Cache_Lite->save($count_comments, "count_comments");
        return number_format_i18n( $count_comments );

      }

      return 0;

    }

     /**
      * Modifies a string to remove al non ASCII characters and spaces.
      * @src http://snipplr.com/view/22741/
      */
    function slugify($text) {
      // replace non letter or digits by -
      $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

      // trim
      $text = trim($text, '-');

      // transliterate
      if (function_exists('iconv')) {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
      }

      // lowercase
      $text = strtolower($text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      return $text;
    }

?>