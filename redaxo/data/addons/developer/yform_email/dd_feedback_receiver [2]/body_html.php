<?php
$uploadToken = 'REX_YFORM_DATA[field="upload_token"]';

$image = rex_sql::factory()
    ->getArray('SELECT * FROM dd_feedback WHERE upload_token = "' . $uploadToken . '" ORDER BY createdate DESC LIMIT 1');

if(is_array($image) && array_key_exists(0, $image)) {
    $image = $image[0]['image'];
}
?>

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Es gibt neues Feedback von REX_YFORM_DATA[field="firstname"] REX_YFORM_DATA[field="lastname"], das darauf wartet, freigeschaltet zu werden:</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><?php echo nl2br('REX_YFORM_DATA[field="content_original"]'); ?></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold;">Hier kannst du das Feedback freischalten:</p>

<p style="font-family: Courier, monospace; font-size: 11pt;"><a href="<?php echo rex::getServer(); ?>redaxo/index.php?page=yform/manager/data_edit&table_name=dd_feedback" target="_blank"><?php echo rex::getServer(); ?>redaxo/index.php?page=yform/manager/data_edit&table_name=dd_feedback</a></p>

<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt; font-weight: bold; text-transform: uppercase;">Kontaktdaten:</p>

<ul>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="lastname" prefix="Nachname: "]</li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="firstname" prefix="Vorname: "]</li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="occupation" prefix="Beschäftigung: "]</li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="email" prefix="E-Mail: "]</li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">Bild: <?php echo $image; ?></li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="createdate" prefix="Erstellungsdatum: "]</li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="upload_token" prefix="Token: "]</li>
    <li style="font-family: Courier, monospace; font-size: 11pt;">REX_YFORM_DATA[field="ip" prefix="IP: "]</li>
</ul>

<?php /*
<hr style="margin-bottom: 30px; margin-top: 30px;" />

<p style="font-family: Courier, monospace; font-size: 11pt;">Diese E-Mail wurde via «<?php echo rex::getServer(); ?>» gesendet.</p>
*/ ?>

<?php echo trim(dd::settings('mail', 'signature')); ?>
