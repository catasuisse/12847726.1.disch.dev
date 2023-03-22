<?php

class dd_disk
{
    public static function deleteFile($fileName, $uploadToken)
    {
        $rootDirectoryPath = self::path($uploadToken);

        if(!is_dir($rootDirectoryPath)) {
            http_response_code(500);

            exit();
        }

        $finalDirectoryPath = $rootDirectoryPath . '/deleted';

        if(!is_dir($finalDirectoryPath)) {
            mkdir($finalDirectoryPath);
        }

        $temporaryFilePath = $rootDirectoryPath . '/' . $fileName;

        $finalFilePath = $finalDirectoryPath . '/' . $fileName;

        rename($temporaryFilePath, $finalFilePath);

        if(is_file($temporaryFilePath) || !is_file($finalFilePath)) {
            http_response_code(500);

            exit();
        }

        return true;
    }

    public static function deleteDirectory($directoryPath)
    {
        if(!is_dir($directoryPath)) {
            return false;
        }

        $fileNames = self::directoryContent($directoryPath);

        if($fileNames) {
            foreach($fileNames as $value) {
                $filePath = $directoryPath . '/' . $value;

                if(is_dir($filePath)) {
                    self::deleteDirectory($filePath);
                } else {
                    unlink($filePath);
                }
            }
        }

        rmdir($directoryPath);

        if(file_exists($directoryPath)) {
            return false;
        }

        return true;
    }

    public static function directoryContent($directoryPath)
    {
        if(!is_dir($directoryPath)) {
            return false;
        }

        $fileNames = scandir($directoryPath);

        if(!is_array($fileNames)) {
            return false;
        }

        $fileNames = preg_grep('/^([^.])/', $fileNames);
        $fileNames = array_values($fileNames);

        if(!is_array($fileNames)) {
            return false;
        }

        return $fileNames;
    }

