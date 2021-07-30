<?php
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

// Test if $article["blocs"] is in older format or ok
$blocs = json_decode($article["blocs"], 1);
$is_older_format = ($blocs["time"] === null);

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
<div class="<?= $template ?>-phoi" style="margin-bottom:120px;">
    <nav class="breadcrumb has-succeeds-separator" aria-label="breadcrumbs">
        <div class="container">
            <ul class="ariane">
                <li><a href="/"><?php _p("Accueil"); ?></a></li>
                <li><a href="/index.php/Articles/Show/index"><?php _p($old_path); ?></a></li>
                <li class="is-active"><a href="#" aria-current="page"><?php _p($article["title"] . " " . $article["subtitle"]); ?></a>
                </li>
            </ul>
        </div>
    </nav>
<?php if($is_redactor): ?>
    <section class="section" id="buttons" style="padding-top: 0;padding-bottom: 0;">
        <div class="container">
            <a href="/index.php/Contribuer/Pages/New/template_id/1">
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
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Suppression</p>
                        <button class="delete" aria-label="close"></button>
                    </header>
                    <section class="modal-card-body">
                        <p>Êtes vous sur de vouloir supprimer ce contenu ?</p>
                    </section>
                    <footer class="modal-card-foot">
                        <a href="/index.php/Articles/Show/Delete/id/<?= $id ?>"><button class="button is-danger">Supprimer</button>
                            <button class="button" onClick="$('#delete').hide();">Annuler</button>
                    </footer>
                </div>
            </div>

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
<?php else: ?>
    <section class="section" id="article">
        <div class="container">
            <h2>Editeur d'article</h2>
            <p>Vous devez être connecté en tant que rédacteur pour pouvoir modifier cet article.</p>
        </div>
    </section>
<?php endif; ?>
<?php if($is_redactor): ?>
    <section class="section" id="article">

    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/paragraph@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
    <!-- <script src="<?= __CA_URL_ROOT__ ?>/app/plugins/Articles/lib/editorjs-simpleimage-left-right/simpleimage-left-right.js"></script> -->
    <script src="<?= __CA_URL_ROOT__ ?>/app/plugins/Articles/lib/ideesculture-editorjs-image/simple-image.js"></script>
    <script src="<?= __CA_URL_ROOT__ ?>/app/plugins/Articles/lib/editorjs-audio/simple-audio.js"></script>
        <script src="<?= __CA_URL_ROOT__ ?>/app/plugins/Articles/lib/editorjs-video/simple-video.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>


    <link rel="stylesheet" href="https://dev.phoi.io/themes/phoi/assets/pawtucket/css/theme.css">
    <!-- <link rel="stylesheet" href="<?= __CA_URL_ROOT__ ?>/app/plugins/Articles/lib/editorjs-simpleimage-left-right/simpleimage-left-right.css"> -->
    <link rel="stylesheet" href="<?= __CA_URL_ROOT__ ?>/app/plugins/Articles/lib/ideesculture-editorjs-image/simple-image.css">
    <link rel="stylesheet" href="<?= __CA_URL_ROOT__ ?>/app/plugins/Articles/lib/editorjs-audio/simple-audio.css">
        <link rel="stylesheet" href="<?= __CA_URL_ROOT__ ?>/app/plugins/Articles/lib/editorjs-video/simple-video.css">
    <!-- <link rel="stylesheet" href="style.css"> -->

    <div class="container">
        <div class="article-phoi">
            <div class="article-header level">
                <div class="level-left">
                    <h1 class="title"><?= $article["title"] ?></h1>
                    <h1 class="subtitle"><?= $article["subtitle"] ?></h1>
                </div>
                <div class="level-right">
                    <p class="published-by">publié par</p>
                    <p class="publisher"><?= $article["author"] ?></p>
                    <p class="date"><?= $article["date"] ?></p>
                </div>
            </div>
            <div>
                <img src="<?= $article["image"] ?>" alt="image 1" style="width:100%;height:auto;">
            </div>

            <?php if($is_older_format): ?>
                <div style="margin:70px;font-weight: bold;font-size:1.6em;">Ces blocs sont dans un précédent format. Vous ne pouvez pas éditer cet article.<br/>Merci de vous rapprocher de l'administrateur de la base.</div>
            <?php else: ?>
                <iframe src="/upload/manual.php" style="width:100%;height:46px;"></iframe>
                <div id="editorjs"></div>
            <?php endif; ?>
        </div>
    </div>
    <?php if(!$is_older_format): ?>
        <div class="container">
            <div class="ce-block__content">
                <button class="button is-primary" onclick="articleSave()">Enregistrer</button>
                <button class="button" onclick="display()">Afficher</button>
            </div>

        </div>
    <?php endif; ?>
