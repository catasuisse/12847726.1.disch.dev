<?php

class dd_post
{
    public static function all($audiences = [2, 3], $ignoreOfflines = false)
    {
        $posts = [];

        $audiences = !is_array($audiences) ? [$audiences] : $audiences;

        foreach(dd::data('posts') as $value) {
            if((!$value['status'] && !$ignoreOfflines) || !array_intersect(explode(',', $value['audiences']), $audiences)) {
                continue;
            }

            $posts[] = $value;
        }

        return $posts;
    }

    public static function archive($post = 2, $audiences = [2, 3])
    {
        $newerPosts = dd_post::newer($post);
        $olderPosts = dd_post::older($post);

        $newerPostsQuantity = 7 + (7 - count($newerPosts) < 0 ? 0 : 7 - count($newerPosts));
        $olderPostsQuantity = 7 + (7 - count($olderPosts) < 0 ? 0 : 7 - count($olderPosts));

        if($newerPosts) {
            $newerPosts = array_chunk($newerPosts, $olderPostsQuantity);
            $newerPosts = $newerPosts[0];
            $newerPosts = array_reverse($newerPosts);
        }

        if($olderPosts) {
            $olderPosts = array_chunk($olderPosts, $newerPostsQuantity);
            $olderPosts = $olderPosts[0];
        }

        $archive = array_merge($newerPosts, $olderPosts);

        if($archive) {
            shuffle($archive);

            $archive = array_chunk($archive, 7);
            $archive = $archive[0];
        }

        if(count($archive) < 7) {
            $archive = [];
        }

        return $archive;
    }

    public static function comment($keywords)
    {
        $comment = false;

        $keywords = !is_array($keywords) ? ['id' => $keywords] : $keywords;
        $comments = self::comments();

        foreach($keywords as $key => $value) {
            $key = array_column($comments, $key);
            $key = array_search($value, $key);

            if($key !== false) {
                $comment = $comments[$key];

                break;
            }
        }

        return $comment;
    }

    public static function comments($post = null)
    {
        $comments = [];

        foreach(dd::data('comments') as $value) {
            if(!$value['status'] || ($post && $value['post'] != $post) || $value['parent']) {
                continue;
            }

            $value['depth'] = 0;

            $comments[] = $value;

            $comments = array_merge($comments, self::replies($value['id']));
        }

        return $comments;
    }

    public static function get($keywords)
    {
        $post = false;

        $keywords = !is_array($keywords) ? ['id' => $keywords] : $keywords;
        $posts = self::all([1, 2, 3], true);

        foreach($keywords as $key => $value) {
            $key = array_column($posts, $key);
            $key = array_search($value, $key);

            if($key !== false) {
                $post = $posts[$key];

                break;
            }
        }

        return $post;
    }

    public static function landing()
    {
        $landing = false;

        $posts = self::all();
        $posts = array_reverse($posts);

        foreach($posts as $value) {
            if($value['landing'] && strtotime($value['landing']) >= time()) {
                $landing = $value;

                break;
            }
        }

        return $landing;
    }

    public static function newer($post, $audiences = [2, 3])
    {
        $newer = [];

        $post = self::get($post);

        if(!$post) {
            return false;
        }

        $posts = self::all($audiences);

        $posts = array_reverse($posts);

        foreach($posts as $value) {
            if($post['id'] < $value['id']) {
                $newer[] = $value;
            }
        }

        return $newer;
    }

    public static function newest($audiences = [2, 3])
    {
        $newest = dd_data()->posts($audiences);

        if(!$newest) {
            return false;
        }

        $newest = $newest[0];

        return $newest;
    }

    public static function newestFavorite()
    {
        foreach(self::all() as $value) {
            if($value['favorite']) {
                return $value;
            }
        }

        return false;
    }

    public static function notifyIslanders()
    {
        $destiny = dd::destiny();

        if(!$destiny) {
            return false;
        }

        $islanders = dd_data::islanders();

        if(!$islanders) {
            return false;
        }

        $islander = $islanders[array_rand($islanders)];
        $url = 'https://www.phangan.dev?token=' . dd::formatedToken($islander['token']);

        $message = '

            <p>Hallo ' . $islander['callname'] . '</p>

            <p>Diese Nachrichten, die ich an David schreibe, aber nie verschicke, interessieren dich vielleicht. Ich schreibe sie, weil ich David sehr vermisse und überlasse es dir, was du mit ihnen machst. Diese Nachrichten sollen dir auch zeigen, dass ich auch dich nicht vergessen habe:</p>

            <p><a href="' . $url . '" target="_blank">' . $url . '</a></p>

        ';

        dd::mail(

            $islander['email'],

            'Weil ich David sehr vermisse',

            $message

        );

        return true;
    }

