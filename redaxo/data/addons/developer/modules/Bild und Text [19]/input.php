<div class="form-horizontal">
    <div class="form-group">
        <div class="col-sm-12">
            <label>Bild</label>

            REX_MEDIA[id=1 widget=1]
        </div>
        <div class="col-sm-12">
            <label>Text</label>

            <textarea
            class="form-control ckeditor"
            name="REX_INPUT_VALUE[1]"
            data-ckeditor-profile="dd_default"
            data-ckeditor-height="300">
                REX_VALUE[1]
            </textarea>
        </div>
        <div class="col-sm-12">
            <label>Artikel</label>

            REX_LINK[id=1 widget=1]
        </div>
        <div class="col-sm-12">
            <label>Label</label>

            <input class="form-control" type="text" name="REX_INPUT_VALUE[3]" value="REX_VALUE[3]">
        </div>
    </div>
    <div class="form-group" style="
        border-top: 2px solid #5bb585;
        margin-top: 60px;
        padding-top: 45px;
    ">
        <div class="col-sm-12">
            <label>Anordnung</label>

            <select class="form-control selectpicker" name="REX_INPUT_VALUE[2]">
                <option value='0'<?= 'REX_VALUE[2]' == '0' ? ' selected="true"' : null; ?>>Bild links und Text rechts</option>
                <option value='1'<?= 'REX_VALUE[2]' == '1' ? ' selected="true"' : null; ?>>Text links und Bild rechts</option>
            </select>
        </div>
    </div>
</div>
