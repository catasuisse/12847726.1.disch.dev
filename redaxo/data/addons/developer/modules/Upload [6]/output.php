<?php
if(rex::isFrontend()) {
    $receiver = dd::settings('contact', 'email');
    $uploadToken = dd::token();
    ?>

    <div class="dd-container">
        <div class="dd-w-875">

            <?php
            if(rex_get('sent') != 1) {
                $yform = new rex_yform();

                // $yform->setDebug(true);

                $yform->setObjectparams('form_action', rex_getUrl(rex_article::getCurrentId()));
                // $yform->setObjectparams('form_anchor', 'dd-section-upload-REX_SLICE_ID');
                $yform->setObjectparams('form_name', 'dd-form-upload-REX_SLICE_ID');
                $yform->setObjectparams('real_field_names', 1);
                $yform->setObjectparams('submit_btn_show', 0);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '<div class="dd-row">']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '
                        <div class="dd-col-12">
                            <div class="form-group">
                ']);

                $yform->setValueField('php', ['php', 'PHP', "

                    <?php
                    if(rex_get('sent') != 1) {
                        dd_form::dropzone('dropzone', '" . $uploadToken . "', [
                            'maxFilesize' => 2048,
                        ]);
                    }
                    ?>

                "]);

                $yform->setValueField('html', ['html', 'HTML', '
                            </div>
                        </div>
                ']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '
                    </div>

                    <div class="dd-container-fluid">
                        <h3>Personalien</h3>
                    </div>

                    <div class="dd-row">
                ']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12 dd-col-md-6">']);
                $yform->setValueField('text', ['lastname', 'Nachname <span class="dd-text-danger">*</span>', null, null, '{ "required": "true" }']);
                $yform->setValidateField('empty', ['lastname', 'Nachname ist leer.']);
                $yform->setValueField('html', ['html', 'HTML', '</div>']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12 dd-col-md-6">']);
                $yform->setValueField('text', ['firstname', 'Vorname <span class="dd-text-danger">*</span>', null, null, '{ "required": "true" }']);
                $yform->setValidateField('empty', ['firstname', 'Vorname ist leer.']);
                $yform->setValueField('html', ['html', 'HTML', '</div>']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12 dd-col-md-6">']);
                $yform->setValueField('email', ['email', 'E-Mail <span class="dd-text-danger">*</span>', null, null, '{ "required" : "true" }']);
                $yform->setValidateField('type', ['email', 'email', 'E-Mail ist ungültig.']);
                $yform->setValidateField('empty', ['email', 'E-Mail ist leer.']);
                $yform->setValueField('html', ['html', 'HTML', '</div>']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12 dd-col-md-6">']);
                $yform->setValueField('text', ['telephone', 'Telefon <span class="dd-text-danger">*</span>', null, null, '{ "required" : "true" }']);
                $yform->setValidateField('empty', ['telephone', 'Telefon ist leer.']);
                $yform->setValueField('html', ['html', 'HTML', '</div>']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '
                    <div class="dd-col-12">
                        <button
                            type="submit"
                            name="submit"
                            class="dd-btn dd-btn-primary"
                            style="
                                display: block;
                                margin-left: auto;
                            ">
                            Senden
                        </button>
                    </div>
                ']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '
                    <div class="dd-col-12">
                        <p class="dd-fs-xs"><span class="dd-text-danger">*</span> erforderlich</p>
                    </div>
                ']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '</div>']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('datestamp', ['createdate', 'Erstellungsdatum', 'mysql', '', '0']);
                $yform->setValueField('datestamp', ['updatedate', 'Änderungsdatum', 'mysql', '', '0']);
                $yform->setValueField('ip', ['ip']);
                $yform->setValueField('spam_protection', ['honeypot', 'Bitte nicht ausfüllen.', 'Ihre Anfrage wurde als Spam erkannt und gelöscht. Bitte versuchen Sie es in einigen Minuten erneut.', 0]);
                $yform->setValueField('text', ['upload_token', '', $uploadToken, null, '{ "type" : "hidden" }']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setActionField('db', ['dd_upload']);

                $yform->setActionField('callback', ['dd_form::processUploadAttachment']);

                $yform->setActionField('tpl2email', ['dd_upload_receiver', null, $receiver]);

                $yform->setActionField('redirect', [rex_getUrl(rex_article::getCurrentId(), null, ['sent' => 1])]);

                echo $yform->getForm();
            } else {
                ?>

                <p class="dd-h1 dd-text-center">Vielen Dank und bis bald!</p>

                <?php
            }
            ?>

        </div>
    </div>

    <?php
}
