<?php
$blocks = $this->getVar("blocks");
$is_redactor = $this->getVar("is_redactor");
?>

<div class="index-articles-phoi">
    <nav class="breadcrumb has-succeeds-separator" aria-label="breadcrumbs">
        <div class="container">
            <ul class="ariane">
                <li><a href="/">Accueil</a></li>
                <li class="is-active"><a href="#" aria-current="page">Articles</a></li>
            </ul>
        </div>
    </nav>

    <h1 class="page-title">Articles</h1>
    <div class="display-options level is-flex-desktop">
        <div class="level-left">
        <?php if($is_redactor): ?>
        <a href="/index.php/Articles/Editor/New/template_id/1">
                <button class="button action-btn add-new is-uppercase has-text-centered">
	      <span class="icon">
	        <i class="mdi mdi-plus"></i>
	        </span>
                    &nbsp Nouveau
                </button>
            </a>
            <?php endif; ?>
        </div>

        <div class="level-right">
            <p class="level-item">trier par &nbsp
                <em class="has-text-weight-semibold">le plus récent</em>
                <span class="icon red">
        <i class="fa fa-caret-down"></i>
      </span>
            </p>
            <div class="dropdown is-hoverable">
                <div class="dropdown-trigger">
                    <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
          <span>
            <p class="level-item">présentation par &nbsp
              <em class="has-text-weight-semibold">vignettes</em>
          </span>
                        <span class="icon red">
            <i class="fa fa-caret-down"></i>
          </span>
                    </button>
                </div>
                <div class="dropdown-menu" id="dropdown-menu" role="menu">
                    <div class="dropdown-content">
                        <a href="./list" class="dropdown-item">
                            liste
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="columns">
        <?php print $blocks; ?>
    </div>

    <div class="level">
        <div class="level-item has-text-centered">
            <a href="<?php _p(__CA_URL_ROOT__); ?>/index.php/Articles/Show/All">
                <button class="button action-btn more is-medium has-text-weight-bold">Charger plus d’articles</button>
            </a>
        </div>
    </div>
</div>

<style>
	.index-articles-phoi .card-content {
		cursor: pointer;
	}
</style>
