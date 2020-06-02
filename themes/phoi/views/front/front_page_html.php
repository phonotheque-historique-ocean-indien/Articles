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
<div style="background-color: #f2f2f2;margin-top:80px;">
<iframe id="audio-player" style="width:100%;height:700px;background-color: #f7f6f7;margin:0;padding:0;" src="http://phoi.ideesculture.test/index.php/AudioPlayer/v/Embed">
</iframe><iframe id="audio-player" style="width:100%;height:500px;background-color: #f2f2f2;margin:0;padding:0;" src="http://phoi.ideesculture.test/index.php/AudioPlayer/v/LastPlaylists">
</iframe>

    <div>