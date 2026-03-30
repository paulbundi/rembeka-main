const fs = require('fs');
const mix = require('laravel-mix');

// mix.disableSuccessNotifications();
// mix.webpackConfig({ devServer: { disableHostCheck: true }, node: { fs: 'empty' } });

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const sassFiles = [
  'resources/e-commerce/scss/app.scss',
]

const jsFiles = [
  'resources/e-commerce/app.js',
];


const sassAdminFiles = [
    'resources/dashboard/scss/app.scss',
  ]
  
  const jsAdminFiles = [
    'resources/dashboard/app.js',
  ];
  
const copyDirectories = {
//   'node_modules/tinymce/skins': 'public/js/skins',
};

// if (process.env.BUILD === 'all') {
//   sassFiles.push('resources/assets/sass/main.scss');
//   jsFiles.push('resources/assets/js/main.js');
//   jsFiles.push('resources/assets/js/theme.js');
// }

/*
 |--------------------------------------------------------------------------
 | Mix Configuration
 |--------------------------------------------------------------------------
 |
 | Use the files declared above to configure mix.
 |
 */

const sassOutputExtension = mix.inProduction() ? '.[chunkhash].css' : '.css';

jsFiles.forEach((file) => {
  mix.js(file, 'public/js').vue();
});

sassFiles.forEach((file) => {
  const output = file
    .substr(file.lastIndexOf('/'))
    .replace('.scss', sassOutputExtension);

  mix.sass(file, `public/css${output}`)
});

jsAdminFiles.forEach((file) => {
    mix.js(file, 'public/admin-dashboard/js').vue();
  });
  
  sassAdminFiles.forEach((file) => {
    const output = file
      .substr(file.lastIndexOf('/'))
      .replace('.scss', sassOutputExtension);
  
    mix.sass(file, `public/admin-dashboard/css${output}`)
  });
  

Object.keys(copyDirectories).forEach((file) => {
  mix.copyDirectory(file, copyDirectories[file]);
});

if (!mix.inProduction() && process.env.MIX_BROWSER_SYNC === 'true') {
  mix.browserSync({
    proxy: 'https://e-commerce-template.test',
  });
}

mix.options({
  uglify: {
    uglifyOptions: {
      mangle: true,
      compress: false, // The slow bit
    },
  },
});

const updateManifest = () => {
  const mixManifest = 'public/mix-manifest.json';

  fs.readFile(mixManifest, 'utf8', (err, contents) => {
    const content = JSON.parse(contents);
    const newContent = {};

    Object.keys(content)
      .forEach((key) => {
        const cleanKey = key.replace(/\.(.+)\.(.+)$/g, '.$2');
        newContent[cleanKey] = content[key];
      });

    fs.writeFile(mixManifest, JSON.stringify(newContent), (writeErr) => {
      console.error(writeErr);
    });
  });
}

if (mix.inProduction()) {
  console.log('Webpack mix in production');
  mix.disableNotifications();
  mix.webpackConfig({
    output: {
      chunkFilename: '[name].[chunkhash].js',
      filename: '[name].[chunkhash].js',
    },
  }).then(updateManifest);
}
