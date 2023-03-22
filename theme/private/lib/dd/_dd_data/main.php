<?php

use Symfony\Component\Yaml\Parser;

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

class dd_data
{
    public static function activeCatchmentStates()
    {
        $activeCatchmentStates = [];

        foreach(self::catchmentCities() as $value) {
            if(!in_array($value[1], $activeCatchmentStates)) {
                $activeCatchmentStates[] = $value[1];
            }
        }

        sort($activeCatchmentStates);

        $key = [];
        $value = [];

        foreach($activeCatchmentStates as $key[0] => $value[0]) {
            $activeCatchmentStates[$key[0]] = [
                $value[0],
                '',
            ];

            foreach(dd::data('catchment', 'states') as $value[1]) {
                if($value[1][0] == $value[0]) {
                    $activeCatchmentStates[$key[0]][1] = $value[1][1];
                    $activeCatchmentStates[$key[0]][2] = array_key_exists(2, $value[1]) ? $value[1][2] : null;
                }
            }
        }

        return $activeCatchmentStates;
    }

    public static function activeInvoices($companies)
    {
        $companies = !is_array($companies) ? [$companies] : $companies;
        $companies = dd::cleanArray($companies);

        $activeInvoices = [];
        $value = [];

        foreach(self::invoices() as $value[0]) {
            // if($value[0]['payment'] && strtotime($value[0]['payment']) - 1 < time() - 86400 * 7) {
            //     continue;
            // }

            foreach($companies as $value[1]) {
                if($value[1] == $value[0]['company']) {
                    $activeInvoices[] = $value[0];
                }
            }
        }

        return $activeInvoices;
    }

    public static function catchment($keywords = null)
    {
        $catchment = false;

        $keywords = !$keywords ? rex_article::getCurrentId() : $keywords;

        $keywords = !is_array($keywords) ? ['id' => $keywords] : $keywords;
        $catchments = self::catchments();

        foreach($keywords as $key => $value) {
            $key = array_column($catchments, $key);
            $key = array_search($value, $key);

            if($key !== false) {
                $catchment = $catchments[$key];

                break;
            }
        }

        return $catchment;
    }

