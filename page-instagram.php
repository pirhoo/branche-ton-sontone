<?php
/**
 * Template Name: instagram
 * @package WordPress
 * @subpackage Matilda
 */ ?>

<?php get_header(); ?>


    <div id="content" role="main" >
        <div class="container instagram bottom-20">
            <h2 class="top-20 bottom-10">Les chroniques en 1 shoot</h2>
            <div class="row">
                <div class="span0 hidden"></div>
                <?php
                    function fetchData($url){
                         $ch = curl_init();
                         curl_setopt($ch, CURLOPT_URL, $url);
                         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                         curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                         $result = curl_exec($ch);
                         curl_close($ch);
                         return $result;
                    }

                    function getUserMedia() {
                         $access_token = "";
                         $user_id = "";
                         $result = fetchData("https://api.instagram.com/v1/users/{$user_id}/media/recent/?access_token={$access_token}");
                         return json_decode($result, true);
                    }

                    $result =  getUserMedia();
                    $spans = array('span6', 'span4', 'span3');
                    foreach($result["data"] as $key => $post):
                         if($key < 2) $span = 0;
                         elseif($key < 8) $span = 1;
                         else $span = 2; ?>
                         <a class="<?=$spans[$span]?> pic top-05" href="<?= $post["link"] ?>" target="_blank">
                                <img src="<?= $post['images']['low_resolution']['url'] ?>" class="thumbnail" />
                                <?php if( ! empty($post["caption"]["text"]) ) : ?>
                                    <div class="caption">
                                        <?= $post["caption"]["text"] ?>
                                    </div>
                                <?php endif; ?>
                         </a>
                    <?php endforeach;
                ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
