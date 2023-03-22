<?php
if(rex_get('preview')) {
    if(rex::isFrontend()) {
        $receiver = dd::settings('contact', 'email');
        $uploadToken = dd::token();
        ?>
    
        <section id="dd-section-briefing" class="dd-min-h-0" data-scroll-section>
            <div class="dd-container" data-scroll>
    
                <?php
                if(rex_get('sent') != 1) {
                    $yform = new rex_yform();
    
                    // $yform->setDebug(true);
    
                    $yform->setObjectparams('form_action', rex_getUrl(rex_article::getCurrentId()));
                    $yform->setObjectparams('form_name', 'dd-form-briefing');
                    $yform->setObjectparams('form_ytemplate', 'dischdev, bootstrap');
                    $yform->setObjectparams('submit_btn_show', 0);
    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_1',
                            'Versuche, dein Geschäft so genau wie möglich zu beschreiben.',
                        ]
                    );
                    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_2',
                            'Was unterscheidet dein Geschäft von dem der Konkurrenz?',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_3',
                            'Versuche, deine neue Website so genau wie möglich zu beschreiben.',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_4',
                            'Wenn du schon eine Website hast – wie lautet deren Adresse, was würdest du daran verbessern und was würdest du lassen, wie es ist?',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_5',
                            'Gibt es andere Websites, die dir sehr gefallen und mir einen Eindruck von deinem Geschmack vermitteln können?',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_6',
                            'Welches Ziel verfolgst du mit deiner neuen Website?',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_7',
                            'Dürfte deine neue Website auch sehr bunt und verspielt sein?',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_8',
                            'Gibt es etwas, das dir gar nicht gefallen würde?',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_9',
                            'Gibt es schon eine Hausschrift, ein Logo und/oder andere Bestandteile einer sogenannten «Corporate Identity»?',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_10',
                            'Wenn du schon eine Website hast – kann ich deren Inhalt übernehmen bzw. kannst du den Inhalt schon liefern?',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_11',
                            'Trifft es zu, dass deine neue Website einfach und schlicht werden soll bzw. wie hört sich diese Aussage für dich an?',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_12',
                            'Gibt es spezielle Funktionen (z.B., dass deine Kunden einen Termin buchen können), die deine neue Website enthalten soll?',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_13',
                            'Möchtest du den Inhalt deiner neuen Website selbst bearbeiten können oder soll das immer ich übernehmen?',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_14',
                            'Müsste ich mich an einen bestimmten Abgabetermin halten?',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12">
                    
                    ']);
    
                    $yform->setValueField(
                        'textarea',
                        [
                            'question_15',
                            'Was gibt es noch, das ich wissen soll?',
                        ]
                    );
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <h3 class="dd-rule">Beilagen</h3>
    
                        <div class="dd-col-12">
                            <p class="dd-fs-sm dd-mb-1">Wenn es davon schon etwas gibt, kannst du mir hier alles beilegen, was du für deine neue Website als relevant betrachtest. Zum Beispiel dein Logo, Texte, Bilder usw.</p>
    
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
    
                        <h3 class="dd-rule">Personalien</h3>
    
                    ']);
    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12 dd-col-lg-6">
                    
                    ']);
    
                    $yform->setValueField(
                        'text',
                        [
                            'lastname',
                            'Nachname <span class="dd-text-danger">*</span>',
                            null,
                            null,
                            '{ "required" : "true" }',
                        ]
                    );
    
                    $yform->setValidateField('empty', ['lastname', 'Nachname ist leer.']);
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-col-12 dd-col-lg-6">
                    
                    ']);
    
                    $yform->setValueField(
                        'text',
                        [
                            'firstname',
                            'Vorname <span class="dd-text-danger">*</span>',
                            null,
                            null,
                            '{ "required" : "true" }',
                        ]
                    );
                    
                    $yform->setValidateField('empty', ['firstname', 'Vorname ist leer.']);
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-form-row">
                            <div class="dd-col-12 dd-col-lg-6">
                    
                    ']);
    
                    $yform->setValueField(
                        'email',
                        [
                            'email',
                            'E-Mail <span class="dd-text-danger">*</span>',
                            null,
                            null,
                            '{ "required" : "true" }',
                        ]
                    );
                    
                    $yform->setValidateField('type', ['email', 'email', 'E-Mail ist ungültig.']);
                    $yform->setValidateField('empty', ['email', 'E-Mail ist leer.']);
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-col-12 dd-col-lg-6">
                    
                    ']);
    
                    $yform->setValueField(
                        'text',
                        [
                            'telephone',
                            'Telefon <span class="dd-text-danger">*</span>',
                            null,
                            null,
                            '{ "required" : "true" }',
                        ]
                    );
                    
                    $yform->setValidateField('empty', ['telephone', 'Telefon ist leer.']);
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                            </div>
                        </div>
                    
                    ']);
                    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
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
    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        
                        <div class="dd-col-12">
                            <p class="dd-fs-xs"><span class="dd-text-danger">*</span> erforderlich</p>
                        </div>
    
                    ']);
    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setValueField('datestamp', ['createdate', 'Erstellungsdatum', 'mysql', '', '0']);
                    $yform->setValueField('datestamp', ['updatedate', 'Änderungsdatum', 'mysql', '', '0']);
                    $yform->setValueField('ip', ['ip']);
                    $yform->setValueField('spam_protection', ['honeypot', 'Bitte nicht ausfüllen.', 'Ihre Anfrage wurde als Spam erkannt und gelöscht. Bitte versuchen Sie es in einigen Minuten erneut.', 0]);
                    $yform->setValueField('text', ['upload_token', '', $uploadToken, null, '{ "type" : "hidden" }']);
    
                    /*
                    ––––––––––––––––––––––––––––––––––––––––––––––––––
                    */
    
                    $yform->setActionField('callback', ['dd_form::processBriefingAttachment']);
                    $yform->setActionField('db', ['dd_briefing']);
                    $yform->setActionField('redirect', [rex_getUrl(rex_article::getCurrentId(), null, ['sent' => 1])]);
                    $yform->setActionField('tpl2email', ['dd_briefing_receiver', null, $receiver]);
    
                    echo $yform->getForm();
                } else {
                    ?>
    
                    <p class="dd-h1 dd-text-center">Vielen Dank und bis bald!</p>
    
                    <?php
                }
                ?>
    
            </div>
        </section>
    
        <?php
    }
} else {
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
                    // $yform->setObjectparams('form_anchor', 'dd-section-briefing-REX_SLICE_ID');
                    $yform->setObjectparams('form_name', 'dd-form-briefing-REX_SLICE_ID');
                    $yform->setObjectparams('submit_btn_show', 0);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-row">']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_1', 'Versuche, dein Geschäft so genau wie möglich zu beschreiben.', null, null, '{ "rows": "12" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_2', 'Was unterscheidet dein Geschäft von dem der Konkurrenz?', null, null, '{ "rows": "4" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_3', 'Versuche, deine neue Website so genau wie möglich zu beschreiben.', null, null, '{ "rows": "12" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_4', 'Wenn du schon eine Website hast – wie lautet deren Adresse, was würdest du daran verbessern und was würdest du lassen, wie es ist?', null, null, '{ "rows": "4" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_5', 'Gibt es andere Websites, die dir sehr gefallen und mir einen Eindruck von deinem Geschmack vermitteln können?', null, null, '{ "rows": "4" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_6', 'Welches Ziel verfolgst du mit deiner neuen Website?', null, null, '{ "rows": "4" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_7', 'Dürfte deine neue Website auch sehr bunt und verspielt sein?', null, null, '{ "rows": "4" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_8', 'Gibt es etwas, das dir gar nicht gefallen würde?', null, null, '{ "rows": "4" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_9', 'Gibt es schon eine Hausschrift, ein Logo und/oder andere Bestandteile einer sogenannten «Corporate Identity»?', null, null, '{ "rows": "4" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_10', 'Wenn du schon eine Website hast – kann ich deren Inhalt übernehmen bzw. kannst du den Inhalt schon liefern?', null, null, '{ "rows": "4" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_11', 'Trifft es zu, dass deine neue Website einfach und schlicht werden soll bzw. wie hört sich diese Aussage für dich an?', null, null, '{ "rows": "4" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_12', 'Gibt es spezielle Funktionen (z.B., dass deine Kunden einen Termin buchen können), die deine neue Website enthalten soll?', null, null, '{ "rows": "4" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_13', 'Möchtest du den Inhalt deiner neuen Website selbst bearbeiten können oder soll das immer ich übernehmen?', null, null, '{ "rows": "4" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_14', 'Müsste ich mich an einen bestimmten Abgabetermin halten?', null, null, '{ "rows": "4" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12">']);
                    $yform->setValueField('textarea', ['question_15', 'Was gibt es noch, das ich wissen soll?', null, null, '{ "rows": "12" }']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '
                        </div>
    
                        <div class="dd-container-fluid">
                            <h3>Beilagen</h3>
                        </div>
    
                        <div class="dd-row">
                            <div class="dd-col-12">
                                <p class="dd-fs-sm dd-mb-1">Wenn es davon schon was gibt, kannst du mir hier alles beilegen, was du für deine neue Website als relevant betrachtest. Zum Beispiel dein Logo, Texte, Bilder usw.</p>
    
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
                    $yform->setValueField('text', ['lastname', 'Nachname <span class="dd-text-danger">*</span>', null, null, '{ "required" : "true" }']);
                    $yform->setValidateField('empty', ['lastname', 'Nachname ist leer.']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12 dd-col-md-6">']);
                    $yform->setValueField('text', ['firstname', 'Vorname <span class="dd-text-danger">*</span>', null, null, '{ "required" : "true" }']);
                    $yform->setValidateField('empty', ['firstname', 'Vorname ist leer.']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12 dd-col-md-6">']);
                    $yform->setValueField('email', ['email', 'E-Mail <span class="dd-text-danger">*</span>', null, null, '{ "required" : "true" }']);
                    $yform->setValidateField('empty', ['email', 'E-Mail ist leer.']);
                    $yform->setValidateField('email', ['email', 'E-Mail ist ungültig.']);
                    $yform->setValueField('html', ['html', 'HTML', '</div>']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('html', ['html', 'HTML', '<div class="dd-col-12 dd-col-md-6">']);
                    $yform->setValueField('text', ['telephone', 'Telefon <span class="dd-text-danger">*</span>', null, null, '{ "required" : "true" }']);
                    $yform->setValidateField('type', ['email', 'email', 'E-Mail ist ungültig.']);
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
                    $yform->setValueField('text', ['upload_token', '', $uploadToken, null, '{ "type" : "hidden" }']);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setValueField('spam_protection', ['honeypot', 'Bitte nicht ausfüllen.', 'Ihre Anfrage wurde als Spam erkannt und gelöscht. Bitte versuchen Sie es in einigen Minuten erneut.', 0]);
    
                    /* –––––––––––––––––––––––––––––––––––––––––––––––––– */
    
                    $yform->setActionField('db', ['dd_briefing']);
    
                    $yform->setActionField('callback', ['dd_form::processBriefingAttachment']);
    
                    $yform->setActionField('tpl2email', ['dd_briefing_receiver', null, $receiver]);
    
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
}
?>
