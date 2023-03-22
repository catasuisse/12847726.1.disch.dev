<?php

class dd_form
{
    public static function dropzone($selector, $uploadToken, $options = null)
    {
        return dd_disk::dropzone($selector, $uploadToken, $options);
    }

    public static function processBriefingAttachment($form)
    {
        $uploadToken = $form->params['value_pool']['email']['upload_token'];

        $directoryPath = dd_disk::path($uploadToken);

        if(!is_dir($directoryPath)) {
            return false;
        }

        dd_disk::deleteDirectory($directoryPath . '/deleted');

        if(!dd_disk::directoryContent($directoryPath)) {
            dd_disk::deleteDirectory($directoryPath);

            return false;
        }

        $zip = dd_disk::generateZip($directoryPath);

        if(!$zip) {
            return false;
        }

        rex_sql::factory()
            ->setQuery('

                UPDATE
                dd_briefing
                SET
                file = :file
                WHERE
                upload_token = :upload_token

            ', [

                'file' => $zip,
                'upload_token' => $uploadToken,

            ]);

        return true;
    }

    public static function processFeedbackAttachment($form)
    {
        $uploadToken = $form->params['value_pool']['email']['upload_token'];

        $temporaryDirectory = dd_disk::path($uploadToken);

        if(!is_dir($temporaryDirectory)) {
            return false;
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        dd_disk::deleteDirectory($temporaryDirectory . '/deleted');

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        $temporaryFileName = dd_disk::directoryContent($temporaryDirectory);

        if($temporaryFileName && array_key_exists(0, $temporaryFileName)) {
            $temporaryFileName = $temporaryFileName[0];

            $temporaryPath = $temporaryDirectory . '/' . $temporaryFileName;

            $finalFileName = dd_disk::moveFileToMediaPool($temporaryPath, 3, $uploadToken);

            dd_disk::deleteDirectory($temporaryDirectory);
        }

        /*
        ––––––––––––––––––––––––––––––––––––––––––––––––––
        */

        if($finalFileName) {
            rex_sql::factory()
                ->setQuery('

                    UPDATE
                    dd_feedback
                    SET
                    image = :image
                    WHERE
                    upload_token = :upload_token

                ', [

                    'image' => $finalFileName,
                    'upload_token' => $uploadToken,

                ]);
        }
    }

    public static function processUploadAttachment($form)
    {
        $uploadToken = $form->params['value_pool']['email']['upload_token'];

        $directoryPath = dd_disk::path($uploadToken);

        if(!is_dir($directoryPath)) {
            return false;
        }

        dd_disk::deleteDirectory($directoryPath . '/deleted');

        if(!dd_disk::directoryContent($directoryPath)) {
            dd_disk::deleteDirectory($directoryPath);

            return false;
        }

        $zip = dd_disk::generateZip($directoryPath);

        if(!$zip) {
            return false;
        }

        rex_sql::factory()
            ->setQuery('

                UPDATE
                dd_upload
                SET
                file = :file
                WHERE
                upload_token = :upload_token

            ', [

                'file' => $zip,
                'upload_token' => $uploadToken,

            ]);

        return true;
    }
}
