// Karma configuration
// Generated on Fri Apr 07 2017 23:42:01 GMT+0100 (BST)

module.exports = function(config) {
  config.set({

    // base path that will be used to resolve all patterns (eg. files, exclude)
    basePath: '',


    // frameworks to use
    // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
    frameworks: ['jasmine'],


    // list of files / patterns to load in the browser
    files: [
        "../../web/assets/d99891ef/js/forms/*.js",
//    	'https://code.jquery.com/jquery-2.2.4.min.js',
//    	'assets/form-builder/js/forms/Sortable.min.js',
//    	'assets/form-builder/js/forms/helpers.js',
//    	'assets/form-builder/js/forms/form.js',
//    	'assets/form-builder/js/forms/field.js',
//    	'assets/form-builder/js/forms/controller.js',
    	'tests/js/helpersTest.js',
    	'tests/js/formTest.js'
    
    ],

    // list of files to exclude
    exclude: [
    'https://cdn.quilljs.com/1.2.0/quill.js',
    ],


    // preprocess matching files before serving them to the browser
    // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
    preprocessors: {
    },


    // test results reporter to use
    // possible values: 'dots', 'progress'
    // available reporters: https://npmjs.org/browse/keyword/karma-reporter
    reporters: ['progress'],


    // web server port
    port: 9876,


    // enable / disable colors in the output (reporters and logs)
    colors: true,


    // level of logging
    // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
    logLevel: config.LOG_INFO,


    // enable / disable watching file and executing tests whenever any file changes
    autoWatch: true,


    // start these browsers
    // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
    browsers: ['PhantomJS'],
   // browsers: ['Firefox'],


    // Continuous Integration mode
    // if true, Karma captures browsers, runs the tests and exits
    singleRun: false,

    // Concurrency level
    // how many browser should be started simultaneous
    concurrency: Infinity
  })
}