    public static function catchments($ignoreOfflines = false)
    {
        $value = [];

        $ignoreOfflines = !$ignoreOfflines;

        $catchments = [
            dd::data('catchments'),
            rex_category::get(34)->getChildren($ignoreOfflines),
            []
        ];

        $ignoreOfflines = !$ignoreOfflines;

        $catchments[3] = [];

        foreach($catchments[0] as $value[0]) {
            if(!$ignoreOfflines && !$value[0]['status']) {
                continue;
            }

            $catchments[3][] = $value[0];
        }

        $catchments[0] = $catchments[3];

        unset($catchments[3]);

        foreach($catchments[1] as $value[0]) {
            
            $city = '';
            $cityUrl = '';
            $data = [];
            $image = '';
            $keyword = '';
            $name = $value[0]->getName();
            $nouns = [];
            $prepositions = [];
            $state = '';
            $stateUrl = '';
            $title = [];

            $key = array_column($catchments[0], 'id');

            $key = array_search($value[0]->getValue('cat_catchment'), $key);

            if($key !== false) {
                $data = $catchments[0][$key];
            }

            if($data) {
                $cityUrl = $data['url_city'];
                $image = $data['image'];
                $stateUrl = $data['url_state'];

                unset($data['createdate']);
                unset($data['id']);
                unset($data['image']);
                unset($data['name']);
                unset($data['status']);
                unset($data['updatedate']);
                unset($data['url_city']);
                unset($data['url_state']);
            }

            preg_match_all('/\[.*?\]/', $name, $matches);

            foreach($matches[0] as $value[1]) {
                $name = str_replace($value[1], null, $name);
                $name = trim($name);

                $value[1] = str_replace(['[', ']'], null, $value[1]);

                $prepositions[] = $value[1];
            }

            preg_match_all('/\(.*?\)/', $name, $matches);

            foreach($matches[0] as $value[1]) {
                $name = str_replace($value[1], null, $name);
                $name = trim($name);

                $value[1] = str_replace(['(', ')'], null, $value[1]);

                $value[1] = explode(', ', $value[1]);

                foreach($value[1] as $value[2]) {
                    $value[2] = trim($value[2]);

                    $nouns[] = $value[2];
                }
            }

            array_unshift($nouns, $name);

            $city = array_key_exists(0, $nouns) && $nouns[0] ? $nouns[0] : '';
            $state = array_key_exists(2, $nouns) && $nouns[2] ? $nouns[2] : '';

            $keyword = [
                array_key_exists(1, $nouns) && $nouns[1] ? $nouns[1] : '',
                $value[0]->getValue('cat_keyword') ? $value[0]->getValue('cat_keyword') : '',
            ];

            $keyword[1] = !$keyword[1] ? $keyword[0] : $keyword[1];

            $title[0]  = $city ? $city : '';

            $title[1]  = $title[0];
            $title[1] .= $state && array_key_exists(1, $prepositions) && $prepositions[1] ? ' ' . $prepositions[1] . ' ' . $state : null;

            $title[2]  = $keyword[0];
            $title[2] .= $title[0] && array_key_exists(0, $prepositions) && $prepositions[0] ? ' ' . $prepositions[0] . ' ' . $title[0] : null;

            $title[3]  = $title[2];
            $title[3] .= $state && array_key_exists(1, $prepositions) && $prepositions[1] ? ' ' . $prepositions[1] . ' ' . $state : null;

            $title[4]  = $keyword[1];
            $title[4] .= $title[0] && array_key_exists(0, $prepositions) && $prepositions[0] ? ' ' . $prepositions[0] . ' ' . $title[0] : null;

            $title[5]  = $title[4];
            $title[5] .= $state && array_key_exists(1, $prepositions) && $prepositions[1] ? ' ' . $prepositions[1] . ' ' . $state : null;

            $title[6]  = null;

            preg_match('/\(.*?\)/', $cityUrl, $value[1]);

            if(array_key_exists(0, $value[1])) {
                $cityUrl = str_replace($value[1][0], null, $cityUrl);
                $cityUrl = trim($cityUrl);

                $value[1][0] = str_replace(['(', ')'], null, $value[1][0]);

                $title[6] = $value[1][0];
            }

            $cityUrl = [
                $cityUrl,
                $cityUrl ? '<a href="' . $cityUrl . '" target="_blank" rel="noopener norefferer"' . ($title[6] ? ' title="' . $title[6] . '"' : null) . '>' . $city . '</a>' : '',
            ];

            $title[7]  = null;

            preg_match('/\(.*?\)/', $stateUrl, $value[1]);

            if(array_key_exists(0, $value[1])) {
                $stateUrl = str_replace($value[1][0], null, $stateUrl);
                $stateUrl = trim($stateUrl);

                $value[1][0] = str_replace(['(', ')'], null, $value[1][0]);

                $title[7] = $value[1][0];
            }

            $stateUrl = [
                $stateUrl,
                $stateUrl ? '<a href="' . $stateUrl . '" target="_blank" rel="noopener norefferer"' . ($title[7] ? ' title="' . $title[7] . '"' : null) . '>' . $state . '</a>' : '',
            ];

            $title[0] = [$title[0]];

            $title[0][1] = str_replace(
                [
                    '##' . $city . '##',
                    '##' . $state . '##',
                ], [
                    $cityUrl[1] ? $cityUrl[1] : $city,
                    $stateUrl[1] ? $stateUrl[1] : $state,
                ],
                str_replace(
                    [
                        $city,
                        $state
                    ], [
                        '##' . $city . '##',
                        '##' . $state . '##',
                    ],
                    $title[0][0]
                )
            );

            $title[1] = [$title[1]];

            $title[1][1] = str_replace(
                [
                    '##' . $city . '##',
                    '##' . $state . '##',
                ], [
                    $cityUrl[1] ? $cityUrl[1] : $city,
                    $stateUrl[1] ? $stateUrl[1] : $state,
                ],
                str_replace(
                    [
                        $city,
                        $state
                    ], [
                        '##' . $city . '##',
                        '##' . $state . '##',
                    ],
                    $title[1][0]
                )
            );

            $title[2] = [$title[2]];

            $title[2][1] = str_replace(
                [
                    '##' . $city . '##',
                    '##' . $state . '##',
                ], [
                    $cityUrl[1] ? $cityUrl[1] : $city,
                    $stateUrl[1] ? $stateUrl[1] : $state,
                ],
                str_replace(
                    [
                        $city,
                        $state
                    ], [
                        '##' . $city . '##',
                        '##' . $state . '##',
                    ],
                    $title[2][0]
                )
            );

            $title[3] = [$title[3]];

            $title[3][1] = str_replace(
                [
                    '##' . $city . '##',
                    '##' . $state . '##',
                ], [
                    $cityUrl[1] ? $cityUrl[1] : $city,
                    $stateUrl[1] ? $stateUrl[1] : $state,
                ],
                str_replace(
                    [
                        $city,
                        $state
                    ], [
                        '##' . $city . '##',
                        '##' . $state . '##',
                    ],
                    $title[3][0]
                )
            );

            $title[4] = [$title[4]];

            $title[4][1] = str_replace(
                [
                    '##' . $city . '##',
                    '##' . $state . '##',
                ], [
                    $cityUrl[1] ? $cityUrl[1] : $city,
                    $stateUrl[1] ? $stateUrl[1] : $state,
                ],
                str_replace(
                    [
                        $city,
                        $state
                    ], [
                        '##' . $city . '##',
                        '##' . $state . '##',
                    ],
                    $title[4][0]
                )
            );

            $title[5] = [$title[5]];

            $title[5][1] = str_replace(
                [
                    '##' . $city . '##',
                    '##' . $state . '##',
                ], [
                    $cityUrl[1] ? $cityUrl[1] : $city,
                    $stateUrl[1] ? $stateUrl[1] : $state,
                ],
                str_replace(
                    [
                        $city,
                        $state
                    ], [
                        '##' . $city . '##',
                        '##' . $state . '##',
                    ],
                    $title[5][0]
                )
            );

            unset($title[6]);
            unset($title[7]);

            $catchments[2][] = [
                'city' => [
                    'name' => $city,
                    'url' => $cityUrl,
                ],
                'data' => $data,
                'id' => $value[0]->getId(),
                'image' => $image,
                'keyword' => $keyword,
                'prepositions' => $prepositions,
                'url' => rex_getUrl($value[0]->getId()),
                'state' => [
                    'name' => $state,
                    'url' => $stateUrl,
                ],
                'title' => $title,
            ];
        }

        $catchments = $catchments[2];

        return $catchments;
    }

