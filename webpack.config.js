const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

module.exports = {
  mode: 'development',
  entry: {
    'js/app': './src/js/app.js',
    'js/main': './src/js/main.js',
    'js/inicio': './src/js/inicio.js',
    'js/pages/contacto': './src/js/pages/contacto.js',
    'js/pages/productos': './src/js/pages/productos.js',
    'js/admin/productos': './src/js/admin/productos.js',
    'js/auth/login': './src/js/auth/login.js',
    'css/styles': ['./src/scss/app.scss'],
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'public/build'),
    publicPath: '/public/build/'
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'css/styles.css',
      chunkFilename: '[id].css',
    }),
    new CopyWebpackPlugin({
      patterns: [
        { from: 'node_modules/pdfjs-dist/build/pdf.worker.min.mjs', to: 'pdf.worker.min.js' }
      ]
    })
  ],
  module: {
    rules: [
      {
        test: /\.(c|sc|sa)ss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
          },
          {
            loader: 'css-loader',
          },
          'sass-loader',
        ],
      },
      {
        test: /\.(png|svg|jpe?g|gif)$/,
        type: 'asset/resource',
      },
    ],
  },
};
