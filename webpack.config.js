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
          compact: true,
          presets: ['es2015']
        }
      }
    ],
  },
  plugins: [
    new BowerWebpackPlugin(),
    new webpack.ProvidePlugin({
      jQuery: 'jquery',
    }),
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false
      },
      output: {
        comments: false
      }
    }),
  ],
};
