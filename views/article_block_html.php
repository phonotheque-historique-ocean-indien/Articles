article
<?php
$article = $this->getVar("article");
?>
<div class="card">
    <div class="card-image">
        <figure class="image is-3by2">
            <img src="<?php print $bloc["image"]; ?>" alt="image thumbnail">
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
            <p>Uniquement en vinyle, les meilleurs enregistrements d’un Réunionnais lorem ipsum dolor sit amet....</p>
        </div>
    </div>
    <footer class="card-footer">
        <a href="/index.php/Articles/Show/Details/id/1" class="card-footer-item">Lire l'article</a>
    </footer>
</div>