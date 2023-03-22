<section data-scroll-section>
    <div class="dd-container" data-scroll data-scroll-position="top">
        <h1 class="dd-text-gradient" style="
            margin-bottom: 2rem;
        ">Hoppla!</h1>

        <p>Diese Seite existiert nicht bzw. nicht mehr.</p>

        <ul class="dd-call-to-actions">
            <?php
            echo '<li>' . dd_part()->callToAction(
                'Startseite',
                rex_getUrl(1)
            ) . '</li>';
            ?>
        </ul>
    </div>
</section>
