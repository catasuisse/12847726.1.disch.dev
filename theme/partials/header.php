<?php
// $absence = dd_data::absence();
// $exception = dd_data::exception();

// $contact = $exception['contact'] || ($absence && $absence['description_contact']) ? true : false;

$contact = false;
?>

<header data-scroll-section data-scroll-position="top">
    <div data-scroll>
        <?php
        echo dd_part()->background();

        echo $contact ? dd_part()->contact() : dd_part()->opening(true);
        ?>
    </div>
</header>
