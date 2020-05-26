<?php
$article = $this->getVar("article");
$id = $this->getVar("id");
$template_title = $this->getVar("template_title");
$article["blocs"]=str_replace('\\\n',"",$article["blocs"]);
$blocs=json_decode($article["blocs"],true);
//var_dump($blocs);die();
$content= $blocs[1]["content"];
$content=mb_substr($content,0,119);
$categ=(strtoupper($template_title));
if(mb_strlen($content)==119) {
    $content=$content."...";
}
?>
<div class="column is-one-third">
    <div class="card">
        <div class="card-image">
            <figure class="image is-3by2">
                <img src="<?php _p($article["image"]); ?>" alt="image thumbnail">
            </figure>
        </div>
        <div class="card-content">
            <div class="content">
                <span class="tag is-primary <?php _p($categ); ?>"><?php _p($categ); ?></span>
                <div class="pull-right"><?php _p($article["date"]); ?></div>
                <h2><?php _p($article["title"]); ?></h2>
                <h3><?php _p($article["subtitle"]); ?></h3>
                <p><?php _p($content); ?></p>
            </div>
        </div>
        <footer class="card-footer">
            <a href="<?php _p(__CA_URL_ROOT__."/index.php/".$template_title."s/Show/Details/".$id); ?>" class="card-footer-item">Lire l'article </a>
        </footer>
    </div>
</div>

