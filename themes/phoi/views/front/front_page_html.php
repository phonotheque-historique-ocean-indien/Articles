<div class="container">
	<H2>Derniers contenus ajoutés</H2>
    <?php
    $blocks = $this->getVar("blocks");
    ?>
    <div class="columns derniers-contenus">
        <?php print $blocks; ?>
    </div>
</div>

<style>
    .PODCAST {
        background-color:#5DAE9C !important;
    }
    .EXPOSITION {
        background-color:#EB9560 !important;
    }
</style>
</div>
<div>
<iframe id="audio-player" style="width:100%;height:1170px;" src="http://phoi.ideesculture.test/index.php/AudioPlayer/v/Embed">
</iframe>

    <div>