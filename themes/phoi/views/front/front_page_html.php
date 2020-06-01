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
<div style="background-color:#f7f6f7;padding-bottom:70px;">
    <div class="container">
        <h2>A l'écoute</h2>
        <div id="is-playing">
            <div class="gwrapper is-playing">
                <article class="gmain">
                    <div class="columns is-centered">
                        <div class="column text-center">
                            <i class="mdi mdi-skip-previous is-large" style="font-size:2.6em;"></i>
                        </div>
                        <div class="column text-center">
                            <i class="mdi mdi-pause-circle is-large" style="font-size:2.6em;"></i>
                        </div>
                        <div class="column text-center">
                            <i class="mdi mdi-skip-next is-large" style="font-size:2.6em;"></i>
                        </div>
                    </div>
                    <div>
                        <div class="pull-left">01:43</div>
                        <div class="pull-right">-01:57</div>
                    </div>
                    <progress class="progress progress4px is-danger" value="65" max="100">15%</progress>
                </article>
                <aside class="gaside aside-1" style="text-align: left;"><img src="https://phoi.ideesculture.fr/phoi-images/podcasts/Danyel_waro_3.jpeg" style="height:120px;width:auto;"/>
                    <p><b>Panier su la tête, ni chanté</b></p>
                    <p>Alain Peters</p>
                </aside>
                <aside class="gaside aside-2 has-text-left">
                    <div class="columns is-centered">
                        <div class="column has-text-left">
                        <i class="mdi mdi-volume-high is-large" style="font-size:2.6em;"></i>
                        </div>
                    </div>
                    <div>
                        <div class="pull-left">&nbsp;</div>
                        <div class="pull-right">&nbsp;</div>
                    </div>

                    </p>
                    <progress class="progress progress4px" value="15" max="100">15%</progress>

                </aside>
            </div>
        <style>
            .gwrapper.is-playing {
                display: flex;
                flex-flow: row wrap;
                font-weight: normal;
                text-align: center;
            }
            .gwrapper.is-playing img {
                float:left;
                margin-right:20px;
            }

            .gwrapper > * {
                padding: 10px;
                flex: 1 100%;
            }

            .gmain {
                padding-left:0px;
                padding-right: 160px;
            }

            .aside-1.gaside { flex: 3 0 0; }
            .aside-1.gaside p:first-of-type {
                margin-top:12px;
            }

            .aside-2 {
            }

            @media all and (min-width: 600px) {
                .gaside { flex: 1 0 0; }
            }

            @media all and (min-width: 800px) {
                .gmain    { flex: 3 0px; }
                .aside-1 { order: 1; }
                .gmain    { order: 2; }
                .aside-2 { order: 3; }
                .gfooter  { order: 4; }
            }
            .progress.progress4px {
                height:4px;
            }
            .is-playing .column {
                padding-bottom:0;
                padding-top:24px;
            }
        </style>
        </div>
        <table class="table dataTable" id="alecoute" role="grid" style="background-color: transparent">
            <thead>
            <tr role="row">
                <th class="sorting_asc" tabindex="0" aria-controls="revueDePresse" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Titre: activer pour trier la colonne par ordre décroissant" style="width: 903px;">Album</th>
                <th class="sorting" tabindex="0" aria-controls="revueDePresse" rowspan="1" colspan="1" aria-label="Date: activer pour trier la colonne par ordre croissant" style="width: 147px;">Artiste</th>
                <th class="sorting" tabindex="0" aria-controls="revueDePresse" rowspan="1" colspan="1" aria-label="Auteur: activer pour trier la colonne par ordre croissant" style="width: 207px;">Auteur</th></tr>
            </thead>
            <tbody>
            <tr role="row" class="odd">
                <td class="sorting_1"><a href="/index.php/Articles/Show/Details/id/5">Abdullah Ibrahim, la spiritualité faite musique</a></td>
                <td>23.12.2018</td>
                <td>Jonathan GRONDIN</td>
            </tr><tr role="row" class="even">
                <td class="sorting_1"><a href="/index.php/Articles/Show/Details/id/1">Alain Peters Rest’ la maloya</a></td>
                <td>12.12.2019</td>
                <td>Jonhatan Grondin</td>
            </tr><tr role="row" class="odd">
                <td class="sorting_1"><a href="/index.php/Articles/Show/Details/id/4">Dj Sebb, le maître réunionnais de la Gommance</a></td>
                <td>04.05.2020</td>
                <td>Jonhatan Grondin</td>
            </tr><tr role="row" class="even">
                <td class="sorting_1"><a href="/index.php/Articles/Show/Details/id/2">Le séga réunionnais inscrit à l'inventaire national du Patrimoine Culturel Immatériel de France</a></td>
                <td>JJ.MM.AAAA</td>
                <td>Jonhatan Grondin</td>
            </tr><tr role="row" class="odd">
                <td class="sorting_1"><a href="/index.php/Articles/Show/Details/id/6">Pendant le IOMMA,  les femmes donnent le la !</a></td>
                <td>30.04.2020</td>
                <td>Jonathan GRONDIN</td>
            </tr><tr role="row" class="even">
                <td class="sorting_1"><a href="/index.php/Articles/Show/Details/id/3">Siti &amp; The Band Le pouvoir aux femmes</a></td>
                <td>28/04/2020</td>
                <td>Julien LG</td>
            </tr></tbody>
        </table>
    </div>