<?php endif; ?>
</div>
    </div>

    <iframe id="audio-player" style="width:100%;height:690px;overflow: hidden;" src="/index.php/AudioPlayer/V/Embed">
    </iframe>
</section>
</div>

    <script>

        const editor = new EditorJS({
                holder: 'editorjs',

                /**
                 * Available Tools list.
                 * Pass Tool's class or Settings object for each Tool you want to use
                 */
                tools: {
                    header: Header,
                    delimiter: Delimiter,
                    paragraph: {
                        class: Paragraph,
                        inlineToolbar: true
                    },
                    list:{
                      class: List,
                      inlineToolbar: true
                    },
                    embed: Embed,
                    simpleimage: {
                        class:IdeescultureEditorjsImage,
                        inlineToolbar: true
                    },
                    simpleaudio: {
                        class:SimpleAudio,
                        inlineToolbar: true
                    },
                    simplevideo: {
                        class:SimpleVideo,
                        inlineToolbar: true
                    },
                    //imageparagraph: SimpleImageLeftRight,
                    quote: {
                        class: Quote,
                        inlineToolbar: true,
                        config: {
                            quotePlaceholder: 'Enter a quote',
                            captionPlaceholder: 'Quote\'s author',
                        },
                    }
                },
                data:
                    <?= $article["blocs"] ?>,
                onReady: () => {
                    console.log('Editor.js is ready to work!');
                    console.log("Initial data :", <?= $article["blocs"] ?>);
                    // GM : Next lines are a DEBUG for stretched CSS class added on the wrapper.
                    $(".stretched").parent().parent().addClass("ce-block--stretched");
                    $(".simple-image").not(".stretched").parent().parent().removeClass("ce-block--stretched");
                    $(".ce-paragraph").not(".stretched").parent().parent().removeClass("ce-block--stretched");
                    // GM : required for float left & right image options
                    $(".simple-image").parent().removeClass("floatRight");
                    $(".simple-image").parent().removeClass("floatLeft");
                    $('.simple-image.floatLeft').parent().addClass('floatLeft');
                    $('.simple-image.floatRight').parent().addClass('floatRight');
                }
            }
        );
        function articleSave(){
            editor.save().then((output) => {
                console.log('Data: ', output);
                //console.log(JSON.stringify(output));
                $.ajax({
                    method: "POST",
                    url: "<?php print __CA_URL_ROOT__; ?>/index.php/Articles/Editor/SaveArticleJson/id/<?= $id ?>",
                    data: output,
                    dataType: "json"
                })
                .done(function( result ) {
                        console.log("result");
                        console.log(output.blocks[4]);
                        //console.log(output);
                        if(result.result == "ok") {
                            //alert("Article enregistré");
                        }
                });
            }).catch((error) => {
                console.log('Saving failed: ', error)
            });
        }
        function display() {
            window.location="<?= __CA_URL_ROOT__?>/index.php/Articles/Display/Details/id/<?= $id ?>";
        }

        jQuery(document).ready(function() {
            $(".stretched").parent().parent().addClass("ce-block--stretched");
        })
    </script>
    <style>
        h1{
            text-align: center;
        }
        .btn{
            text-align: center;
            align-items:center;
            justify-content: center;
            display: flex;
            background:rgb(119, 206, 119);
            padding:.4rem;
            width:20%;
            margin:auto;
            border-radius: 8px;
            color:white;
            cursor: pointer;
        }
        .btn:hover{
            background:rgb(17, 170, 17);
        }

        blockquote {
            font-family: "Lora", serif;
            font-size:24px;
            font-style: italic !important;
            font-weight: bold !important;
            font-size: 1.5rem;
            color: #232425;
            line-height: 150%;
            padding: 3rem 0 2rem 0; }
        blockquote div.cdx-quote__text:first-letter {
            color: #7dafca;
            font-size: 72px;
            line-height: 100%;
            float: left;
            padding-right: 0.1em; }
    div.cdx-input.cdx-quote__caption {
        display:none !important;
    }
    .codex-editor__redactor {
        padding-bottom: 100px !important;
    }

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
<?php //die();
