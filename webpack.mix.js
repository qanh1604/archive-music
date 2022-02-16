const { mix } = require('laravel-mix');

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
/*Add generate CRUD*/
let fs = require('fs');

let getDirs = function (dir) {
    // get all 'files' in this directory
    // filter directories
    return fs.readdirSync(dir).filter(file => {
        return fs.statSync(`${dir}/${file}`).isDirectory();
    });
};

let getFiles = function (dir) {
    // get all 'files' in this directory
    // filter directories
    return fs.readdirSync(dir).filter(file => {
        return fs.statSync(`${dir}/${file}`).isFile();
    });
};

getDirs('Modules').forEach(function (filepath) {
    if (fs.existsSync('Modules/' + filepath + '/resources/Vue/controllers')) {
        getFiles('Modules/' + filepath + '/resources/Vue/controllers').forEach(function (fileController) {
            mix.js('Modules/' + filepath + '/resources/Vue/controllers/'+fileController, 'public/Modules/' + filepath + '/js');
        });
    };
    if (fs.existsSync('Modules/' + filepath + '/resources/Vue/style/sass/app.scss')) {
        mix.sass('Modules/' + filepath + '/resources/Vue/style/sass/app.scss', 'public/Modules/' + filepath + '/css/app.css');
    }
});
/*End generate CRUD*/

mix.js('resources/js/app.js', 'public/js/app.js')
    .sass('resources/sass/app.scss', 'public/css');
//append-auto-controller
