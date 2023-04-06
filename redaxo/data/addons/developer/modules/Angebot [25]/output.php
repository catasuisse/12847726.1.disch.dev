<section class="dd-min-h-0" data-scroll-section>
    <div class="dd-container dd-container-lg-fluid" data-scroll>
        <table class="dd-table-invoices">
            <thead>
                <tr>
                    <th>Objekt</th>
                    <th>Etage</th>
                    <th>Zimmer</th>
                    <th>BWF</th>
                    <th>Terrasse</th>
                    <th>Loggia</th>
                    <th>Preis</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                /*
                foreach($activeInvoices as $value) {
                    ?>

                    <tr data-href="https://dischdev.harvestapp.com/client/invoices/<?php echo $value['token']; ?>" data-target="_blank">
                        <td>Rechnung #<?php echo $value['number']; ?></td>
                        <td><?php echo $value['currency'] . ' ' . number_format($value['debit'], 2, '.', '\''); ?></td>
                        <td><?php echo $target; ?></td>
                    </tr>

                    <?php
                }
                */
                ?>
                <tr data-fancybox data-src="/media/grundriss-ug-steinhofhalde-kriens.pdf">
                    <td>Garten</td>
                    <td>UG</td>
                    <td>4.5</td>
                    <td>134.5 m<sup>2</sup></td>
                    <td>–</td>
                    <td>75.0 m<sup>2</sup></td>
                    <td>–</td>
                    <td>frei</td>
                </tr>
                <tr data-fancybox data-src="/media/grundriss-eg-steinhofhalde-kriens.pdf">
                    <td>West</td>
                    <td>EG</td>
                    <td>3.5</td>
                    <td>102.5 m<sup>2</sup></td>
                    <td>25.0 m<sup>2</sup></td>
                    <td>–</td>
                    <td>–</td>
                    <td>frei</td>
                </tr>
                <tr data-fancybox data-src="/media/grundriss-eg-steinhofhalde-kriens.pdf">
                    <td>Ost</td>
                    <td>EG</td>
                    <td>3.5</td>
                    <td>99.0 m<sup>2</sup></td>
                    <td>25.0 m<sup>2</sup></td>
                    <td>–</td>
                    <td>–</td>
                    <td>frei</td>
                </tr>
                <tr data-fancybox data-src="/media/grundriss-og-steinhofhalde-kriens.pdf">
                    <td>Attika</td>
                    <td>OG</td>
                    <td>3.5</td>
                    <td>103.4 m<sup>2</sup></td>
                    <td>96.0 m<sup>2</sup></td>
                    <td>–</td>
                    <td>–</td>
                    <td>frei</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>