    public static function notifyReceivers($post)
    {
        if(!$post['newsletter']) {
            return false;
        }

        $postAudiences = explode(',', $post['audiences']);
        $receivers = [];

        if(in_array(1, $postAudiences)) {
            $receivers = array_merge($receivers, dd_data::friends());
        }

        if(in_array(2, $postAudiences)) {
            $receivers = array_merge($receivers, dd_data::followers());
        }

        if(in_array(3, $postAudiences)) {
            $receivers = array_merge($receivers, dd_data::clients());
        }

        $receivers = array_unique($receivers, SORT_REGULAR);

        if(!$receivers) {
            return false;
        }

        $excludes = explode(',', $post['excludes']);
        $triggered = false;

        foreach($receivers as $receiver) {
            if(in_array($receiver['id'], $excludes)) {
                continue;
            }

            $callname = $receiver['callname'] ? $receiver['callname'] : $receiver['firstname'];
            $content = $post['content_truncated'];
            $footer = null;
            $message = null;
            $receiverAudiences = explode(',', $receiver['audiences']);

            $salutation = 'Hallo ' . $callname;

            if(in_array(3, $postAudiences) && in_array(3, $receiverAudiences)) {
                $salutation = 'Geschätzte Kundin, geschätzter Kunde';
            } else {
                //
            }

            if($postAudiences == [3]) {
                $content = $post['content_original'] ? $post['content_original'] : $post['content_truncated'];
            } else {
                //
            }

            $message .= '<p>' . $salutation . '</p>';

            $message .= dischdev()->paragraphs($content);

            if($postAudiences == [3]) {
                //
            } else {
                if($post['content_original']) {
                    $url = dd::fullUrl(24, rex_getUrl('', '', ['post_id' => $post['id'], 'token' => dd::formatedToken($receiver['token'])]));

                    $message .= '

                        <p>Den vollständigen Beitrag und die alten Beiträge findest du auf meiner Website. Dort findest du auch die Beiträge, über die ich dich nicht per Newsletter informiere, um die Informationsflut gering zu halten:</p>

                        <p><a href="' . $url . '" target="_blank">' . $url . '</a></p>

                    ';
                }
            }

            if(in_array(3, $postAudiences) && in_array(3, $receiverAudiences)) {
                //
            } else {
                $url = dd::fullUrl(27, rex_getUrl(27, '', ['case' => 1, 'token' => dd::formatedToken($receiver['token'])]));

                $footer .= '

                    <p style="font-size: 87.5%; font-style: italic;">Nachrichten wie diese werden automatisch gesendet, auch wenn ich dich darin persönlich und manchmal auch namentlich anspreche. Wenn du keine solchen Nachrichten mehr erhalten möchtest, öffne bitte den folgenden Link:</p>

                    <p style="font-size: 87.5%; font-style: italic;"><a href="' . $url . '" target="_blank">' . $url . '</a></p>

                ';
            }

            dd::mail(

                $receiver['email'],

                $post['title'],

                $message,

                $footer

            );

            $triggered = true;
        }

        return $triggered;
    }

    public static function older($post, $audiences = [2, 3])
    {
        $older = [];

        $post = self::get($post);

        if(!$post) {
            return false;
        }

        $posts = self::all($audiences);

        foreach($posts as $value) {
            if($post['id'] > $value['id']) {
                $older[] = $value;
            }
        }

        return $older;
    }

    public static function replies($parent, $depth = 1)
    {
        $comments = [];
        $replies = [];

        $comments[0] = dd::data('comments');
        $comments[1] = [];

        $comments[0] = array_reverse($comments[0]);

        if($comments[0]) {
            foreach($comments[0] as $value) {
                if(!$value['status'] || $value['parent'] != $parent) {
                    continue;
                }

                $comments[1][] = $value;
            }
        }

        if($comments[1]) {
            foreach($comments[1] as $value) {
                $value['depth'] = $depth;

                $replies[] = $value;

                $comments[2] = self::replies($value['id'], $depth + 1);

                if($comments[2]) {
                    $replies = array_merge($replies, $comments[2]);
                }
            }
        }

        // if($depth > 0) {
        //     $replies = array_reverse($replies);
        // }

        return $replies;
    }
}
