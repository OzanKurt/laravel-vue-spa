const path = require('path')
const mix = require('laravel-mix')
// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

mix.config.vue.esModule = true

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')

    // .sourceMaps()
    // .disableNotifications()

// if (mix.inProduction()) {
    mix.version()

    mix.extract([
        '@fortawesome/fontawesome-svg-core',
        '@fortawesome/vue-fontawesome',
        'axios',
        'bootstrap',
        'jquery',
        'js-cookie',
        'popper.js',
        'sweetalert2',
        'vform',
        'vue',
        'vue-i18n',
        'vue-meta',
        'vue-router',
        'vuex',
        'vuex-router-sync',
    ])
// }

mix.webpackConfig({
    plugins: [
        // new BundleAnalyzerPlugin()
    ],
    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '~': path.join(__dirname, './resources/js')
        }
    },
    output: {
        // chunkFilename: 'js/[name].js',
        // chunkFilename: 'js/[name].[chunkhash].js',
        // publicPath: mix.config.hmr ? '//localhost:8080' : '/'
    }
})
