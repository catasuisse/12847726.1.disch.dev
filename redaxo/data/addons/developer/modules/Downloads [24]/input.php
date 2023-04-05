<div class="form-horizontal">
    <?php
    $id = 2;

    $form = <<<EOT
        <div class="form-group">
            <div class="col-sm-12">
                <label>Datei</label>

                REX_MEDIA[id=1 widget=1]
            </div>
            <div class="col-sm-12">
                <label>Titel</label>

                <input class="form-control" type="text" name="REX_INPUT_VALUE[$id][0][title]" />
            </div>
        </div>
    EOT;

    echo MBlock::show($id, $form);
    ?>
</div>
