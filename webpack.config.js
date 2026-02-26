const path = require('path');
const fs = require('fs');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

const isProd = process.env.NODE_ENV === 'production';

const sources = {
  catalog: [
    path.resolve(__dirname, 'resources/catalog/index.js'),
    path.resolve(__dirname, 'resources/catalog/index.scss'),
  ],
  admin: [
    path.resolve(__dirname, 'resources/admin/index.js'),
    path.resolve(__dirname, 'resources/admin/index.scss'),
  ],
};

const entry = Object.fromEntries(
  Object.entries(sources)
    .map(([name, files]) => [name, files.filter((file) => fs.existsSync(file))])
    .filter(([, files]) => files.length)
);

if (Object.keys(entry).length === 0) {
  throw new Error('No entry files found. Create resources/{catalog,admin}/index.(js|scss) or adjust webpack.config.js.');
}

module.exports = {
  mode: isProd ? 'production' : 'development',
  entry,
  output: {
    filename: 'js/[name].bundle.js',
    path: path.resolve(__dirname, 'public/assets'),
    publicPath: '/assets/',
    clean: false, // handled by CleanWebpackPlugin
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: [['@babel/preset-env', { targets: 'defaults' }]],
          },
        },
      },
      {
        test: /\.s?css$/,
        use: [
          isProd ? MiniCssExtractPlugin.loader : 'style-loader',
          { loader: 'css-loader', options: { sourceMap: !isProd } },
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: { plugins: [require('autoprefixer')] },
              sourceMap: !isProd,
            },
          },
          { loader: 'sass-loader', options: { sourceMap: !isProd } },
        ],
      },
      {
        test: /\.(png|jpe?g|gif|svg)$/i,
        type: 'asset',
        generator: {
          filename: 'images/[name][hash][ext]',
        },
      },
      {
        test: /\.(woff2?|eot|ttf|otf)$/i,
        type: 'asset/resource',
        generator: {
          filename: 'fonts/[name][hash][ext]',
        },
      },
    ],
  },
  plugins: [
    new CleanWebpackPlugin(),
    new MiniCssExtractPlugin({
      filename: 'css/[name].css',
    }),
  ],
  resolve: {
    extensions: ['.js', '.json'],
  },
  devtool: isProd ? false : 'source-map',
  optimization: {
    minimize: isProd,
    minimizer: [
      new CssMinimizerPlugin(),
      new TerserPlugin({ extractComments: false }),
    ],
    splitChunks: {
      chunks: 'all',
    },
  },
  stats: 'minimal',
};
