<?php
/*
 * TODO :
 * - embed editorjs.io
 * - enable editorjs on blocks (json content)
 */

$is_redactor = $this->getVar("is_redactor");
$access = $this->getVar("access");
$article = $this->getVar("article");
$id = $this->getVar("id");
$article["image"] = str_replace("https://phoi.ideesculture.fr/", "/", $article["image"]);

// Check if article is programmed in the past
$is_past = false;
if($article["date_to"]) {
    $date_to = substr($article["date_to"], 6, 4)."-".substr($article["date_to"], 3, 2)."-".substr($article["date_to"], 0, 2);
    // Ignore if the article is to be published in the future
    if(time() > strtotime($date_to)) $is_past = true;
}
// Check if article is programmed in the past
$is_future = false;
if($article["date_from"]) {
    $date_from = substr($article["date_from"], 6, 4)."-".substr($article["date_from"], 3, 2)."-".substr($article["date_from"], 0, 2);
    // Ignore if the article is to be published in the future
    if(time() < strtotime($date_from)) $is_future = true;
}

?>

<script src="<?= __CA_URL_ROOT__ ?>/app/plugins/Articles/lib/editor.js"></script>
<script>
    var editor = [];
    jQuery(document).ready(function() {
        editor = new EditorJS({
            /**
             * Id of Element that should contain the Editor
             */
            holder: 'editorjs',

            /**
             * Available Tools list.
             * Pass Tool's class or Settings object for each Tool you want to use
             */
            tools: {
                header: {
                    inlineToolbar: ['link']
                },
                list: {
                    inlineToolbar: true
                }
            },
        });
    });
</script>

<div class="article-phoi">
    <?php if($is_redactor): ?>
    <section class="section" id="buttons" style="padding-top: 0;padding-bottom: 0;">
        <div class="container">


            <?php if(!$access): ?>
                <a href="/index.php/Articles/Show/Publish/id/<?= $id ?>">
                    <button class="button action-btn add-new is-uppercase has-text-centered">
                        <span class="icon"><i class="mdi mdi-publish"></i></span>&nbsp; <?php _p("Publier"); ?>
                    </button>
                </a>
                <span class="tag is-warning" style="margin-top:10px;margin-left:12px;">BROUILLON</span> 
            <?php else : ?>
                <a href="/index.php/Articles/Show/Unpublish/id/<?= $id ?>">
                <button class="button action-btn add-new is-uppercase has-text-centered">
                    <span class="icon"><i class="mdi mdi-lead-pencil"></i></span>&nbsp; <?php _p("Dépublier"); ?>
                </button>
                </a>            
            <?php endif; ?>
            
            <?php if(($article["date_from"]) && ($is_redactor)){ ?><span class="tag <?php 
                    if($is_future) {
                        print "is-warning";
                    }
                    if(($is_past)) {
                        print "is-danger";
                    }
                    if((!$is_past) && (!$is_future)) {
                        print "is-success";
                    }
                    
                     ?>" style="margin-top:4px;margin-left:0px;">PROGRAMMÉ <?= $article["date_from"]." - ".$article["date_to"]; ?></span><br/>
            <?php } ?> 
            
        </div>
    </section>
    <?php elseif(!$access): ?>
        <section class="section" id="article">
            <div class="container">
                <p>Cet article n'est pas encore publié et ne peut être affiché que par les rédacteurs du site.</p>
                </div>
            </section>
    <?php endif; ?>
    <?php if($is_redactor || $access): ?>
    <section class="section" id="article">
        <div class="container">

            <?php
            $blocs = json_decode($article["blocs"], true);
?>
            <pre>
                <?= $article["blocs"]; ?>
            </pre>

        </div>
    </section>

    <?php endif; ?>
</div>
<div id="editorjs">ici</div>

</div>
<style>
    #audio-player,
    #audio-player html,
    #audio-player body {
        overflow: hidden;
        scroll-behavior: unset;
    }
    .article-content{
	    margin-bottom: 15px;
    }
    ul{
	    list-style: circle;
    }
</style>
<div>

