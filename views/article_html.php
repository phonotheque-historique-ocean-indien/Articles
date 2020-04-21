<?php
$article = $this->getVar("article");
?>
<nav class="breadcrumb has-succeeds-separator" aria-label="breadcrumbs">
    <div class="container">
        <ul class="ariane">
            <li><a href="/">Accueil</a></li>
            <li><a href="./Articles">Articles</a></li>
            <li class="is-active"><a href="#" aria-current="page"><?php _p($article["title"]." ".$article["subtitle"]); ?></a></li>
        </ul>
    </div>
</nav>

<section class="section" id="article">
    <div class="container">
        <div class="article-header level">
            <div class="level-left">
                <h1 class="title"><?php _p($article["title"]); ?></h1>
                <h1 class="subtitle"><?php _p($article["subtitle"]); ?></h1>
            </div>
            <div class="level-right">
                <p class="published-by">publié par</p>
                <p class="publisher"><?php _p($article["author"]); ?></p>
                <p class="date"><?php _p($article["date"]); ?></p>
            </div>
        </div>
        <div>
            <img src="<?php _p($article["image"]); ?>" alt="image 1">
        </div>
        <?php
        $blocs = json_decode($article["blocs"], true);

        foreach($blocs as $bloc):
            switch($bloc["type"]):
                case "lead-dropcap": ?>

                    <article class="article-content">
                        <p class="lead-dropcap"><?php _p($bloc["contenu"]); ?></p>
                    </article>

                    <?php break;
                case "paragraphe": ?>

                    <article class="article-content">
                        <?php _p($bloc["contenu"]); ?>
                    </article>

                    <?php break;
                case "image-is-fullsize":?>

                    <figure class="image-full">
                        <img src="<?php print $bloc["image"]; ?>" alt="Image 2 fullwidth">
                        <figcaption><?php print $bloc["figcaption"]; ?></figcaption>
                    </figure>

                    <?php break;
                case "two-images":?>

                    <div class="columns image-row two-images">
                        <figure class="column">
                            <img src="<?php print $bloc["image1"]; ?>" alt="Image 3">
                            <figcaption><?php print $bloc["figcaption1"]; ?></figcaption>
                        </figure>
                        <figure class="column">
                            <img src="<?php print $bloc["image2"]; ?>" alt="Image 4">
                            <figcaption><?php print $bloc["figcaption2"]; ?></figcaption>
                        </figure>
                    </div>

                    <?php break;
                case "image-with-text":?>

                    <article  class="article-content">
                        <div class="columns image-with-text">
                            <div class="column">
                                <img src="<?php print $bloc["image"]; ?>" alt="image 5">
                            </div>
                            <?php print str_replace("&quo;",'"',$bloc["text"]); ?>
                        </div>
                    </article>

                    <?php break;
                case "references":

                    print "<div class=\"article-content footnotes\">";
                    if(sizeof($bloc["footnotes"])>0) {
                        print "<h4>Références</h4><ol>";
                        foreach ($bloc["footnotes"] as $footnote) {
                            print "<li id=\"footnote{$footnote["num"]}\">{$footnote["content"]}</li>";
                        }
                        print "</ol>";
                    }
                    print "<h4>Pour en savoir plus</h4>";
                    print $bloc["notes"];
                    print "</div>";
                    break;
                default:
                    print "<div style='border:1px solid black; padding:50px;margin:20px 0;>Type JSON inconnu : {$bloc["type"]}</div>";

                    break;
            endswitch;
        endforeach; ?>

    </div>
</section>

<section class="section" id="related-playlist">
    <h1>Playlists associées</h1>
</section>

<section class="section" id="now-playing">
    <h1>À l’écoute</h1>
</section>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;1,400;1,700&display=swap');

    .breadcrumb {
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        background-color: #BFD7E3;
        padding: 1rem;
        line-height: 19px;
        color: #232425 !important;
        width: 100vw;
    }

    .breadcrumb a {
        color: #232425 !important;
    }

    .breadcrumb li+li::before {
        color: #232425 !important;
    }

    .ariane {
        padding-left: 0.5rem;
    }

    .level-left,
    .level-right {
        flex-direction: column;
        align-items: baseline;
    }

    h1.title {
        font-size: 2.25rem;
        line-height: 2.6rem;
        color: #232425;
    }

    h1.subtitle {
        font-size: 2.25rem;
        font-weight: 200;
    }

    .published-by {
        font-family: 'Lora', serif;
        font-style: italic !important;
        color: #8D9DA0;
    }

    .publisher {
        color: #E4675F;
        font-weight: 600;
    }

    .article-content {
        padding: 0 22% 0 22%;
        font-family: 'Lora', serif;
    }

    .article-content h2 {
        font-family: "Roboto", sans-serif;
        font-size: 1.8rem;
        font-weight: bold;
        text-align: left;
        margin-bottom: 0.5rem;
        margin-top: 0 !important;
        color: #000000;
    }

    .article-content h4 {
        font-family: "Roboto", sans-serif;
        font-weight: bold;
        font-size: 1rem;
        line-height: 19px;
        text-transform: uppercase;
        color: #000000;
        padding-top: 2rem;
        padding-bottom: 0.8rem;
    }

    .article-content p {
        margin-bottom: 2rem;
        text-align: left;
        font-style: normal;
        color: #232425;
    }

    .article-content p:last-child {
        margin-bottom: 0;
    }

    .lead-dropcap {
        font-style: italic !important;
        font-weight: bold !important;
        font-size: 1.5rem;
        color: #232425;
        line-height: 150%;
        padding: 3rem 1rem 0 0;
    }

    .lead-dropcap:first-letter {
        color: #7DAFCA;
        font-size: 72px;
        line-height: 100%;
        float: left;
        padding-right: 0.1em;
    }

    figure {
        margin-top: 1.5rem;
    }

    figcaption {
        font-family: 'Lora', serif;
        font-size: 1rem;
        line-height: 21px;
        font-style: italic !important;
        color: #8D9DA0 !important;
        padding-left: 1rem;
    }

    .image-full {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    .image-full img {
        min-width: 100% !important;
    }
    .image-with-text {
        padding-top: 40px;
    }

    .image-with-text, .image-row {
        width: 50vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -25vw;
        margin-right: -25vw;
        justify-content: center;
        align-items: center;
    }

    .image-with-text img {
        min-width: 100% !important;
    }

    #related-playlist, #now-playing {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;

    }

    #related-playlist {
        min-height: 10rem;
        background-color: #F2F2F2;
    }

    #now-playing {
        min-height: 10rem;
        background: #EFEFEF;
        opacity: 0.5;
    }

    sup a {
        vertical-align: super;
        text-decoration: underline;
        font-size: 80%;
        color: #E4675F;
    }

    .quote {
        border-left-style: outset;
        border-left-color: rgba(0, 0, 0, 0.15);
        border-left-width: 5px;
        font-style: italic !important;
    }

    .footnotes {
        font-family: "Roboto", sans-serif;
        font-weight: 300;
        font-size: 1rem;
        line-height: 150%;
    }

    .footnotes ol {
        list-style: none;
        counter-reset: red-counter;
    }

    ol li {
        counter-increment: red-counter;
    }

    ol li::before {
        content: counter(red-counter) ". ";
        color: #E4675F;
    }
</style>