</div>

<div style="background-color:#f2f2f2">
    <div class="container">
        <h2>Dernières playlists</h2>
        <table class="table dataTable" id="lastplaylists" role="grid" style="background-color: transparent">
            <thead>
            <tr role="row">
                <th class="sorting_asc" tabindex="0" aria-controls="revueDePresse" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Titre: activer pour trier la colonne par ordre décroissant" style="width: 903px;">Album</th>
                <th class="sorting" tabindex="0" aria-controls="revueDePresse" rowspan="1" colspan="1" aria-label="Date: activer pour trier la colonne par ordre croissant" style="width: 147px;">Artiste</th>
                <th class="sorting" tabindex="0" aria-controls="revueDePresse" rowspan="1" colspan="1" aria-label="Auteur: activer pour trier la colonne par ordre croissant" style="width: 207px;">Auteur</th></tr>
            </thead>
            <tbody>
            <tr role="row" class="odd">
                <td class="sorting_1"><a href="/index.php/Articles/Show/Details/id/5">Abdullah Ibrahim, la spiritualité faite musique</a></td>
                <td>23.12.2018</td>
                <td>Jonathan GRONDIN</td>
            </tr><tr role="row" class="even">
                <td class="sorting_1"><a href="/index.php/Articles/Show/Details/id/1">Alain Peters Rest’ la maloya</a></td>
                <td>12.12.2019</td>
                <td>Jonhatan Grondin</td>
            </tr><tr role="row" class="odd">
                <td class="sorting_1"><a href="/index.php/Articles/Show/Details/id/4">Dj Sebb, le maître réunionnais de la Gommance</a></td>
                <td>04.05.2020</td>
                <td>Jonhatan Grondin</td>
            </tr><tr role="row" class="even">
                <td class="sorting_1"><a href="/index.php/Articles/Show/Details/id/2">Le séga réunionnais inscrit à l'inventaire national du Patrimoine Culturel Immatériel de France</a></td>
                <td>JJ.MM.AAAA</td>
                <td>Jonhatan Grondin</td>
            </tr><tr role="row" class="odd">
                <td class="sorting_1"><a href="/index.php/Articles/Show/Details/id/6">Pendant le IOMMA,  les femmes donnent le la !</a></td>
                <td>30.04.2020</td>
                <td>Jonathan GRONDIN</td>
            </tr><tr role="row" class="even">
                <td class="sorting_1"><a href="/index.php/Articles/Show/Details/id/3">Siti &amp; The Band Le pouvoir aux femmes</a></td>
                <td>28/04/2020</td>
                <td>Julien LG</td>
            </tr></tbody>
        </table>
        <div style="text-align:center;padding:4px 0 40px 0;">
            <button class="button is-primary" style="background-color: #e4675f;padding:12px 70px;font-size:1.3em;">Voir plus de playlists</button>
        </div>
    </div>
</div>

    <div>