<?php

global $tplData;

if(isset($tplData['errors'])) {

}

?>

<div class="row m-3">
    <div class="container border rounded col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <h3>Registrace</h3><hr>
        <form>
            <div class="row g-3 m-3">
                <div class="form-group col-md-6">
                    <label for="registrationName" class="form-label">Křestní jméno</label>
                    <input type="text" class="form-control" id="registrationName" name="registrationName" placeholder="Křestní jméno">
                </div>

                <div class="form-group col-md-6">
                    <label for="registrationSurName" class="form-label">Příjmení</label>
                    <input type="text" class="form-control" id="registrationSurName" name="registrationSurName" placeholder="Příjmení">
                </div>

                <div class="form-group col-12">
                    <label for="registrationEMail" class="form-label">E-Mail</label>
                    <input type="email" class="form-control" id="registrationEMail" name="registrationEMail" placeholder="voprsalek@example.com">
                </div>

                <div class="form-group col-12">
                    <label for="registrationUserName" class="form-label">Uživalské jméno</label>
                    <input type="text" class="form-control" id="registrationUserName" name="registrationUserName" placeholder="Uživalské jméno">
                </div>

                <div class="form-group col-12">
                    <label for="registrationPassWord" class="form-label">Heslo</label>
                    <input type="password" class="form-control" id="registrationPassWord" name="registrationPassWord" placeholder="Heslo">
                </div>

                <div class="form-group col-12">
                    <label for="registrationPassWord2" class="form-label">Ověření hesla</label>
                    <input type="password" class="form-control" id="registrationPassWord2" name="registrationPassWord2" placeholder="Ověření hesla">
                </div>
                <div class="from-group">
                    <input class="form-check-input" type="checkbox" id="registrationSouhlas">
                    <label class="form-check-label" for="registrationSouhlas">
                        Souhlasím s podmínkami užití
                    </label>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-outline-primary justify-content-end">
                </div>

            </div>
        </form>

    </div>

</div>


