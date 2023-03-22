<?php
$uploadToken = 'REX_YFORM_DATA[field="upload_token"]';

$file = rex_sql::factory()
    ->getArray('SELECT * FROM dd_briefing WHERE upload_token = "' . $uploadToken . '" ORDER BY createdate DESC LIMIT 1');

if(is_array($file) && array_key_exists(0, $file)) {
    $file = $file[0]['file'];
}
?>

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Versuche, dein Geschäft so genau wie möglich zu beschreiben.</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_1"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Was unterscheidet dein Geschäft von dem der Konkurrenz?</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_2"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Versuche, deine neue Website so genau wie möglich zu beschreiben.</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_3"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Wenn du schon eine Website hast – wie lautet deren Adresse, was würdest du daran verbessern und was würdest du lassen, wie es ist?</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_4"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Gibt es Websites, die dir sehr gefallen und mir einen Eindruck von deinem Geschmack vermitteln können?</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_5"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Welches Ziel verfolgst du mit deiner neuen Website?</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_6"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Dürfte deine neue Website auch sehr bunt und verspielt sein?</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_7"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Gibt es etwas, das dir gar nicht gefallen würde?</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_8"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Gibt es schon eine Hausschrift, ein Logo und/oder andere Bestandteile einer sogenannten «Corporate Identity»?</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_9"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Wenn du schon eine Website hast – kann ich deren Inhalt übernehmen bzw. kannst du den Inhalt schon liefern?</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_10"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Trifft es zu, dass deine neue Website einfach und schlicht werden soll bzw. wie hört sich diese Aussage für dich an?</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_11"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Gibt es spezielle Funktionen (z.B., dass deine Kunden einen Termin buchen können), die deine neue Website enthalten soll?</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_12"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Möchtest du den Inhalt deiner neuen Website selbst bearbeiten können oder soll das immer ich übernehmen?</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_13"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Müsste ich mich an einen bestimmten Abgabetermin halten?</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_14"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Was gibt es noch, das ich wissen soll?</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="question_15"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold; text-transform: uppercase;">Kontaktdaten:</p>

<ul>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="lastname" prefix="Nachname: "]</li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="firstname" prefix="Vorname: "]</li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="email" prefix="E-Mail: "]</li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="telephone" prefix="Telefon: "]</li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">Datei: <?php echo $file; ?></li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="createdate" prefix="Erstellungsdatum: "]</li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="upload_token" prefix="Token: "]</li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="ip" prefix="IP: "]</li>
</ul>

<?php /*
<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt;">Diese E-Mail wurde via «<?php echo rex::getServer(); ?>» gesendet.</p>
*/ ?>

<?php echo trim(dd::settings('mail', 'signature')); ?>
