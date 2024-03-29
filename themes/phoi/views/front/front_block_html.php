<?php
$article = $this->getVar("article");
$id = $this->getVar("id");
$template_title = $this->getVar("template_title");
$article["blocs"]=str_replace('\\\n',"",$article["blocs"]);
$blocs=json_decode($article["blocs"],true);
//var_dump($blocs);die();
$content= $blocs[1]["content"];
$content = strip_tags($content);
$content=mb_substr($content,0,119);

$categ=(strtoupper($template_title));
if(mb_strlen($content)==119) {
    $content=$content."...";
}
$template_id = $this->getVar("template_id");
if($template_id == 2) {
    $href = __CA_URL_ROOT__."/index.php/".ucfirst($template_title)."s/Show/Details/id/".$id;
} else {
    $href = __CA_URL_ROOT__."/index.php/Articles/Display/Details/id/".$id;
}

?>
<div class="column is-one-third home-articles">
    <div class="card">
        <div class="card-image" onClick='window.location.href = "<?= $href ?>";return false;'>
            <figure class="image is-3by2">
                <?php 
                	$article["image"] = str_replace("https://phoi.ideesculture.fr/", "/", $article["image"]);
                    if($article["image"]):
                ?>
                <img src="<?= $article["image"] ?>" alt="image thumbnail" style="object-fit:cover">
                <?php else: ?>
                    <img style="background: linear-gradient(135deg, rgba(23,87,139,1) 0%, rgba(50,138,173,1) 35%, rgba(124,175,201,1) 100%);">
                <?php endif; ?>
            </figure>

        </div>
        <div class="card-content" onClick=' window.location.href = "<?= $href ?>";return false;'>
            <div class="content">
                <span class="tag is-primary <?php _p($categ); ?>"><?php _p($categ); ?></span>
                <div class="pull-right"><?php _p($article["date"]); ?></div>
                <h2><?php _p($article["title"]); ?></h2>
                <h3><?php _p($article["subtitle"]); ?></h3>
                <p><?php _p($content); ?></p>
            </div>
        </div>
        <footer class="card-footer">
            <a href="<?= $href ?>" class="card-footer-item">
            <?php
            switch($categ) {
                case "PLAYLIST":
                    print "Découvrir la playlist";
                    break;
                case "EXPOSITION":
                case "EXPO":
                    print "Afficher l'exposition";
                    break;
                case "PODCAST":
                    print "Ecouter le podcast";
                    break;
                default : 
                    print "Lire l'article";
                    break;
            }
            ?>
        </a>
        </footer>
    </div>
</div>

