<?php

global $tplData;

?>

<h3 class="h3"><?= $tplData['title'] . " " . $tplData['userInfo']['login']; ?></h3>
<div class="row">
    <div class="col-lg-3">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">

                <h3><?= $tplData['userInfo']['name'] . " " . $tplData['userInfo']['surname'] ?></h3>
            </div>
            <div class="card-body">
                Počet příspěvků: XY
            </div>

        </div>
    </div>
    <div class="col-lg-9">
        <div class="container rounded border p-3">
            <h4>Příspěvky</h4>



        </div>
    </div>
</div>