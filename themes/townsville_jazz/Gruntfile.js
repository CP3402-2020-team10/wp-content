module.exports = function(grunt) {
    grunt.initConfig({
        sass: {
            // this is the "dev" Sass config used with "grunt watch" command
            dev: {
                options: {
                    style: 'expanded',
                },
                files: {
                    // the first path is the output and the second is the input
                    'style.css': 'sass/style.scss'
                }
            },
            // this is the "production" Sass config used with the "grunt default" command
            dist: {
                options: {
                    style: 'compressed',
                },
                files: {
                    'style.css': 'sass/style.scss'
                }
            }
        },
        // configure the "grunt watch" task
        watch: {
            sass: {
                files: ['sass/*.scss', 'sass/**/*.scss',],
                tasks: ['sass:dev']
            }
        }
    });
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.registerTask('default', ['watch']);
};
