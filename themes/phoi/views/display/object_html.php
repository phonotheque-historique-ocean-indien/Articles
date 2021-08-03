<?php
    $id = $this->getVar("id");
?>
<head>
    <title>CollectiveAccess</title>
    <link rel='stylesheet' href='/themes/phoi/assets/pawtucket/css/theme.css' type='text/css' media='all'/>
</head>
<body>
    <div class="columns is-mobile">
        <div class="column is-two-fifths-mobile is-two-fifths-tablet">
            <img src="https://via.placeholder.com/250x264" />
        </div>
        <div class="column is-three-fifths-mobile is-three-fifths-tablet">
            <h3 class="title">Titre</h3>
            <h3 class="subtitle">Auteur</h3>
            <p>Objet <?= $id ?></p>
            <p>Description</p>
        </div>
    </div>
<style>
    html {
        background-color: #eee;
        padding:10px;
        overflow: hidden;
    }
    .title {

    }
    .subtitle {
        font-weight: 200;
    }
</style>
</body>
