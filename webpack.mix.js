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

var authPath = 'app/Auth/resources/assets';
var clientsPath = 'app/Clients/resources/assets';
var corePath = 'app/Core/resources/assets';
var dashboardPath = 'app/Dashboard/resources/assets';
var organizationsPath = 'app/Organizations/resources/assets';
var projectsPath = 'app/Projects/resources/assets';
var reportsPath = 'app/Reports/resources/assets';
var timerPath = 'app/Timer/resources/assets';
var usersPath = 'app/Users/resources/assets';
var workspacesPath = 'app/Workspaces/resources/assets';

mix.react([
    corePath + '/js/app.jsx',
    workspacesPath + '/js/workspace.jsx'
    ], 'public/js/app.js')
   // .sass('app/Core/resources/assets/sass/app.scss', 'public/css');

mix.styles([
   dashboardPath + '/css/dashboard.common.css'
], 'public/css/common.css');