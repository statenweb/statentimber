let webpack = require('webpack');
let path = require('path');
const WebpackCleanupPlugin = require('webpack-cleanup-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = {

    entry: './src/js/app.js',
    output: {
        path: path.join(__dirname, 'dist'),
        filename: 'js/bundle.js',
    },
    module: {
        rules: [

            {
                test: /\.(scss|css)$/,
                use: ExtractTextPlugin.extract(
                    {
                        fallback: 'style-loader',
                        use: [{
                            loader: 'css-loader',
                            options: {
                                importLoaders: 2,
                                sourceMap: true
                            }
                        }, {
                            loader: 'postcss-loader',
                            options: {
                                sourceMap: 'inline'
                            }
                        }, {
                            loader: 'resolve-url-loader'
                        },{
                            loader: 'sass-loader',
                            options: {
                                outputStyle: 'expanded',
                                sourceMap: true
                            }
                        }],
                    }),

            },
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['env'],
                        plugins: ['transform-runtime'],
                    },
                },
            },
            {
                test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'fonts/',
                        publicPath: '../fonts'
                    }
                }]
            },
            {
                test: /\.(png|jpg|gif|jpeg)(\?v=\d+\.\d+\.\d+)?$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'img/',
                        publicPath: '../img/'
                    }
                }]
            }
        ],
    },

    plugins: [
        new ExtractTextPlugin('css/main.css'),
        new WebpackCleanupPlugin()

    ],
};