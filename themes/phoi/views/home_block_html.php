<?php
$article = $this->getVar("article");
$access = $this->getVar("access");
$is_redactor = $this->getVar("is_redactor");
$id = $this->getVar("id");
$article["blocs"]=str_replace('\\\n',"",$article["blocs"]);
$blocs=json_decode($article["blocs"],true);
//var_dump($blocs);die();
$content= $blocs[1]["content"];
$content=mb_substr($content,0,119);
if(mb_strlen($content)==119) {
    $content=$content."...";
}

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
<div class="column is-one-third">
    <div class="card">
        <div class="card-image" onClick='window.location.href = "./Details/id/<?php _p($id); ?>"' >
            <figure class="image is-3by2">
            <a href="./Details/id/<?php _p($id); ?>">
                <?php 
                	$article["image"] = str_replace("https://phoi.ideesculture.fr/", "/", $article["image"]);
                    if($article["image"]):
                ?>
                <img src="<?= $article["image"] ?>" alt="image thumbnail">
                <?php else: ?>
                    <img style="background: linear-gradient(135deg, rgba(23,87,139,1) 0%, rgba(50,138,173,1) 35%, rgba(124,175,201,1) 100%);">
                <?php endif; ?>
            </a> 
            </figure>
        </div>
        <div class="card-content"  onClick='window.location.href = "./Details/id/<?php _p($id); ?>";return false;'>
            <div class="content" style="height:210px">
                <div class="card-details">
                    <p class="author" style="margin:0"><?php _p($article["author"]); ?></p>
                    <p class="date pull-right"><?php _p($article["date"]); ?></p>
                </div>
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
                    
                     ?>" style="margin-top:2px;margin-left:0px;margin-bottom:10px;"><?= $article["date_from"]." - ".$article["date_to"]; ?></span><br/>
                    <?php } ?>         
                    
                    <h2 class="card-title"><?php _p($article["title"]); ?></h2>
                <h3 class="card-subtitle"><?php _p($article["subtitle"]); ?></h3>
                <p><?php _p($content); ?></p>
            </div>
        </div>
        <footer class="card-footer">
            <?php if(!$access): ?><span class="tag is-warning" style="margin-top:10px;margin-left:12px;">BROUILLON</span> <?php endif; ?>
            <a href="./Details/id/<?php _p($id); ?>" class="card-footer-item">
<?php _p("Lire l'article"); ?> </a>
        </footer>
    </div>
</div>
