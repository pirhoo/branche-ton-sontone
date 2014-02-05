<?php

add_action('admin_menu', 'add_bts_boxes');
add_action('save_post', 'bts_save_postdata');

function add_bts_boxes() {
    add_meta_box( 'bts-image-box', 'Branche ton Sonotone - mise en page', 'inner_bts_image_box', 'post', 'normal', 'high');
    add_meta_box( 'bts-metainfo-box', 'Branche ton Sonotone - informations', 'inner_bts_metainfo_box', 'post', 'normal', 'high');
    add_meta_box( 'bts-avis-des-autres-box', 'Branche ton Sonotone - L\'avis des autres', 'inner_bts_avis_des_autres_box', 'post', 'normal', 'high');
}

function inner_bts_image_box() {
  global $post;
  setup_postdata($post);

  $no_auto_format=0;
  if (get_post_meta($post->ID, 'article_layout', true) )
		$article_layout = get_post_meta($post->ID, 'article_layout', true);
  else if (get_post_meta($post->ID, 'no_auto_format', true) )
  	$article_layout = "disabled";
  else
  	$article_layout = "auto";

  if (get_post_meta($post->ID, 'Image', true) )
    $image=get_post_meta($post->ID, "Image", true);


  if (get_post_meta($post->ID, 'Image_large', true) )
    $image_large=get_post_meta($post->ID, 'Image_large', true);

  ?>
  <style type="text/css">
      @import url('<? bloginfo('template_url'); ?>/core/lib/adminMetaBoxes.css');
  </style>

	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/core/lib/adminMetaBoxes.js"></script>

        <div class="bts-box">

            <div class="appercu-image" style="background-image:url('<?=matilda_the_image(60, 60)?>')">

            </div>


            <div class="full-width" style="padding-top:15px">
                <label>
                    <abbr class="addTitle" title="À cocher si tu ne veux pas que l'article soit mis en page automatiquement.">?</abbr>
                    <strong>Disposition</strong> de l'article :
                    <select name="bts-article-layout">
                    	<option <?= ($article_layout == "auto") ? "selected" : "" ?> value="auto">Automatique</option>
                    	<option <?= ($article_layout == "2-col") ? "selected" : "" ?> value="2-col">2 colonnes</option>
                    	<option <?= ($article_layout == "3-col") ? "selected" : "" ?> value="3-col">3 colonnes</option>
                    	<option <?= ($article_layout == "disabled") ? "selected" : "" ?> value="disabled">Aucune</option>
                    </select>
                </label>
            </div>

            <br style="clear:both;"/>

        </div>
    <?php
}



function inner_bts_metainfo_box() {
    global $post;


    if (get_post_meta($post->ID, 'Artiste', true) )
      $artiste=get_post_meta($post->ID, "Artiste", true);

    if (get_post_meta($post->ID, 'Album', true) )
      $album=get_post_meta($post->ID, "Album", true);

    if (get_post_meta($post->ID, 'Année', true) )
      $annee=get_post_meta($post->ID, "Année", true);

    if (get_post_meta($post->ID, 'Genre', true) )
      $genre=get_post_meta($post->ID, "Genre", true);

    if (get_post_meta($post->ID, 'Pays', true) )
      $pays=get_post_meta($post->ID, "Pays", true);

    $note=-1;
    if (get_post_meta($post->ID, 'Note', true) )
      $note=get_post_meta($post->ID, "Note", true);

    if (get_post_meta($post->ID, 'chansons preferees', true) )
      $chansons_preferees=get_post_meta($post->ID, "chansons preferees", true);


    ?>
    <input type="hidden" name="bts-admin-box" value="" />
    <div class="bts-box">
            <div class="half-width">
            <label>
                <abbr class="addTitle" title="Le ou les artistes auteurs de l'album.">?</abbr>
                Artiste :
                <input type="text" value="<?=$artiste?>" name="bts-artiste" id="bts-artiste" />
            </label>
            </div>
            <label>
                <abbr class="addTitle" title="Le titre de l'album.">?</abbr>
                Album :
                <input type="text" value="<?=$album?>" name="bts-album" id="bts-album" />
            </label>

            <div class="half-width">
                <label>
                    <abbr class="addTitle" title="L'année de sortie de l'album.">?</abbr>
                    Année :
                    <input type="text" value="<?=$annee?>" name="bts-annee" style="width:70px" id="bts-annee" />
                </label>
                <label>
                    <abbr class="addTitle" title="La note que tu donne à l'album.">?</abbr>
                    Note :&nbsp;&nbsp;
                    <select name="bts-note" id="bts-note">

                      <option value="-1" <? if($note == -1) echo "selected='selected'";?> >
                        --
                      </option>

                        <? for($i = 0; $i <= 10; $i ++) : ?>
                          <option value="<?=$i?>" <? if($i == $note) echo "selected='selected'";?> >
                            <?=$i?>
                          </option>
                        <? endfor; ?>
                    </select>
                </label>
            </div>
            <label>
                <abbr class="addTitle" title="Le ou les genres de l'album.">?</abbr>
                Genre :
                <input type="text" value="<?=$genre?>" name="bts-genre" id="bts-genre" />
            </label>

            <div class="half-width">
                <label>
                    <abbr class="addTitle" title="Le pays dont provient l'artiste.">?</abbr>
                    Pays :&nbsp;&nbsp;
                    <input type="text" name="bts-pays" value="<?=$pays?>" id="bts-pays" />
                </label>
            </div>
            <label>
                <abbr class="addTitle" title="Tes chansons préférées dans cet album.">?</abbr>
                Chansons préférées :&nbsp;&nbsp;
                <input type="text" name="bts-chansons-preferees" value="<?=$chansons_preferees?>" />
            </label>


            <br style="clear:both">
            <a href="javascript:autoComplete(<?= (in_category('chroniques') ) ?  1 : 0?>)" class="magicButton addTitle" title="La magie nous permet, à l'aide de ces informations, d'ajuster le titre des chroniques, ajouter les tags et remplir le pack S.E.O (pour le référencement).">Magique! Auto-complète le reste de l'article...</a>

            <br style="clear:both">
        </div>

     <?
}

