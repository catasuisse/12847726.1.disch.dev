<?php
$uploadToken = 'REX_YFORM_DATA[field="upload_token"]';

$file = rex_sql::factory()
    ->getArray('SELECT * FROM dd_upload WHERE upload_token = "' . $uploadToken . '" ORDER BY createdate DESC LIMIT 1');

if(is_array($file) && array_key_exists(0, $file)) {
    $file = $file[0]['file'];
}
?>

<p style="font-family: Courier, monospace; font-size: 11pt;">Ein Kunde hat erfolgreich Dateien auf den Server hochgeladen, die in wenigen Minuten in die Dropbox verschoben werden:</p>

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;"><?php echo $file; ?></p>

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
