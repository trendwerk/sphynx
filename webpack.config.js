'use strict';

const webpack = require('webpack');

module.exports = {
  watch: true,
  output: {
    filename: 'all.js'
  },
  module: {
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
