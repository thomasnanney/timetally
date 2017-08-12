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
    workspacesPath + '/js/workspace.jsx',
    projectsPath + '/js/projects.jsx',
    clientsPath + '/js/clients.jsx',
    timerPath + '/js/timer.jsx',
    reportsPath + '/js/reports.jsx',
    usersPath + '/js/users.jsx',
    dashboardPath + '/js/index.jsx'
    ], 'public/js/app.js');
   // .sass('app/Core/resources/assets/sass/app.scss', 'public/css');



mix.webpackConfig({
    resolve: {
        alias: {
            api: path.resolve(__dirname, 'app/API/resources/assets/js/components'),
            auth: path.resolve(__dirname, 'app/Auth/resources/assets/js/components'),
            clients: path.resolve(__dirname, 'app/Clients/resources/assets/js/components'),
            core: path.resolve(__dirname, 'app/Core/resources/assets/js/components'),
            dashboard: path.resolve(__dirname, 'ap/Dashboard/resources/assets/js/components'),
            organizations: path.resolve(__dirname, 'app/Organizations/resources/assets/js/components'),
            projects: path.resolve(__dirname, 'app/Projects/resources/assets/js/components'),
            reports: path.resolve(__dirname, 'app/reports/resources/assets/js/components'),
            timer: path.resolve(__dirname, 'app/timer/resources/assets/js/components'),
            users: path.resolve(__dirname, 'app/users/resources/assets/js/components'),
            workspaces: path.resolve(__dirname, 'app/Workspaces/resources/assets/js/components')
        },
        extensions: ['.jsx']
    }
});