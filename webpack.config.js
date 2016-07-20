'use strict';

const webpack = require('webpack'),
      BowerWebpackPlugin = require('bower-webpack-plugin');

module.exports = {
  watch: true,
  output: {
    filename: 'all.js'
  },
  module: {
    preLoaders: [
      {
        test: /\.js/,
        loader: 'eslint',
      }
    ],
    loaders: [
      {
        test: /\.js/,
        loader: 'babel',
        query: {
          presets: ['es2015']
        }
      }
    ]
  },
  plugins: [
      new BowerWebpackPlugin(),
      new webpack.ProvidePlugin({
        jQuery: "jquery",
      }),
  ],
};