    public static function dropzone($id, $uploadToken, $options = null, $class = null)
    {
        ?>

        <div<?php echo ($id ? ' id="' . $id . '"' : null); ?> class="dropzone<?php echo $class ? ' ' . $class : null; ?>">
            <div class="dz-message" data-dz-message>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100" fill="currentColor">
                    <path class="st0" d="M87.935951,45.724018c0.040039-0.572052,0.064041-1.143925,0.064041-1.724022
                		c0-15.440031-12.564064-27.99999-27.999992-27.99999c-11.143925,0-21.180069,6.643944-25.616005,16.74003
                		c-1.432011-0.491985-2.899992-0.740025-4.38397-0.740025c-7.148027,0-13.06407,5.383984-13.884035,12.467972
                		C6.819921,46.296093,0,54.411915,0,63.999996c0,11.027935,8.972087,19.999996,20,19.999996h60c11.02404,0,20-8.972061,20-19.999996
                		C100,56.032024,95.211906,48.872074,87.935951,45.724018z M59.753342,54.696655l-7.033325-7.033325V71.25h-5.43998V47.663357
                		l-7.033329,7.033298l-3.846729-3.846657L50.000076,37.25l13.599895,13.599976L59.753342,54.696655z" />
                </svg>
            </div>
        </div>

        <div id="dd-dz-template" class="dd-dz-template">
            <div class="dz-preview dz-file-preview">
                <div>
                    <div class="dz-image">
                        <img data-dz-thumbnail />
                    </div>
                    <div class="dz-details" data-dz-remove>
                        <div class="dz-filename">
                            <span data-dz-name></span>
                        </div>
                        <div class="dz-size">
                            <span data-dz-size></span>
                        </div>
                    </div>
                    <div class="dz-progress">
                        <span class="dz-upload" data-dz-uploadprogress></span>
                    </div>
                    <div class="dz-success-mark">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100" fill="currentColor"><path d="M77.294319,37.130661L41.938988,72.485992l-9.616657-9.616653l-9.616653-9.616653l9.616653-9.616653l9.616657,9.616653l25.738678-25.73868L77.294319,37.130661z"/></svg>
                    </div>
                    <div class="dz-error-mark">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100" fill="currentColor"><path d="M62.866798,72.483467L50.002514,59.619186L37.133179,72.488518l-9.61665-9.61665l12.869335-12.869331L27.511459,37.128132l9.61665-9.616652l12.874405,12.874403l12.869354-12.869352l9.61665,9.616652L59.619164,50.002537l12.864288,12.864281L62.866798,72.483467z"/></svg>
                    </div>
                    <?php /*
                    <div class="dz-error-message">
                        <span data-dz-errormessage></span>
                    </div>
                    */ ?>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function(event) {
                $(function() {
                    var previewTemplate = document.querySelector('#dd-dz-template').innerHTML;

                    document.querySelector('#dd-dz-template').remove();

                    var dropzoneInstance = new Dropzone('<?php echo '#' . $id; ?>', {

                        previewTemplate: previewTemplate,
                        resizeQuality: 1,
                        thumbnailHeight: 400,
                        thumbnailWidth: 400,
                        url: '/theme/ajax/form-upload.php',

                        <?php
                        if($options && is_array($options)) {
                            foreach($options as $key => $value) {
                                if(is_bool($value)) {
                                    $value = $value ? 'true' : 'false';
                                } else if(is_string($value)) {
                                    $value = '\'' . $value . '\'';
                                }

                                echo $key . ': ' . $value . ',' . "\r\n";
                            }
                        }
                        ?>

                        init: function() {

                            this.on('addedfile', function(file) {

                                $('.dz-preview').hover(function() {
                                    $(this)
                                        .closest('.dropzone')
                                        .addClass('dd-preview-is-hovered');
                                }, function() {
                                    $(this)
                                        .closest('.dropzone')
                                        .removeClass('dd-preview-is-hovered');
                                });

                                if(typeof scroll.update === 'function') {
                                    scroll.update();
                                }

                            });

                            this.on('maxfilesexceeded', function(file) {

                                this.removeAllFiles();

                                this.addFile(file);

                                if(typeof scroll.update === 'function') {
                                    scroll.update();
                                }

                            });

                            this.on('removedfile', function(file) {
                                $.ajax({ url: '/theme/ajax/upload.php', type: 'POST', data: {

                                    file_name: file.name,
                                    request: 'delete',
                                    upload_token: '<?php echo $uploadToken; ?>',

                                }, success: function(data) {

                                    //

                                }, error: function() {

                                    //

                                }});

                                file.previewElement.remove();

                                $('.dd-preview-is-hovered')
                                    .removeClass('dd-preview-is-hovered');
                                
                                if(typeof scroll.update === 'function') {
                                    scroll.update();
                                }

                            });

                            this.on('sending', function(file, xhr, formData) {

                                formData.append('upload_token', '<?php echo $uploadToken; ?>');

                                if(typeof scroll.update === 'function') {
                                    scroll.update();
                                }

                            });

                        },
                    });

                });
            });
        </script>

        <?php
    }

    public static function fileExtension($filePath)
    {
        if(!is_file($filePath)) {
            return false;
        }

        return pathinfo($filePath, PATHINFO_EXTENSION);
    }

    public static function generateZip($directoryPath)
    {
        if(!is_dir($directoryPath)) {
            return false;
        }

        $directoryName = basename($directoryPath);

        $zip = new ZipArchive;

        $zip->open(dirname($directoryPath) . '/' . $directoryName . '.zip', ZipArchive::CREATE);

        $fileNames = self::directoryContent($directoryPath);

        if(!$fileNames) {
            return false;
        }

        foreach($fileNames as $value) {
            $filePath = $directoryPath . '/' . $value;

            $zip->addFile($filePath, $value);
        }

        $zip->close();

        if(!is_file(dirname($directoryPath) . '/' . $directoryName . '.zip')) {
            return false;
        }

        self::deleteDirectory($directoryPath);

        return $directoryName . '.zip';
    }

    public static function path($additionalPath = null)
    {
        return dd::settings('disk', 'path') . ($additionalPath ? '/' . $additionalPath : null);
    }

    public static function moveFileToMediaPool($temporaryFilePath, $categoryId = null, $uploadToken = null)
    {
        if(!$uploadToken) {
            $uploadToken = dd::token();
        }

        $finalFileName = $uploadToken . '.' . self::fileExtension($temporaryFilePath);

        $finalFilePath = rex_path::base('media/' . $finalFileName);

        rename($temporaryFilePath, $finalFilePath);

        if(file_exists($temporaryFilePath) || !file_exists($finalFilePath)) {
            return false;
        }

        $finalFileName = rex_media_service::addMedia([
            'category_id' => $categoryId,
            'filename' => $finalFileName,
            'file' => [
                'name' => $finalFileName,
                'path' => $finalFilePath,
            ],
        ], false);

        if(!array_key_exists('filename', $finalFileName)) {
            return false;
        }

        $finalFileName = $finalFileName['filename'];

        return $finalFileName;
    }

    public static function uploadFile($file, $uploadToken)
    // Attention: Here $file is actually a file!
    {
        if(!is_array($file)) {
            http_response_code(500);

            exit();
        }

        $finalDirectoryPath = self::path($uploadToken);

        if(!is_dir($finalDirectoryPath)) {
            mkdir($finalDirectoryPath);
        }

        $temporaryFilePath = $file['tmp_name'];

        $finalFilePath = $finalDirectoryPath . '/' . $file['name'];

        move_uploaded_file($temporaryFilePath, $finalFilePath);

        if(!is_file($finalFilePath)) {
            http_response_code(500);

            exit();
        }

        return true;
    }
}
