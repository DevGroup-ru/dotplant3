import webpack from 'webpack';
// import doiuse from 'doiuse';
// import stylelint from 'stylelint';
import postbem from 'postcss-bem';
import nested from 'postcss-nested';
// var bemLinter = require('postcss-bem-linter');
import pxtorem from 'postcss-pxtorem';
import cssnext from 'postcss-cssnext';
import precss from 'precss';
import flexbugs from 'postcss-flexbugs-fixes';
import reporter from 'postcss-reporter';
import map from 'postcss-map';
import postcssImport from 'postcss-partial-import';
import ExtractTextPlugin from 'extract-text-webpack-plugin';
import WriteFilePlugin from 'write-file-webpack-plugin';
import thePostCSS from 'postcss';
import postAssets from 'postcss-assets';
import fs from 'fs';
import commandLineArgs from 'command-line-args';

const optionDefinitions = [
  { name: 'bundlesPath', alias: 'p', type: String },
  { name: 'bundle', alias: 'b', type: String, multiple: true },
  { name: 'dev', alias: 'd', type: Boolean },
];
const cliOptions = commandLineArgs(optionDefinitions);

/* eslint-disable prefer-template */
// settings start
const supportedBrowsers = [
  'last 2 versions',
  'ie >= 10',
  'Android >= 4',
  'iOS >= 7',
];
const bundlesToPack = cliOptions.bundle || [
  'bundle',
  'core',
  'visual-builder',
];


const bootstrapImporter = thePostCSS.plugin('bootstrapImporter', () =>
  /* eslint-disable no-unused-vars */
  function plugin(css) {
    css.walkAtRules('import-bootstrap', rule => {
      const path = fs.realpathSync(
        process.cwd() + '/../../vendor/dotplant/monster/src/base-bundle/bootstrap/_bootstrap.pcss'
      );
      const node = thePostCSS.atRule({
        name: 'import',
        params: `"${path}`,
      });
      rule.replaceWith(node);
    });

  }
  /* eslint-enable no-unused-vars */
);
const columnHelper = thePostCSS.plugin('columnHelper', () =>
  function plugin(css) {
    css.walkAtRules('_', rule => {
      const nodes = [];
      const medias = [
        '--big',
        '--desktop-wide',
        '--desktop',
        '--tablet',
        '--mobile',
      ];
      const params = rule.params.split(' ');
      Object.keys(medias).forEach(index => {
        const media = medias[index];
        const bigRule = thePostCSS.atRule({
          name: 'media',
          params: '(' + media + ')',
        });
        thePostCSS.atRule({
          name: 'mixin',
          params: 'col_' + params[index] + '_of_12',
        }).moveTo(bigRule);
        nodes.push(bigRule);
      });

      rule.replaceWith(nodes);
    });
  }
);

const dev = cliOptions.dev || process.env.ENV === 'dev';
const minPostfix = dev ? '' : '.min';
const bundles = {};
const bundlesPath = (cliOptions.bundlesPath || './').replace(/\/$/i, '') + '/';

Object.keys(bundlesToPack).forEach(index => {
  const bundle = bundlesToPack[index];
  bundles[bundle] = `${bundlesPath}${bundle}/bundle.js`;
});
const plugins = [
  new webpack.optimize.DedupePlugin(),
  new webpack.optimize.OccurrenceOrderPlugin(),
  new ExtractTextPlugin(`[name]/styles${minPostfix}.css`),
  new WriteFilePlugin(),
];
if (!dev) {
  plugins.push(
    new webpack.optimize.UglifyJsPlugin()
  );
}
const output = {
  path: cliOptions.bundlesPath || './',
  filename: `[name]/scripts${minPostfix}.js`,
};
module.exports = {
  cache: true,
  entry: bundles,
  stats: {
    colors: true,
    reasons: true,
  },
  debug: dev,
  externals: { jquery: 'jQuery' },
  output,
  plugins,
  resolve: {
    root: [
      fs.realpathSync('./'),
    ],
  },
  resolveLoader: {
    root: [
      fs.realpathSync('./node_modules/'),
    ],
  },
  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: /(node_modules|prism\.js|bower_components)/,
        loader: 'babel',
        query: {
          // plugins: ['transform-runtime'],
          cacheDirectory: true,
        },
      },
      {
        test: /\.css$/,
        loader: ExtractTextPlugin.extract(
          'style-loader',
          'css-loader!postcss-loader'// + (!dev ? '!csso-loader' : '')
        ),
      },
    ],
  },
  devtool: dev ? 'inline-source-map' : '',
  postcss: function postcss() {
    return [
      flexbugs(),
      map({
        maps: ['settings.yml'],
      }),
      postcssImport(),


      // doiuse({
      //   browsers: supportedBrowsers,
      //   ignore: [
      //     'rem',
      //     'css-fixed',
      //   ],
      // }),

      pxtorem({
        prop_white_list: ['width', 'font', 'font-size', 'line-height', 'letter-spacing'],
      }),
      bootstrapImporter(),
      columnHelper(),
      precss(),
      postbem({
        defaultNamespace: undefined, // default namespace to use, none by default
        style: 'bem', // suit or bem, suit by default,
        separators: {
          namespace: '-',
          descendent: '__',
          modifier: '_',
        },
        shortcuts: {
          component: 'b',
          modifier: 'm',
          descendent: 'e',
        },
      }),
      nested(),
      cssnext({
        browsers: supportedBrowsers,
        features: {
          autoprefixer: false,
        },
      }),
      cssnext({
        browsers: supportedBrowsers,
      }),
      postAssets(),
      reporter({
        clearMessages: true,
      }),
    ];
  },
  devServer: {
    watchOptions: {
      aggregateTimeout: 300,
      poll: 1000,
    },
    outputPath: output.path,
  },
};
