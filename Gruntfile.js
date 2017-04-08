module.exports = function (grunt) {

    require('time-grunt')(grunt);
    require('jit-grunt')(grunt);

    grunt.initConfig({
        package: grunt.file.readJSON('package.json'),
        bump: {
            options: {
                files: ['package.json',],
                updateConfigs: ['package'],
                commit: false,
                createTag: false,
                push: false
            }
        },
        less: {
            backend: {
                files: {
                    "backend/assets/compiled/less/combined.css": grunt.file.readJSON('backend/assets/src/less/all.json')
                }
            },
            frontend: {
                files: {
                    "frontend/assets/compiled/less/combined.css": grunt.file.readJSON('frontend/assets/src/less/all.json')
                }
            },
            mainsite: {
                files: {
                    "mainsite/assets/compiled/less/combined.css": grunt.file.readJSON('mainsite/assets/src/less/all.json')
                }
            }
        },
        sass_import: {
            backend: {
                files: {
                    "backend/assets/compiled/sass/combined.scss": grunt.file.readJSON('backend/assets/src/sass/all.json')
                }
            },
            frontend: {
                files: {
                    "frontend/assets/compiled/sass/combined.scss": grunt.file.readJSON('frontend/assets/src/sass/all.json')
                }
            },
            mainsite: {
                files: {
                    "mainsite/assets/compiled/sass/combined.scss": grunt.file.readJSON('mainsite/assets/src/sass/all.json')
                }
            }
        },
        sass: {
            options: {
                sourceMap: true
            },
            backend: {
                files: {
                    "backend/assets/compiled/sass/combined.css": "backend/assets/compiled/sass/combined.scss"
                }
            },
            frontend: {
                files: {
                    "frontend/assets/compiled/sass/combined.css": "frontend/assets/compiled/sass/combined.scss"
                }
            },
            mainsite: {
                files: {
                    "mainsite/assets/compiled/sass/combined.css": "mainsite/assets/compiled/sass/combined.scss"
                }
            }
        },
        typescript: {
            backend: {
                src: grunt.file.readJSON('backend/assets/src/ts/all.json'),
                dest: 'backend/assets/compiled/ts/combined.js',
                options: {
                    module: 'amd', sourceMap: true, target: 'es5'
                }
            },
            frontend: {
                src: grunt.file.readJSON('frontend/assets/src/ts/all.json'),
                dest: 'frontend/assets/compiled/ts/combined.js',
                options: {
                    module: 'amd', sourceMap: true, target: 'es5'
                }
            },
            mainsite: {
                src: grunt.file.readJSON('mainsite/assets/src/ts/all.json'),
                dest: 'mainsite/assets/compiled/ts/combined.js',
                options: {
                    module: 'amd', sourceMap: true, target: 'es5'
                }
            }
        },
        concat: {
            backend: {
                files: {
                    'backend/assets/compiled/css/combined.css': grunt.file.readJSON('backend/assets/src/css/all.json'),
                    'backend/assets/compiled/js/combined.js': grunt.file.readJSON('backend/assets/src/js/all.json'),
                    'backend/web/assets/css/stylesheet.css': grunt.file.readJSON('backend/assets/stylesheet.json'),
                    'backend/web/assets/js/scripts.js': grunt.file.readJSON('backend/assets/javascript.json')
                }
            },
            frontend: {
                files: {
                    'frontend/assets/compiled/css/combined.css': grunt.file.readJSON('frontend/assets/src/css/all.json'),
                    'frontend/assets/compiled/js/combined.js': grunt.file.readJSON('frontend/assets/src/js/all.json'),
                    'frontend/web/assets/css/stylesheet.css': grunt.file.readJSON('frontend/assets/stylesheet.json'),
                    'frontend/web/assets/js/scripts.js': grunt.file.readJSON('frontend/assets/javascript.json')
                }
            },
            mainsite: {
                files: {
                    'mainsite/assets/compiled/css/combined.css': grunt.file.readJSON('mainsite/assets/src/css/all.json'),
                    'mainsite/assets/compiled/js/combined.js': grunt.file.readJSON('mainsite/assets/src/js/all.json'),
                    'mainsite/web/assets/css/stylesheet.css': grunt.file.readJSON('mainsite/assets/stylesheet.json'),
                    'mainsite/web/assets/js/scripts.js': grunt.file.readJSON('mainsite/assets/javascript.json')
                }
            }
        },
        cssmin: {
            backend: {
                files: {
                    'backend/web/assets/css/stylesheet.min.css': grunt.file.readJSON('backend/assets/stylesheet.json')
                }
            },
            frontend: {
                files: {
                    'frontend/web/assets/css/stylesheet.min.css': grunt.file.readJSON('frontend/assets/stylesheet.json')
                }
            },
            mainsite: {
                files: {
                    'mainsite/web/assets/css/stylesheet.min.css': grunt.file.readJSON('mainsite/assets/stylesheet.json')
                }
            }
        },
        uglify: {
            options: {
                mangle: false
            },
            backend: {
                files: {
                    'backend/web/assets/js/scripts.min.js': grunt.file.readJSON('backend/assets/javascript.json')
                }
            },
            frontend: {
                files: {
                    'frontend/web/assets/js/scripts.min.js': grunt.file.readJSON('frontend/assets/javascript.json')
                }
            },
            mainsite: {
                files: {
                    'mainsite/web/assets/js/scripts.min.js': grunt.file.readJSON('mainsite/assets/javascript.json')
                }
            }
        },
        copy: {
            backend: {
                files: [
                    {expand: true, flatten: true, src: ['vendor/bower/bootstrap/fonts/*'], dest: 'backend/web/assets/fonts/', filter: 'isFile'},
                    {cwd: 'vendor/almasaeed2010/adminlte/dist', src: '**/*', dest: 'backend/web/assets/themes/adminlte', expand: true}
                ]
            },
            frontend: {
                files: [
                    {expand: true, flatten: true, src: ['vendor/bower/bootstrap/fonts/*'], dest: 'frontend/web/assets/fonts/', filter: 'isFile'},
                    {cwd: 'vendor/almasaeed2010/adminlte/dist', src: '**/*', dest: 'frontend/web/assets/themes/adminlte', expand: true}
                ]
            },
            mainsite: {
                files: [
                    {expand: true, flatten: true, src: ['vendor/bower/bootstrap/fonts/*'], dest: 'mainsite/web/assets/fonts/', filter: 'isFile'}
                ]
            }
        },
        clean: {
            backend: [
                "backend/assets/compiled/**/*",
                "backend/web/assets/css/*", "!backend/web/assets/css/.gitignore",
                "backend/web/assets/js/*", "!backend/web/assets/js/.gitignore",
                "backend/web/assets/fonts/*", "!backend/web/assets/fonts/.gitignore",
                "backend/web/assets/themes/*", "!backend/web/assets/themes/.gitignore"
            ],
            frontend: [
                "frontend/assets/compiled/**/*",
                "frontend/web/assets/css/*", "!frontend/web/assets/css/.gitignore",
                "frontend/web/assets/js/*", "!frontend/web/assets/js/.gitignore",
                "frontend/web/assets/fonts/*", "!frontend/web/assets/fonts/.gitignore",
                "frontend/web/assets/themes/*", "!frontend/web/assets/themes/.gitignore"
            ],
            mainsite: [
                "mainsite/assets/compiled/**/*",
                "mainsite/web/assets/css/*", "!mainsite/web/assets/css/.gitignore",
                "mainsite/web/assets/js/*", "!mainsite/web/assets/js/.gitignore",
                "mainsite/web/assets/fonts/*", "!mainsite/web/assets/fonts/.gitignore",
                "mainsite/web/assets/themes/*", "!mainsite/web/assets/themes/.gitignore"
            ],
            cache: [
                "backend/runtime/**/*", "!backend/runtime/.gitignore",
                "console/runtime/**/*", "!console/runtime/.gitignore",
                "frontend/runtime/**/*", "!frontend/runtime/.gitignore",
                "mainsite/runtime/**/*", "!mainsite/runtime/.gitignore"
            ],
            reset_yii: [
                "yii",
                "yii_test",
                "yii_test.bat",
                "backend/config/*-local.php",
                "backend/runtime/**/*", "!backend/runtime/.gitignore",
                "backend/web/index-test.php",
                "backend/web/index.php",
                "common/config/*-local.php",
                "console/config/*-local.php",
                "console/runtime/**/*", "!console/runtime/.gitignore",
                "frontend/config/*-local.php",
                "frontend/runtime/**/*", "!frontend/runtime/.gitignore",
                "frontend/web/index-test.php",
                "frontend/web/index.php",
                "mainsite/config/*-local.php",
                "mainsite/runtime/**/*", "!mainsite/runtime/.gitignore",
                "mainsite/web/index-test.php",
                "mainsite/web/index.php"
            ]
        },
        compress: {
            main: {
                options: {
                    mode: 'tgz',
                    archive: '_backups/backup_' + grunt.template.today("mm-dd-yyyy_h-MM-ss_TT") + '.tar.gz'
                },
                src: ["**/*", "**/.*", "**/.*/**"]
            }
        }
    });

    // Task definition
    grunt.registerTask('build', ['less', 'sass_import', 'sass', 'typescript', 'concat', 'cssmin', 'uglify', 'copy']);
    grunt.registerTask('build:backend', ['less:backend', 'sass_import:backend', 'sass:backend', 'typescript:backend', 'concat:backend', 'cssmin:backend', 'uglify:backend', 'copy:backend']);
    grunt.registerTask('build:frontend', ['less:frontend', 'sass_import:frontend', 'sass:frontend', 'typescript:frontend', 'concat:frontend', 'cssmin:frontend', 'uglify:frontend', 'copy:frontend']);
    grunt.registerTask('build:mainsite', ['less:mainsite', 'sass_import:mainsite', 'sass:mainsite', 'typescript:mainsite', 'concat:mainsite', 'cssmin:mainsite', 'uglify:mainsite', 'copy:mainsite']);

    grunt.registerTask('clean-assets', ['clean:backend', 'clean:frontend', 'clean:mainsite']);

    grunt.registerTask('clear-cache', ['clean:cache']);
    grunt.registerTask('reset-yii', ['clean:reset_yii']);

    grunt.registerTask('version-bump', function(key) {
        key = (typeof key === 'undefined') ? '' : ':' + key;
        grunt.task.run('bump' + key);
    });

    grunt.registerTask('backup', ['compress']);
};
