<?php

$post = dd_api::pull('journal', 'next');

if(!$post) {
    return true;
}

$audiences = $post['audiences'];
$contentOriginal = explode('––', $post['content'])[0];
$status = 0;

$contentTruncated = dd::truncate($contentOriginal, 300);

$contentOriginal = dd::truncate($contentOriginal) == $contentTruncated ? '' : $contentOriginal;

$status = $contentOriginal && in_array($audiences, ['1,2', '1,2,3']) ? 1 : $status;

rex_sql::factory()
    ->setQuery('

                INSERT INTO
                dd_post
                SET
                audiences = :audiences,
                comments = :comments,
                content_original = :content_original,
                content_truncated = :content_truncated,
                createdate = :createdate,
                exhibit = :exhibit,
                excludes = :excludes,
                images = :images,
                include = :include,
                landing = :landing,
                newsletter = :newsletter,
                status = :status,
                title = :title,
                updatedate = :updatedate

            ', [

        'audiences' => $post['audiences'],
        'comments' => 0,
        'content_original' => $contentOriginal,
        'content_truncated' => $contentTruncated,
        'createdate' => $post['createdate'],
        'exhibit' => 0,
        'excludes' => '',
        'images' => '',
        'include' => '',
        'landing' => '',
        'newsletter' => 1,
        'status' => $status,
        'title' => $post['title'],
        'updatedate' => $post['createdate'],

    ]);

if($status) {
    $_SERVER['HTTP_HOST'] = !array_key_exists('HTTP_HOST', $_SERVER) ? '' : $_SERVER['HTTP_HOST'];
    $_SERVER['REQUEST_URI'] = !array_key_exists('REQUEST_URI', $_SERVER) ? '' : $_SERVER['REQUEST_URI'];

    $urls = \Url\Profile::getAll();

    if($urls) {
        foreach($urls as $value) {
            $value->deleteUrls();
            $value->buildUrls();
        }
    }
}

$post = rex_sql::factory()
    ->getArray('

                SELECT
                *
                FROM
                dd_post
                ORDER BY
                id DESC

            ');

if(!$post) {
    return false;
}

$post = $post[0];

// if($post['audiences'] == 9) {
//     dd_post::notifyIslanders();
// }

$notification = dd_post::notifyReceivers($post);

return $notification;