// Karma configuration
// Generated on Fri Apr 07 2017 23:42:01 GMT+0100 (BST)

module.exports = function(config) {
  config.set({

    // base path that will be used to resolve all patterns (eg. files, exclude)
    basePath: '',
    frameworks: ['jasmine'],
    files: [
//        "../../web/assets/d99891ef/js/forms/*.js",
    	'https://code.jquery.com/jquery-2.2.4.min.js',
    	'assets/form-builder/js/forms/Sortable.min.js',
    	'assets/form-builder/js/forms/helpers.js',
    	'assets/form-builder/js/forms/form.js',
    	'assets/form-builder/js/forms/field.js',
    	'assets/form-builder/js/forms/controller.js',
    	'tests/js/helpersTest.js',
    	'tests/js/formTest.js'
    
    ],

    // list of files to exclude
    exclude: [
    	'assets/form-builder/js/forms/Sortable.min.js',
        'https://cdn.quilljs.com/1.2.0/quill.js',
    ],
    // preprocess matching files before serving them to the browser
    // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
    preprocessors: { },
    reporters: ['progress'],
    port: 9876,
    colors: true,
    logLevel: config.LOG_INFO,
    autoWatch: true,
    browsers: ['PhantomJS'],
    singleRun: false,
    concurrency: Infinity
  })
}
