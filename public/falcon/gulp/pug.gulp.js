const fs = require('fs');
const path = require('path');
const url = require('url');
const gulp = require('gulp');
const pretty = require('pretty');
const pug = require('pug');
const gulpPug = require('gulp-pug');
const gulpData = require('gulp-data');
const gulpJsbeautifier = require('gulp-jsbeautifier');
const ansi = require('ansi');
const { v4: uuid } = require('uuid');

const { name, version, paths, baseDir, isProd } = require('./utils');
const cursor = ansi(process.stdout);

const options = {
  pretty: !isProd
};

const locals = {
  name: (name.charAt(0).toUpperCase() + name.slice(1)).replace(/-/g, ' '),
  version,
  jsPretty: pretty,
  ENV: process.env.MODE || 'DEVELOPMENT',
  uuid,
  flatSitemap(siteMap) {
    function flatInnter(pages) {
      let flat = [];

      pages.map(page => {
        if (!page.hasOwnProperty('pages')) {
          flat = [...flat, page];
        } else {
          flat = [...flat, ...flatInnter(page.pages)];
        }
      });

      return flat;
    }

    const paths = {};

    flatInnter(siteMap.flatMap(item => item.pages))
      .filter(item => item.name !== '#!')
      .forEach(item => {
        paths[item.pathName] = item.path + '.html';
      });

    return paths;
  }
};

/*=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
|  Pug compiling | middleware
=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-*/
const compilePug = (req, res, next) => {
  const parsed = url.parse(req.url);

  const mkdir = dir => {
    if (!fs.existsSync(`${baseDir}${dir}`)) {
      cursor.hex('#b33a3a').bold();
      console.log(`404: ${baseDir}${dir}`);
      cursor.reset();
      cursor.hex('#00ff00').bold();
      console.log(`creating: ${baseDir}${dir}`);
      cursor.reset();
      fs.mkdirSync(`${baseDir}${dir}`);
    }
  };
  mkdir(path.parse(parsed.pathname).dir);

  if (parsed.pathname.match(/\.html$/) || parsed.pathname === '/') {
    let file = 'index';

    if (parsed.pathname !== '/') {
      file = parsed.pathname.substring(1, parsed.pathname.length - 5);
    }

    const filePath = `${paths.pug.base}/${file}.pug`;

    let html = pug.renderFile(path.resolve(filePath), {
      ...options,
      ...locals
    });
    html = pretty(html, { ocd: false });

    html = html.replace(/\s*(<!-- end of)/g, '$1');

    fs.writeFileSync(`${baseDir}/${file}.html`, html);
  }

  next();
};

gulp.task('pug', () =>
  gulp
    .src(paths.pug.src.pages, {
      cwd: paths.pug.base,
      // This causes the components and docs subfolders to be mirrored in dist folder
      base: paths.pug.base
    })
    .pipe(
      gulpData(file => {
        return {
          ...file,
          ...locals
        };
      })
    )
    .pipe(gulpPug(options))
    .pipe(
      gulpJsbeautifier({
        unformatted: ['code', 'pre', 'em', 'strong', 'span'],
        indent_inner_html: true,
        indent_char: ' ',
        indent_size: 2,
        sep: '\n'
      })
    )
    .pipe(
      gulpJsbeautifier.reporter({
        verbosity: gulpJsbeautifier.report.ALL
      })
    )
    .pipe(gulp.dest(`${baseDir}/${paths.pug.dest}`))
);

module.exports = { compilePug };
