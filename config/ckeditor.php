<?php

use Brgmn\NovaCKEditor\Models\Attachment;
use Brgmn\NovaCKEditor\Models\PendingAttachment;

return [

    /*
    |--------------------------------------------------------------------------------
    | CKEditor Model
    |--------------------------------------------------------------------------------
    |
    | The fully qualified class name of models.
    |
    */

    'attachment_model' => Attachment::class,
    'pending_attachment_model' => PendingAttachment::class,

    /*
    |--------------------------------------------------------------------------------
    | CKEditor Options
    |--------------------------------------------------------------------------------
    |
    | To view a list of all available options checkout the CKEditor API documentation
    | https://ckeditor.com/docs/CKEditor/latest/builds/guides/integration/configuration.html
    |
    */

    'options' => [
        'language' => 'en',
        'toolbar' => [
            'Heading',
            'Bold',
            'Italic',
            '-',
            'Link',
            '-',
            'NumberedList',
            'BulletedList',
            'BlockQuote',
            '-',
            'MediaEmbed',
            'imageUpload',
        ],
        'image' => [
            'toolbar' => [
                'imageTextAlternative', '|',
                'imageStyle:alignLeft',
                'imageStyle:full',
                'imageStyle:alignRight'
            ],
            'styles' => [
                // This option is equal to a situation where no style is applied.
                'full',
                // This represents an image aligned to the left.
                'alignLeft',
                // This represents an image aligned to the right.
                'alignRight',
            ]
        ],
        'heading' => [
            'options'=> [
                [ 'model'=> 'paragraph', 'title'=> 'Paragraph', 'class'=> 'ck-heading_paragraph'] ,
                [ 'model'=> 'heading2', 'view'=> 'h2', 'title'=> 'Heading 2', 'class'=> 'ck-heading_heading2' ],
                [ 'model'=> 'heading3', 'view'=> 'h3', 'title'=> 'Heading 3', 'class'=> 'ck-heading_heading3' ]
            ],
        ],
    ]

];
