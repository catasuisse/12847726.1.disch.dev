<?php
$permission = true;
$token = dd::unformatedToken(rex_get('token'));

if(!dischdev()->permission(rex_article::getCurrentId(), null, $token)) {
    $permission = false;
}

$receiver = dd_data()->receiver(['token' => $token]);

if(!$receiver) {
    $permission = false;
}

if($permission) {
    $channels = explode(',', $receiver['channels']);
    $companies = explode(',', $receiver['companies']);

    $activeInvoices = dd_data()->activeInvoices($companies);
    ?>

    <section id="dd-section-meetings-targets" class="dd-min-h-0" data-scroll-section>
        <div class="dd-container" data-scroll>
            <div data-ajax-events data-token="<?php echo $token; ?>"><?php echo dd_part::loader(); ?></div>

            <form id="dd-form-channels" class="dd-form-channels dd-settings">
                <div class="dd-checkbox-wrapper<?php echo in_array(1, $channels) ? ' dd-active' : null; ?>" data-name="email">
                    <div class="dd-checkbox"></div>
                    <label>Ich möchte per E-Mail benachrichtigt werden, wenn es Änderungen gibt.</label>
                </div>
                <div class="dd-checkbox-wrapper<?php echo in_array(2, $channels) ? ' dd-active' : null; ?>" data-name="sms">
                    <div class="dd-checkbox"></div>
                    <label>Ich möchte per SMS benachrichtigt werden, wenn es Änderungen gibt.</label>
                </div>

                <input name="email" type="hidden" value="<?php echo in_array(1, $channels) ? '1' : '0'; ?>" autocomplete="off" />
                <input name="sms" type="hidden" value="<?php echo in_array(2, $channels) ? '1' : '0'; ?>" autocomplete="off" />
                <input name="token" type="hidden" value="<?php echo $token; ?>" autocomplete="off" />
            </form>
        </div>
    </section>

    <?php
    if($activeInvoices) {
        echo dd_part()->rule();
        ?>

        <section id="dd-section-invoices" class="dd-min-h-0" data-scroll-section>
            <div class="dd-container" data-scroll>
                <table class="dd-table-invoices">
                    <thead>
                        <tr>
                            <th>Beschreibung</th>
                            <th>Summe</th>
                            <th>Fälligkeit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($activeInvoices as $value) {
                            $target = date('d.m.Y', strtotime($value['target'])) . ' (Zürich)';

                            if($value['payment']) {
                                $target = '<span class="dd-text-success">bezahlt</span>';
                            } else if(strtotime($value['target']) + 86400 <= time()) {
                                $target = '<span class="dd-text-danger">' . $target . '</span>';
                            } else if(strtotime($value['target']) - 86400 * 2 <= time()) {
                                $target = '<span class="dd-text-warning">' . $target . '</span>';
                            }
                            ?>

                            <tr data-href="https://dischdev.harvestapp.com/client/invoices/<?php echo $value['token']; ?>" data-target="_blank">
                                <td>Rechnung #<?php echo $value['number']; ?></td>
                                <td><?php echo $value['currency'] . ' ' . number_format($value['debit'], 2, '.', '\''); ?></td>
                                <td><?php echo $target; ?></td>
                            </tr>

                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <?php
    }

} else {

    dd_part()->tokenForm(rex_article::getCurrentId());

}
