<?php

require_once rex_path::base('theme/data/_main.php');
require_once rex_path::base('theme/data/_settings.php');

/*
––––––––––––––––––––––––––––––––––––––––––––––––––
*/

class dd_seo
{
    public static function get($key = null)
    {
        $seo = [];

        $article = rex_article::getCurrent();
        
        $seo['description'] = [$article->getValue('yrewrite_description'), ''];
        $seo['title'] = [$article->getValue('yrewrite_title'), ''];

        $catchment = dd_data::catchment($article->getId());

        if($catchment) {
            if(!$seo['description'][0]) {
                $description = trim('

                    Du suchst eine' . ($catchment['keyword'][1] == $catchment['keyword'][0] ? 'n' : null) . ' erfahrene' . ($catchment['keyword'][1] == $catchment['keyword'][0] ? 'n' : null) . ' und exakte' . ($catchment['keyword'][1] == $catchment['keyword'][0] ? 'n' : null) . ' ##keyword_primary## ' . $catchment['prepositions'][0] . ' ##location##? Ich kenne Agenturen von innen und die Branche seit ' . (date('Y', time()) - 1998) . ' Jahren.
                
                ');

                $seo['description'] = [
                    str_replace([
                        '##keyword_primary##',
                        '##keyword_secondary##',
                        '##location##',
                    ],[
                        $catchment['keyword'][0],
                        $catchment['keyword'][1],
                        $catchment['title'][1][0],
                    ], $description),

                    str_replace([
                        '##keyword_primary##',
                        '##keyword_secondary##',
                        '##location##',
                    ], [
                        $catchment['keyword'][0],
                        $catchment['keyword'][1],
                        $catchment['title'][1][1],
                    ], $description),
                ];
            }

            if(!$seo['title'][0]) {
                $seo['title'] = [
                    // $catchment['title'][3][0],
                    // $catchment['title'][3][1],
                    'Agentur für Webdesign, SEO und Branding – ' . $catchment['title'][1][0],
                    'Agentur für Webdesign, SEO und Branding – ' . $catchment['title'][1][1],
                ];
            }
        }

        $seo['title'][0] = !$seo['title'][0] ? $article->getName() : $seo['title'][0];
        $seo['title'][1] = !$seo['title'][1] ? $article->getName() : $seo['title'][1];

        if($key) {
            return $seo[$key];
        }

        return $seo;
    }

    public static function description()
    {
        return self::get('description')[0];
    }

    public static function descriptionTag()
    {
        return '<meta name="description" content="' . self::description() . '">';
    }

    public static function title()
    {
        return self::get('title')[0] . ' / ' . rex::getServerName();
    }

    public static function titleTag()
    {
        return '<title>' . self::title() . '</title>';
    }
}
