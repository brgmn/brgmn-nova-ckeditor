let mix = require('laravel-mix')
let path = require('path')

require('./mix')

mix.setPublicPath('dist')
    .js('resources/js/field.js', 'js')
    .vue({ version: 3 })
    .sass('resources/sass/field.scss', 'css')
    .nova('brgmn/nova-ckeditor')
