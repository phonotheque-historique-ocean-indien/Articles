<?php
$article = $this->getVar("article");
//echo "ok" .is_array($article["blocs"]) . "<br>"; pour vérifier qu'il s'agit d'un array
echo '<pre>';
print_r($article["blocs"]);
//var_dump($article["blocs"]);
echo '<pre>';
//echo $article["blocs"];
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
                <div class="card-details">
                    <p class="author"><?php _p($article["author"]); ?></p>
                    <p class="date pull-right"><?php _p($article["date"]); ?></p>
                </div>
                <h2 class="card-title"><?php _p($article["title"]); ?></h2>
                <h3 class="card-subtitle"><?php _p($article["subtitle"]); ?></h3>
                <p></p>
            </div>
        </div>
        <footer class="card-footer">
            <a href="./Details/id/1" class="card-footer-item">Lire l'article</a>
<!--            <a href="./Details/id/--><?php //_p($article["id"]); ?><!--" class="card-footer-item">Lire l'article </a>-->
        </footer>
    </div>
</div>