function inner_bts_avis_des_autres_box() {
    global $post, $user_identity;


    if (get_post_meta($post->ID, 'avis des autres', true) )
            $avis_des_autres=get_post_meta($post->ID, "avis des autres", true);

    ?>
    <div class="bts-box">
        <input type="hidden" name="bts-avis-des-autres" value="<?=$avis_des_autres; ?>" />

        <div class="avis-des-autres">
            <div class="input-avis">
                L'avis des autres :

                <select id="input-avis-author">
                <?
                    $authors = wp_list_authors("echo=0&html=0");
                    $authors = explode(", ", $authors);
                    foreach ($authors as $author) {
                        ?>
                    <option value="<?=$author?>" <? if( $user_identity == $author) echo 'selected="selected"'?> ><?=$author?></option>
                        <?
                    }

                ?>
                </select>
                note
                <select id="input-avis-note">
                <?
                    for ($i = 0; $i <= 10; $i++) {
                        ?>
                    <option value="<?=$i?>"><?=$i?></option>
                        <?
                    }
                ?>
                 </select>
                <input type="button" class="button" value="Ajouter" onclick="addAvisDesAutres()" />
                <abbr class="addTitle help" title="Utilse ce formulaire pour noter toi aussi un album, lors d'une chronique.">?</abbr>
            </div>


            <div id="liste-avis"></div>

            <br style="clear:both">
        </div>
        <script type="text/javascript">
            if (window.addEventListener)
                window.addEventListener('load', function () { writeAvisDesAutres(); }, false );
            else if (window.attachEvent)
                window.attachEvent('onload', function () { writeAvisDesAutres(); } );
        </script>
    </div>
    <?
}

function bts_save_postdata($post_id) {

  global $post;

   // pour ne rien faire si on a pas bien reçu les données
   if(isset($_POST['bts-admin-box'])) {

        // pour ne rien faire si c'est une sauvegarde automatique
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
            return -1;

        // L'utilisateur a t'il le droit de modifier ce post ?
        if ( 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ) )
                return -1;
        } else {
            if ( !current_user_can( 'edit_post', $post_id ) )
                return -1;
        }


        // mise en page ou non
       if($_POST['bts-no-auto-format'])
            update_post_meta($post_id, 'no_auto_format', 1);
       else
            delete_post_meta($post_id, 'no_auto_format');

      // mise en page ou non
       if($_POST['bts-article-layout'])
            update_post_meta($post_id, 'article_layout', $_POST['bts-article-layout']);
       else
            delete_post_meta($post_id, 'article_layout');

       // image alternative de la page d'accueil
       if( $_POST['bts-image_large'] != "" )
            update_post_meta($post_id, 'Image_large', $_POST['bts-image_large']);
       else
            delete_post_meta($post_id, 'Image_large');

       if( $_POST['bts-artiste'] != "" )
         update_post_meta($post_id, 'Artiste', $_POST['bts-artiste']);
       else
          delete_post_meta($post_id, 'Artiste');

       if( $_POST['bts-album'] != "" )
         update_post_meta($post_id, 'Album', $_POST['bts-album']);
       else
          delete_post_meta($post_id, 'Album');

       if( $_POST['bts-pays'] != "" )
         update_post_meta($post_id, 'Pays', $_POST['bts-pays']);
       else
          delete_post_meta($post_id, 'Pays');

       if( $_POST['bts-annee'] != "" )
         update_post_meta($post_id, 'Année', $_POST['bts-annee']);
       else
          delete_post_meta($post_id, 'Année');

       if( $_POST['bts-genre'] != "" )
         update_post_meta($post_id, 'Genre', $_POST['bts-genre']);
       else
          delete_post_meta($post_id, 'Genre');

       if( $_POST['bts-note'] != "-1" )
         update_post_meta($post_id, 'Note', $_POST['bts-note']);
       else
          delete_post_meta($post_id, 'note');

       if( $_POST['bts-chansons-preferees'] != "" )
         update_post_meta($post_id, 'chansons preferees', $_POST['bts-chansons-preferees']);
       else
          delete_post_meta($post_id, 'chansons preferees');

       // notes des autres auteurs
       if($_POST['bts-avis-des-autres'] != "")
            update_post_meta($post_id, 'avis des autres', $_POST['bts-avis-des-autres']);
       else
            delete_post_meta($post_id, 'avis des autres');
   }

    return $post_id;
}

?>