    public static function catchmentCities()
    {
        return dd::data('catchment', 'cities');
    }

    public static function catchmentStates()
    {
        return dd::data('catchment', 'states');
    }

    public static function favorite($keywords)
    {
        $favorite = false;

        $keywords = !is_array($keywords) ? ['id' => $keywords] : $keywords;
        $favorites = self::favorites(true);

        foreach($keywords as $key => $value) {
            $key = array_column($favorites, $key);
            $key = array_search($value, $key);

            if($key !== false) {
                $favorite = $favorites[$key];

                break;
            }
        }

        return $favorite;
    }

    public static function favorites($ignoreOfflines = false)
    {
        $favorites = [];

        foreach(dd::data('favorites') as $value) {
            if(!$ignoreOfflines && !$value['status']) {
                continue;
            }

            $favorites[] = $value;
        }

        return $favorites;
    }

    public static function feedback()
    {
        return dd::data('feedback');
    }

    public static function invoices()
    {
        return dd::data('invoices');
    }

    public static function partners()
    {
        $partners = [];

        foreach(dd_disk::directoryContent(rex_path::base('partners')) as $value) {
            if(!is_dir(rex_path::base('partners') . '/' . $value)) {
                continue;
            }

            try {
                $metadata = (new Parser)->parseFile(rex_path::base('partners/' . $value . '/metadata.yml'));

                if(
                    !array_key_exists('status', $metadata) ||
                    (
                        array_key_exists('status', $metadata) &&
                        !$metadata['status']
                    )
                ) {
                    continue;
                }

                $partners[] = [
                    'filename' => $value,
                    'title' => $metadata['title'],
                ];

                end($partners);

                $key = key($partners);

                if(array_key_exists('url', $metadata)) {
                    $partners[$key]['url'] = $metadata['url'];
                }
            } catch(Exception $exception) {
                continue;
            }
        }

        krsort($partners);

        return $partners;
    }

    public static function projects($favorites = false)
    {
        $projects = [];

        foreach(dd_disk::directoryContent(rex_path::base('projects')) as $value) {
            if(!is_dir(rex_path::base('projects') . '/' . $value)) {
                continue;
            }

            try {
                $metadata = (new Parser)->parseFile(rex_path::base('projects/' . $value . '/metadata.yml'));
                $id = substr($value, 0, 9);

                $value = substr($value, 10);

                if(
                    !array_key_exists('status', $metadata) ||
                    (
                        array_key_exists('status', $metadata) &&
                        !$metadata['status']
                    ) ||
                    (
                        $favorites &&
                        (
                            !array_key_exists('favorite', $metadata) ||
                            !$metadata['favorite']
                        )
                    )
                ) {
                    continue;
                }

                $projects[] = [
                    'filename' => $value,
                    'id' => $id,
                    'title' => $metadata['title'],
                    'type' => $metadata['type'],
                ];

                end($projects);

                $key = key($projects);

                if(array_key_exists('credits', $metadata)) {
                    $projects[$key]['credits'] = $metadata['credits'];
                }

                if(array_key_exists('favorite', $metadata)) {
                    $projects[$key]['favorite'] = $metadata['favorite'];
                }

                if(array_key_exists('post', $metadata)) {
                    $projects[$key]['post'] = $metadata['post'];
                }

                if(array_key_exists('url', $metadata)) {
                    $projects[$key]['url'] = $metadata['url'];
                }
            } catch(Exception $exception) {
                continue;
            }
        }

        krsort($projects);

        return $projects;
    }

