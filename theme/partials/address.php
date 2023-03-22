<div id="dd-address" class="dd-address">
    <?php
    $email = dischdev()->settings('contact', 'email');
    $facebook = dischdev()->settings('contact', 'facebook');
    $instagram = dischdev()->settings('contact', 'instagram');
    $linkedin = dischdev()->settings('contact', 'linkedin');
    $telephone = dischdev()->telephone(dischdev()->settings('contact', 'telephone'));

    echo '<p><a href="mailto:' . $email . '">' . $email . '</a></p>';

    echo '<p><a href="tel:' . $telephone['normal'] . '">' . $telephone['local'] . '</a></p>';
    ?>

    <div id="dd-social" class="dd-social">
        <ul>
            <?php
            if($facebook) {
                echo '

                    <li>
                        <a href="' .  $facebook . '" target="_blank" rel="noopener noreferrer" title="Disch Development bei Facebook">
                            ' . file_get_contents('theme/public/assets/frontend/new/images/icon-facebook.svg') . '
                        </a>
                    </li>

                ';
            }

            if($instagram) {
                echo '

                    <li>
                        <a href="' . $instagram . '" target="_blank" rel="noopener noreferrer" title="Disch Development bei Instagram">
                            ' . file_get_contents('theme/public/assets/frontend/new/images/icon-instagram.svg') . '
                        </a>
                    </li>

                ';
            }

            if($linkedin) {
                echo '

                    <li>
                        <a href="' .  $linkedin . '" target="_blank" rel="noopener noreferrer" title="Disch Development bei LinkedIn">
                            ' . file_get_contents('theme/public/assets/frontend/new/images/icon-linkedin.svg') . '
                        </a>
                    </li>

                ';
            }
            ?>
        </ul>
    </div>
</div>
