var Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .enableSassLoader()

    .configureFilenames({
        css: 'css/[name].css',
        js: 'js/[name].js',
        images: '[path][name].[hash:8].[ext]'
    })
    .addEntry('fromton', [
        './assets/js/app.js',
        './assets/sass/app.sass',
    ])
    .addEntry('admin',[
        './assets/js/admin.app.js',
        './assets/sass/admin.app.sass'
    ])

    .autoProvidejQuery()

    .addPlugin(
        new CopyWebpackPlugin([
            { from: './assets/pacman', to: 'pacman' }
        ]
    ))
;

module.exports = Encore.getWebpackConfig();
