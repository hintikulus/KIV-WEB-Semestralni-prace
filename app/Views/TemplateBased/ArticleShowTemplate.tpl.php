<?php

global $tplData;

if(isset($tplData['errors'])) {

}

?>

<div class="row mb-3 justify-content-center">
    <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 col-sm-12 col-xs-12">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">

                <h3>Prohlížeč článku</h3>
                <h5><?= $tplData['articleInfo']['title']; ?></h5>
                <p><?= $tplData['articleInfo']['abstract']; ?></p>
                <form method="post">
                    <input type="submit" name="articleShowDownload" value="Stáhnout">
                </form>
            </div>

        </div>
    </div>

</div>