    public static function services()
    {
        return dd::data('services');
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    public static function availabilities($key = null)
    {
        return dd_availability::all($key);
    }

    public static function availability($time = null)
    {
        return dd_availability::get($time);
    }

    public static function exception($key = null)
    {
        return dd_availability::exception($key);
    }

    public static function status()
    {
        return dd_availability::status();
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    public static function absence($time = null)
    {
        return dd_event::absence($time);
    }

    public static function absences()
    {
        return dd_event::absences();
    }

    public static function activeAbsences()
    {
        return dd_event::activeAbsences();
    }

    public static function activeMeetings($duplicates)
    {
        return dd_event::activeMeetings($duplicates);
    }

    public static function activeMeetingsAndTargets($duplicates)
    {
        return dd_event::activeMeetingsAndTargets($duplicates);
    }

    public static function activeTargets($duplicates)
    {
        return dd_event::activeTargets($duplicates);
    }

    public static function meetings()
    {
        return dd_event::meetings();
    }

    public static function targets()
    {
        return dd_event::targets();
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    public static function comments($post = null)
    {
        return dd_post::comments($post);
    }

    public static function landing()
    {
        return dd_post::landing();
    }

    public static function newestFavoritePost()
    {
        return dd_post::newestFavorite();
    }

    public static function newerPosts($post, $audiences = 2)
    {
        return dd_post::newer($post, $audiences);
    }

    public static function newestPost($audiences = 2)
    {
        return dd_post::newest($audiences = 2);
    }

    public static function olderPosts($post, $audiences = 2)
    {
        return dd_post::older($post, $audiences);
    }

    public static function post($keywords)
    {
        return dd_post::get($keywords);
    }

    public static function postArchive($post, $audiences = 2)
    {
        return dd_post::comments($post, $audiences = 2);
    }

    public static function posts($audiences = [1, 2, 3])
    {
        return dd_post::all($audiences);
    }

    public static function replies($parent, $depth = 1)
    {
        return dd_post::replies($parent, $depth);
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    public static function clients($ignoreOfflines = false)
    {
        return dd_receiver::clients($ignoreOfflines);
    }

    public static function exclude($keywords)
    {
        return dd_receiver::exclude($keywords);
    }

    public static function excludes()
    {
        return dd_receiver::excludes();
    }

    public static function follower($keywords)
    {
        return dd_receiver::follower($keywords);
    }

    public static function followers($ignoreOfflines = false)
    {
        return dd_receiver::followers($ignoreOfflines);
    }

    public static function friend($keywords)
    {
        return dd_receiver::friend($keywords);
    }

    public static function friends($ignoreOfflines = false)
    {
        return dd_receiver::friends($ignoreOfflines);
    }

    public static function islander($keywords)
    {
        return dd_receiver::islander($keywords);
    }

    public static function islanders($ignoreOfflines = false)
    {
        return dd_receiver::islanders($ignoreOfflines);
    }

    public static function prospect($keywords)
    {
        return dd_receiver::prospect($keywords);
    }

    public static function prospects()
    {
        return dd_receiver::prospects();
    }

    public static function receiver($keywords)
    {
        return dd_receiver::get($keywords);
    }

    public static function receivers($ignoreOfflines = false)
    {
        return dd_receiver::all($ignoreOfflines);
    }

    /*
    ––––––––––––––––––––––––––––––––––––––––––––––––––
    */

    public static function country($articleKey = null)
    {
        return dd_trip::country($articleKey);
    }

    public static function timeZone()
    {
        return dd_trip::timezone();
    }

    public static function trip($time = null)
    {
        return dd_trip::get($time);
    }

    public static function tripAndDate($time = null)
    {
        return dd_trip::tripAndDate($time);
    }

    public static function trips($ignoreOfflines = false)
    {
        return dd_trip::all($ignoreOfflines);
    }
}
