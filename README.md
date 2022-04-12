# CKEditor 5 for Laravel Nova

This package includes a custom CKEditor 5 field for Laravel Nova (>= 4.0) including a custom build CKEditor with most official plugins (e.g. code-Plugin, table editor, image captions). If you like CKEditor and the out-of-the-box Trix-Editor is too limited for your usecases this package could be a good alternative for content heavy laravel nova projects.

## Installation

You can install the package via composer:

```bash
composer require brgmn/nova-ckeditor
```

## Usage

Just use the CKEditor field class in your nova definitions like this:

```
CKEditor::make('Text', 'body')
                ->rules('required')
                ->withFiles('s3-public', 'articles/content')
                ->options([
                    'language' => 'de',
                    'toolbar' => [
                        'Heading',
                        'Bold',
                        'Italic',
                        '|',
                        'Link',
                        '|',
                        'NumberedList',
                        'BulletedList',
                        'codeBlock',
                        'blockquote',
                        'insertTable',
                        '|',
                        'MediaEmbed',
                        'imageUpload',
                        'toggleImageCaption'
                    ],
                    'mediaEmbed' => [
                        'previewsInData' => true,
                    ],
                    'heading' => [
                'options'=> [
                    [ 'model'=> 'heading2', 'view'=> 'h2', 'title'=> 'Heading 2', 'class'=> 'ck-heading_heading2' ],
                    [ 'model'=> 'heading3', 'view'=> 'h3', 'title'=> 'Heading 3', 'class'=> 'ck-heading_heading3' ]
                ],
            ]]),
```

### Screenshot

![Full featured CKEditor 5 as Laravel Nova 4.0 Field in Action](https://raw.githubusercontent.com/brgmn/nova-ckeditor/master/static/laravel-nova-4-ckeditor-screenshot.png)

### Security

If you discover any security related issues, please email info@brgmn.de instead of using the issue tracker.

## Credits

-   [Martin Brüggemann](https://github.com/brgmn)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
