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
        include: __dirname + '/src'
      }
    ],
    loaders: [
      {
        test: /\.js/,
        loader: 'babel',
        include: __dirname + '/src',
        query: {
          presets: ['es2015']
        }
      }
    ]
  }
};
