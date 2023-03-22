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
                // $yform->setObjectparams('form_anchor', 'dd-section-feedback-REX_SLICE_ID');
                $yform->setObjectparams('form_name', 'dd-form-feedback-REX_SLICE_ID');
                $yform->setObjectparams('real_field_names', 1);
                $yform->setObjectparams('submit_btn_show', 0);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '
                                <p class="dd-fs-sm">Um Interessenten zu überzeugen, veröffentliche ich auf meiner Website, was meine Kunden über meine Arbeit denken. Ich würde mich sehr freuen, wenn du mir erlaubst, auch deine Gedanken dazu zu veröffentlichen und mir das folgende Formular ausfüllst. Du musst kein Foto von dir hochladen, aber mit einem Foto wäre der Beitrag natürlich persönlicher.</p>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="dd-container">
                            <div class="dd-w-875">
                ']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '<div class="dd-row">']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                $yform->setValueField('textarea', ['content_original', 'Wie hast du unsere Zusammenarbeit erlebt, wie zufrieden bist du mit dem Ergebnis und würdest du mich wieder beauftragen? <span class="dd-text-danger">*</span>', null, null, '{ "required": "true", "rows": "12" }']);
                $yform->setValueField('html', ['html', 'HTML', '</div>']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '
                    </div>

                    <div class="dd-container-fluid">
                        <h3>Foto</h3>
                    </div>

                    <div class="dd-row">
                        <div class="dd-col-12">
                            <div class="form-group">
                ']);

                $yform->setValueField('php', ['php', 'PHP', "

                    <?php
                    if(rex_get('sent') != 1) {
                        dd_form::dropzone('dropzone', '" . $uploadToken . "', [
                            'acceptedFiles' => '.jpg, .jpeg, .png',
                            'maxFiles' => 1,
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
                $yform->setValueField('text', ['occupation', 'Beschäftigung']);
                $yform->setValidateField('empty', ['occupation', 'Beschäftigung ist leer.']);
                $yform->setValueField('html', ['html', 'HTML', '</div>']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12 dd-col-md-6">']);
                $yform->setValueField('email', ['email', 'E-Mail <span class="dd-text-danger">*</span>', null, null, '{ "required": "true" }']);
                $yform->setValidateField('empty', ['email', 'E-Mail ist leer.']);
                $yform->setValidateField('email', ['email', 'E-Mail ist ungültig.']);
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
                $yform->setValueField('text', ['upload_token', '', $uploadToken, null, '{ "type" : "hidden" }']);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setValueField('spam_protection', ['honeypot', 'Bitte nicht ausfüllen.', 'Ihre Anfrage wurde als Spam erkannt und gelöscht. Bitte versuchen Sie es in einigen Minuten erneut.', 0]);

                /* –––––––––––––––––––––––––––––––––––––––––––––––––– */

                $yform->setActionField('db', ['dd_feedback']);

                $yform->setActionField('callback', ['dd_form::processFeedbackAttachment']);

                $yform->setActionField('tpl2email', ['dd_feedback_receiver', null, $receiver]);

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
?>
