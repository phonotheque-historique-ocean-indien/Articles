
$is_redactor = $this->getVar("is_redactor");
$access = $this->getVar("access");
$article = $this->getVar("article");
$page = $this->getVar("page");
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

$template_id=$page->get('template_id');
switch($template_id) {
    case "2":
        $template = "exposition";
        break;
    case "3":
        $template = "playlist";
        break;
    case "4":
        $template = "podcast";
        break;
    default :
        $template = "article";
        break;
}
$old_path = ucfirst($template)."s";
?>
<div class="<?= $template ?>-phoi">
    <nav class="breadcrumb has-succeeds-separator" aria-label="breadcrumbs">
        <div class="container">
            <ul class="ariane">
                <li><a href="/"><?php _p("Accueil"); ?></a></li>
                <li><a href="/index.php/<?php _p($old_path); ?>/Show/index"><?php _p($old_path); ?></a></li>
                <li class="is-active"><a href="#" aria-current="page"><?php _p($article["title"] . " " . $article["subtitle"]); ?></a>
                </li>
            </ul>
        </div>
    </nav>
    <?php if($is_redactor): ?>
    <section class="section" id="buttons" style="padding-top: 0;padding-bottom: 0;">
        <div class="container">
            <a href="/index.php/Articles/Editor/New/template_id/<?= $template_id ?>">
                <button class="button action-btn add-new is-uppercase has-text-centered">
                    <span class="icon"><i class="mdi mdi-plus"></i></span>&nbsp; <?php _p("Nouveau"); ?>
                </button>
            </a>
            <a href="/index.php/Articles/Editor/Properties/id/<?= $id ?>">
                <button class="button action-btn add-new is-uppercase has-text-centered">
                    <span class="icon"><i class="mdi mdi-playlist-edit"></i></span>&nbsp; <?php _p("Propriétés"); ?>
                </button>
            </a>
            <a href="/index.php/Articles/Editor/Article/id/<?= $id ?>" class="active">
                <button class="button action-btn add-new is-uppercase has-text-centered">
                    <span class="icon"><i class="mdi mdi-lead-pencil"></i></span>&nbsp; <?php _p("Éditeur"); ?>
                </button>
            </a>
            <a href="/index.php/Articles/Display/Details/id/<?= $id ?>" class="active">
                <button class="button action-btn add-new is-uppercase has-text-centered">
                    <span class="icon"><i class="mdi mdi-eye"></i></span>&nbsp; <?php _p("Afficher"); ?>
                </button>
            </a>
            <button class="button action-btn add-new is-uppercase has-text-centered is-dark" onClick="$('#delete').show();">
                <span class="icon"><i class="mdi mdi-delete"></i></span>&nbsp; <?php _p("Supprimer"); ?>
            </button>

            <div class="modal" id="delete">
                <div class="modal-background"></div>
                <div class="modal-card" style="margin-top:300px;">
                    <header class="modal-card-head">
                    <p class="modal-card-title">Suppression</p>
                    <button class="delete" aria-label="close"></button>
                    </header>
                    <section class="modal-card-body">
                    <p>Êtes vous sur de vouloir supprimer ce contenu ?</p>
                    </section>
                    <footer class="modal-card-foot">
                        <a href="/index.php/Articles/Show/Delete/id/<?= $id ?>"><button class="button is-danger">Supprimer</button></a>
                        <button class="button" onClick="$('#delete').hide();">Annuler</button>
                    </footer>
                </div>
            </div>

            <?php if(!$access): ?>
                <a href="/index.php/Articles/Display/Publish/id/<?= $id ?>">
                    <button class="button action-btn add-new is-uppercase has-text-centered">
                        <span class="icon"><i class="mdi mdi-publish"></i></span>&nbsp; <?php _p("Publier"); ?>
                    </button>
                </a>
                <span class="tag is-warning" style="margin-top:10px;margin-left:12px;">BROUILLON</span> 
            <?php else : ?>
                <a href="/index.php/Articles/Display/Unpublish/id/<?= $id ?>">
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

            <div class="article-header level">
                <div class="level-left">
                    <h1 class="title"><?php 
                        _p($article["title"]); 
                        MetaTagManager::setWindowTitle($article["title"]);
                    ?></h1>
                    <h1 class="subtitle"><?php _p($article["subtitle"]); ?></h1>
                </div>
                <div class="level-right">
                    <p class="published-by"><?php _p("publié par"); ?></p>
                    <p class="publisher"><?php _p($article["author"]); ?></p>
                    <p class="date"><?php _p($article["date"]); ?></p>
                </div>
            </div>
            <div>
                <img src="<?php 
                    _p($article["image"]); 
                    MetaTagManager::addMetaProperty("og:image", $article["image"]);
                ?>" alt="image 1" style="width:100%;height:auto;">
            </div>
            <?php
            $blocs = json_decode($article["blocs"], true);
            $blocs = $blocs["blocks"];
            foreach ($blocs as $bloc):
                $bloc["content"] = str_replace("\\n", "", $bloc["content"]);
                // convert markdown links to html links
                $bloc["content"] = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="\2">\1</a>', $bloc["content"]);

                $bloc["image"] = str_replace("https://phoi.ideesculture.fr/", "/", $bloc["image"]);
                $bloc["image1"] = str_replace("https://phoi.ideesculture.fr/", "/", $bloc["image1"]);
                $bloc["image2"] = str_replace("https://phoi.ideesculture.fr/", "/", $bloc["image2"]);

                switch ($bloc["type"]):
                    case "quote":
                    ?>

                        <article class="article-content">
                            <div class="lead-dropcap"><p><strong><?php _p($bloc["data"]["text"]); ?></strong></p></div>
                        </article>

                        <?php break;
                    case "list":
                        if($bloc["data"]["style"]=="unordered") {
                            print "<article class=\"article-content\"><ul>\n";
                        } else {
                            print "<article class=\"article-content\"><ol>\n";
                        }
                        foreach($bloc["data"]["items"] as $item) {
                            print "<li>".$item."</li>";
                        }
                        if($bloc["data"]["style"]=="unordered") {
                            print "</ul></article>\n";
                        } else {
                            print "</ol></article>\n";
                        }
                        break;
                    case "paragraph":
                    case "header":
                    ?>

                        <article class="article-content">
                            <p><?php _p($bloc["data"]["text"]); ?></p>
                        </article>

                        <?php break;
                    case "quote": ?>

                        <article class="article-content">
                            <div class="quote"><?php _p($bloc["content"]); ?></div>
                        </article>


                        <?php break;
                    case "large-image":
                        ?>

                        <figure class="large-image">
                            <img src="<?php print $bloc["image"]; ?>" alt="Image 2 fullwidth">
                            <figcaption><?php print $bloc["figcaption"]; ?></figcaption>
                        </figure>

                        <?php break;   
                    case "simpleimage":
                        // var_dump($bloc);
                        // die();
                        $styles=$bloc["data"];
                        unset($styles["url"]);
                        unset($styles["content"]);
                        $classes = "";
                        foreach($styles as $style=>$bool) {
                            if($bool) $classes .= $style." ";
                        }
                    ?>
                        <figure class="simple-image <?= $classes ?>">
                            <img src="<?php print $bloc["data"]["url"]; ?>" alt="<?php print $bloc["data"]["caption"]; ?>">
                            <figcaption><?php print $bloc["caption"]; ?></figcaption>
                        </figure>
                    <?php
                        break;
                    case "image-is-fullsize":
                        ?>

                        <figure class="image-full">
                            <img src="<?php print $bloc["image"]; ?>" alt="Image 2 fullwidth">
                            <figcaption><?php print $bloc["figcaption"]; ?></figcaption>
                        </figure>

                        <?php break;
                    case "delimiter":
                        ?>
                        <div class="delimiter"></div>
                        <?php
                        break;
                    case "image-with-text":
                        ?>

                        <article class="article-content">
                            <div class="columns image-with-text">
                                <div class="column">
                                    <img src="<?php print $bloc["image"]; ?>" alt="image 5">
                                </div>
                                <div class="column">
                                <?php print str_replace("&quo;", '"', $bloc["content"]); ?>
                                </div>
                            </div>
                        </article>

                        <?php break;
                    case "references":
                        print "<div class=\"article-content footnotes\">";
                        if ($bloc["footnote1"]) print "<h4>Références</h4><ol>";
                        if ($bloc["footnote1"]) print "<li id=\"footnote1\">{$bloc["footnote1"]}</li>";
                        if ($bloc["footnote2"]) print "<li id=\"footnote1\">{$bloc["footnote2"]}</li>";
                        if ($bloc["footnote3"]) print "<li id=\"footnote1\">{$bloc["footnote3"]}</li>";
                        if ($bloc["footnote4"]) print "<li id=\"footnote1\">{$bloc["footnote4"]}</li>";
                        if ($bloc["footnote5"]) print "<li id=\"footnote1\">{$bloc["footnote5"]}</li>";
                        if ($bloc["footnote6"]) print "<li id=\"footnote1\">{$bloc["footnote6"]}</li>";
						if ($bloc["footnote1"]) print "</ol>";
                        print "<h4>Pour en savoir plus</h4>";
                        print $bloc["content"];
                        print "</div>";
                        break;
                    case "simplevideo":
                        ?>
                        <div style="max-width:700px;margin:0 auto;">
                            <video controls style="width:100%;">
                                <source src="<?= $bloc["data"]["url"] ?>" type="video/mp4">
                            </video>
                        </div>
                        <?php
                        break;
                    case "simpleaudio":
                        //var_dump($bloc);
                        //die();
                        ?>
                        <article class="article-content">
                            <div class="simpleaudio-content">
                                <img src="/img_article_phoi.png" style="height:40px" align="absmiddle">
                                <span class="player-icons">
                                    <span class="icon">
                                        <i class="mdi mdi-play is-large" onclick="playlistLoadTrack('<?= $bloc['data']['caption'] ?>', '<?= $bloc['data']['url'] ?>', '/img_article_phoi.png', '', '<?= $article['title'] ?>');"></i>
                                    </span>
                                    <span class="icon">
                                        <i class="mdi mdi-stop is-large" onclick="parent.stopTrack();"></i>
                                    </span>
                                </span> <?= $bloc['data']['caption'] ?>        
                            </div>      
                        </article>
                        <?php                        
                        break;
                    default:
                        var_dump($bloc);die();

                        print "<div style='border:1px solid black; padding:50px;margin:20px 0;>Type JSON inconnu : {$bloc["type"]}</div>";

                        break;
                endswitch;
            endforeach; ?>

        </div>
    </section>

    <section class="section" id="related-playlist">
        <h1><?php _p("Playlists associées"); ?></h1>
    </section>
    <?php endif; ?>
</div>
</div>
<iframe id="audio-player" style="width:100%;height:690px;overflow: hidden;" src="/index.php/AudioPlayer/V/Embed">
</iframe>
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

    .article-content li {
        padding-bottom:12px;
    }
    .simple-image.floatRight, .simple-image.floatLeft {
        margin-top:0 !important;
    }
    .floatLeft {

    }
    .simple-image {
        padding: 20px 0;
        text-align: center;
    }
    .floatLeft {
        float: left;
        max-width: 325px;
        margin-right: 20px;
        margin-left: 20%;
        z-index: 1;
        padding-top:0;
    }
    .delimiter {
        clear:both;
    }
</style>
<div>

