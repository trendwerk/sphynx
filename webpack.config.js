'use strict';

const webpack = require('webpack');

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
  resolve: {
    moduleDirectories: ["bower_components"]
  }
};
