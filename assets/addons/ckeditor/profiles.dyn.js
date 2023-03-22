
			/* THIS FILE IS CREATE DYNAMICALLY BY rex_ckeditor::writeProfileJSFile() PHP METHOD. DON'T TOUCH! */

			var ckDefaultProfileName = '';
			var ckProfiles = {};
			var ckSmartStripSettings = {};
			var ckRexHelpPluginAvailable = true;

ckProfiles['lite'] = {
    height: 400,
    fillEmptyBlocks: false,
    forcePasteAsPlainText: true,
    entities: false,
    linkShowTargetTab: false,
    format_tags: 'p;h2;h3',
    removePlugins: 'elementspath',
    extraPlugins: 'rex_help',
    removeDialogTabs: 'link:advanced',
    disallowedContent: 'p{margin,margin-bottom,margin-left,margin-right,margin-top};img{border-style,border-width,margin,margin-bottom,margin-left,margin-right,margin-top};table{width,height}[align,border,cellpadding,cellspacing,summary];caption;',
    toolbar: [
        ['Format'],
        ['Bold', 'Italic'],
        ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'],
        ['Link', 'Unlink', 'Anchor'],
        ['Table'],
        ['PasteText', 'PasteFromWord'],
        ['Maximize'],
        ['rex_help']
        // no comma after last entry!!!
    ]
    // no comma after last entry!!!
};

ckSmartStripSettings['lite'] = 1;

ckProfiles['standard'] = {
    height: 400,
    fillEmptyBlocks: false,
    forcePasteAsPlainText: false,
    entities: false,
    linkShowTargetTab: true,
    format_tags: 'p;h1;h2;h3;pre',
    removePlugins: '',
    extraPlugins: 'rex_help',
    removeDialogTabs: '',
    disallowedContent: 'p{margin,margin-bottom,margin-left,margin-right,margin-top};img{border-style,border-width,margin,margin-bottom,margin-left,margin-right,margin-top};table{width,height}[align,border,cellpadding,cellspacing,summary];caption;',
    toolbar: [
        ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
        ['Link', 'Unlink', 'Anchor'],
        ['Image', 'Table', 'Seperator', 'HorizontalRule', 'SpecialChar'],
        ['TextColor', 'BGColor'],
        ['CreateDiv'],
        ['Maximize'],
        ['Source'],
        ['rex_help'],
        '/',
        ['Format', 'Styles'],
        ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'],
        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
        ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
        // no comma after last entry!!!
    ]
    // no comma after last entry!!!
};

ckSmartStripSettings['standard'] = 1;

ckProfiles['full'] = {
    height: 400,
    fillEmptyBlocks: false,
    forcePasteAsPlainText: false,
    entities: false,
    linkShowTargetTab: true,
    format_tags: 'p;h1;h2;h3;pre',
    removePlugins: '',
    extraPlugins: 'rex_help',
    removeDialogTabs: '',
    disallowedContent: '',
    toolbar: [
        ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates'],
        ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
        ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'],
        ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
        '/',
        ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat'],
        ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'],
        ['Link', 'Unlink', 'Anchor'],
        ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'],
        '/',
        ['Styles', 'Format', 'Font', 'FontSize'],
        ['TextColor', 'BGColor'],
        ['Maximize', 'ShowBlocks'],
        ['rex_help']
        // no comma after last entry!!!
    ]
    // no comma after last entry!!!
};

ckSmartStripSettings['full'] = 1;

ckProfiles['dd_default'] = {
    height: 175,
    fillEmptyBlocks: false,
    forcePasteAsPlainText: true,
    entities: false,
    linkShowTargetTab: true,
    format_tags: 'p;h1;h2;h3',
    removePlugins: '',
    extraPlugins: 'rex_help',
    removeDialogTabs: '',
    disallowedContent: '',
    toolbar: [
        ['Format', 'Styles', '-', 'PasteText', '-', 'Bold', 'Italic', 'JustifyCenter', '-', 'Link', 'Unlink', '-', 'HorizontalRule', '-', 'Source']
    ],
    stylesSet: [
        { name: 'grösser', element: 'p', attributes: { 'class': 'dd-fs-sm-lg' }},
        { name: 'Button', element: 'a', attributes: { 'class': 'dd-btn dd-btn-primary' }}
    ],
    contentsCss: [
        CKEDITOR.basePath + 'contents.css',
        '.dd-fs-sm-lg { font-size: 1.125em; }' +
        '.dd-btn.dd-btn-primary { color: #f00; }'
    ]
};

ckSmartStripSettings['dd_default'] = 1;

ckDefaultProfileName = 'lite';

ckRexHelpPluginAvailable = true;

