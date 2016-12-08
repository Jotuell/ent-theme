module.exports = {
    files: {
        javascripts: {
            joinTo: {
                'main.js':    /^js/,
                'vendors.js': /^(?!js)/,
            }
        },
        stylesheets: {
            joinTo: 'main.css'
        },
    },
    paths: {
        public: '../../assets',
        watched: ['js', 'scss', 'vendors', 'assets']
    },
    npm: {
        globals: {
            jQuery: 'jquery',
        }/*,
        static: [
            'munger/dist/munger.packed.js',
        ]*/
    },
    conventions: {
        assets: /(assets|vendors\/assets|fonts)/
    },
    plugins: {
        fingerprint: {
            manifestGenerationForce: true,
            manifest: '../../assets/assets.json',
            srcBasePath: '../../assets/',
            destBasePath: '../..',
        },
        copycat: {
            fonts: ['node_modules/font-awesome/fonts'],
        },
        sass: {
            options: {
                includePaths: [
                    'node_modules/font-awesome/scss',
                    'node_modules/foundation-sites/scss',
                    'node_modules/munger/src/scss',
                    'node_modules/munger/node_modules/slick-carousel/slick',
                    'node_modules/munger/node_modules/magnific-popup/dist',
                    //'node_modules/motion-ui/src',
                    //'node_modules/selectize/dist/css',
                ]
            }
        },
        postcss: {
            processors: [
                require('autoprefixer')(['> 1%', 'last 2 versions', 'Firefox ESR', 'Safari >= 8']),
                require('csswring'),
            ]
        }
    }
};
