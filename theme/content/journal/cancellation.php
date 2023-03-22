<?php
$case = rex_get('case');
$confirmation = rex_get('confirmation');
$token = dd::unformatedToken(rex_get('token'));

if(!$case || !$token) {
    dischdev()->redirect(6);
}

switch($case) {

    case 2:

        $comment = rex_sql::factory()
            ->getArray('

                SELECT
                *
                FROM
                dd_comment
                WHERE
                notification = :notification
                AND
                token = :token

            ', [

                'notification' => 1,
                'token' => $token,

            ]);

        if(!$comment) {
            dischdev()->redirect(6);
        }

        $comment = $comment[0];

        if($confirmation) {
            rex_sql::factory()
                ->setQuery('

                    UPDATE
                    dd_comment
                    SET
                    notification = :notification
                    WHERE
                    email = :email

                ', [

                    'email' => $comment['email'],
                    'notification' => 0,

                ]);
        }

        break;

    case 1:

        $receiver = rex_sql::factory()
            ->getArray('

                SELECT
                *
                FROM
                dd_receiver
                WHERE
                token = :token

            ', [

                'token' => $token,

            ]);

        if(!$receiver) {
            dischdev()->redirect(6);
        }

        $receiver = $receiver[0];

        if($confirmation) {
            $audiences = dischdev()->removeFromList([1, 2], $receiver['audiences']);

            rex_sql::factory()
                ->setQuery('

                    UPDATE
                    dd_comment
                    SET
                    notification = :notification
                    WHERE
                    email = :email

                ', [

                    'email' => $receiver['email'],
                    'notification' => 0,

                ]);

            rex_sql::factory()
                ->setQuery('

                    UPDATE
                    dd_receiver
                    SET
                    audiences = :audiences,
                    token = :token
                    WHERE
                    id = :id

                ', [

                    'audiences' => $audiences,
                    'id' => $receiver['id'],
                    'token' => dischdev()->token(),


                ]);
        }

        break;

}
?>

<section data-scroll-section>
    <div class="dd-container" data-scroll data-scroll-position="top">
        <?php
        switch($case) {

            case 2:

                if($confirmation) {

                    echo '<p class="dd-text-success">Du erhältst keine Benachrichtigungen mehr.</p>';

                } else {
                    ?>

                    <p class="dd-text-warning">Bist du sicher, dass du keine Benachrichtigungen mehr erhalten möchtest?</p>

                    <ul class="dd-call-to-actions">
                        <?php echo '<li>' . dd_part()->callToAction(
                            'Bestätigen',
                            rex_getUrl(rex_article::getCurrentId(), null, ['case' => $case, 'confirmation' => 1, 'token' => dd::formatedToken($token)]),
                        ) . '</li>'; ?>
                    </ul>

                    <?php
                }

                break;

            case 1:

                if($confirmation) {

                    echo '<p class="dd-text-success">Du wurdest abgemeldet.</p>';

                } else {
                    ?>

                    <p class="dd-text-warning">Bist du sicher, dass du dich abmelden möchtest?</p>

                    <ul class="dd-call-to-actions">
                        <?php echo '<li>' . dd_part()->callToAction(
                            'Bestätigen',
                            rex_getUrl(rex_article::getCurrentId(), null, ['case' => $case, 'confirmation' => 1, 'token' => dd::formatedToken($token)]),
                        ) . '</li>'; ?>
                    </ul>

                    <?php
                }

                break;

        }
        ?>
    </div>
</section>
