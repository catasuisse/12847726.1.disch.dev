<?php

class dd_sql
{
    public static function reindex($tables)
    {
        $tables = !is_array($tables) ? [$tables] : $tables;

        foreach($tables as $value) {
            rex_sql::factory()
                ->setQuery('

                    SET @ROW = 0;

                    UPDATE ' . $value . ' SET id = @ROW := @ROW + 1

                ');
            
            $id = rex_sql::factory()
                ->getArray('
                
                    SELECT id FROM ' . $value . ' ORDER BY id DESC LIMIT 1
                
                ');

            $id = $id ? $id[0]['id'] : 0;
            $id++;

            rex_sql::factory()
                ->setQuery('

                    ALTER TABLE ' . $value . ' AUTO_INCREMENT = ' . $id . '

                ');
        }

        return true;
    }
}
