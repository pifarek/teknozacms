const mix = require('laravel-mix');
const webpack = require('webpack');

/*
    Teknoza CMS
    If you want to use Webpack - edit page.webpack.mix.js for front-end
    and administrator.webpack.mix.js for administrator
    ===================================================================
    You can use commands:
    - npm run dev
    - npm run production
    - npm run admin-dev
    - npm run admin-production
 */


let type = 'page';
let lastParam = process.argv[process.argv.length - 1];
if(0 <= lastParam.search('--env.type=')) {
    type = lastParam.replace('--env.type=', '');
}

require(`${__dirname}/${type}.webpack.mix.js`);
