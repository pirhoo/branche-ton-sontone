(function($, window) {

	$(document).ready(function() {
	    addTitle();
	});

	function addTitle() {
	    $(".addTitle").each( function (index) {
	        var title = $(this).attr("title");
	        $(this).attr("title", "");
	        $(document.body).append('<span class="hiddenTitle">' + title + '</span>');
	        showTitle(index);
	    });

	}

	function addAvisDesAutres() {
	    var avis = $("#input-avis-author").val()+"="+$("#input-avis-note").val();
	    
	    if($('*:input[name=bts-avis-des-autres]').val() == "")
	        $('*:input[name=bts-avis-des-autres]').val(avis);
	    else
	        $('*:input[name=bts-avis-des-autres]').val( $('*:input[name=bts-avis-des-autres]').val() + "," + avis);

	    writeAvisDesAutres();
	}

	function writeAvisDesAutres() {
	     $('#liste-avis').html("");
	     
	    var avis = $('*:input[name=bts-avis-des-autres]').val();
	    if(avis != "") {
	        avis = avis.split(",");

	        for (var i in avis) {

	            avis[i] = avis[i].split("=");

	            var html  = '<div class="un-avis bts-input" onclick="removeAvisDesAutres('+i+')">';
	                html += '<a class="del-button">X</a>';
	                html += '<span class="auteur-avis">'+avis[i][0]+'</span>';
	                html += '<span class="note-avis">'+avis[i][1]+'</span></div>';

	            $('#liste-avis').append(html);
	        }
	    }

	}

	function removeAvisDesAutres(index) {
	    var avis = $('*:input[name=bts-avis-des-autres]').val();
	    avis = avis.split(",");
	    
	    $('*:input[name=bts-avis-des-autres]').val("");
	    for(i in avis) {
	        if(i != index) {
	             if($('*:input[name=bts-avis-des-autres]').val() == "")
	                $('*:input[name=bts-avis-des-autres]').val(avis[i]);
	            else
	                $('*:input[name=bts-avis-des-autres]').val( $('*:input[name=bts-avis-des-autres]').val() + "," + avis[i]);

	        }
	    }
	    writeAvisDesAutres()
	}


	function autoComplete(isChronique) {
    var artiste = $('#bts-artiste').val();
    var album   = $('#bts-album').val();
    var genre   = $('#bts-genre').val();
    var pays    = $('#bts-pays').val();
    var annee   = $('#bts-annee').val();
    var note    = $('#bts-note').val();

    // ajuste le titre pour les chroniques
    if(isChronique)
        if(artiste != "" && album != "")
            $("#title").val("Chronique de "+artiste+" - "+album);
     
    // ajoute les tags
    var tags = "";
    if(album != "")
        tags = album;

    if(artiste != "" && tags != "")
        tags += ", " + artiste;
    else
        tags = artiste;
    
    if(pays != "" && tags != "")
        tags +=  ", " + pays;
    else
        tags = pays;

    if(annee != "" && tags != "")
        tags += ", " + annee ;
    else
        tags = annee ;
    
    if(genre != "" && tags != "")
        tags += ", " + genre ;
    else
        tags = genre ;

    if(note != -1 && tags != "")
        tags += ", " + note + "/10";
    else if( note != -1 )
        tags = note + "/10";
    

    $("#new-tag-post_tag").val(tags);
    $("#new-tag-post_tag").submit();

    // complète les champs SEO
    $("*:input[name=aiosp_title]").val( $("#title").val() );
    $("*:input[name=aiosp_description]").val( $("#excerpt").val() );
    $("*:input[name=aiosp_keywords]").val(tags);

}

function showTitle(index) {
    var that  = $(".addTitle:eq("+index+")");
    
    $(that).mouseenter(function () {
        var title = $(".hiddenTitle:eq("+index+")")

        // positione
        var thatTop  = $(that).offset().top + $(that).outerHeight() + 5;
        var thatLeft = $(that).offset().left;
        $(title).css({top: thatTop, left: thatLeft});

        // affiche
        $(title ).fadeIn();
    });

    $(that).mouseleave(function () {
        var title = $(".hiddenTitle:eq("+index+")")
        $(title).fadeOut();
    })
	}

})(jQuery, window);