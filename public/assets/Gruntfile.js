module.exports = function (grunt) {
	// Force use of Unix newlines
	grunt.util.linefeed = "\n";

	grunt.initConfig({
		pkg: grunt.file.readJSON("package.json"),

		sass: {
			dist: {
				options: {
					style: "expanded"
				},
				files: {
					"dist/css/bootstrap.5.0.0.css": "dev/scss/bootstrap/bootstrap.scss",
					"dist/css/dashboard-template.css": "dev/scss/custom/dashboard-template.scss",
				}
			}
		},

		postcss: {
			options: {
				map: false, // inline sourcemaps

				processors: [
					require("autoprefixer")(), // add vendor prefixes
					require("cssnano")() // minify the result
				]
			},
			dist: {
				src: "dist/css/custom.css",
				dest: 'dist/css/custom.min.css'
			}
		},

		imagemin: {
			// Task
			dynamic: {
				// Another target
				files: [
					{
						expand: true, // Enable dynamic expansion
						cwd: "images/raw/", // Src matches are relative to this path
						src: ["*.{png,jpg,gif}"], // Actual patterns to match
						dest: "images/" // Destination path prefix
					}
				]
			}
		},

		watch: {
			scripts: {
				files: ["dev/scss/**/*.scss", "dev/es6/**/*.js"],
				tasks: ["sass", "babel", "eslint:build"],
				options: {
					interrupt: true,
					spawn: false
				}
			}
		},

		concat: {
			dev: {
				src: [
					'dist/js/bootstrap.bundle.min.js',
					'dist/js/custom.js'
				],
				dest: 'dist/js/main.js'
			}
		},

		eslint: {
			build: {
				options: {
					configFile: 'dev/es6/eslint.json'
				},
				src: ['dist/js/custom.js']
			},
		},

		babel: {
			options: {
				sourceMap: false,
				presets: ['@babel/preset-env']
			},
			dist: {
				files: {
					"dist/js/custom.js": "dev/es6/custom.js",
					"dist/js/dashboard-template.js": "dev/es6/dashboard-template.js",
					"dist/js/helper.js": "dev/es6/helper.js",
					"dist/js/income.js": "dev/es6/income.js",
					"dist/js/people-filter.js": "dev/es6/people-filter.js",
					"dist/js/person-incomes-filter.js": "dev/es6/person-incomes-filter.js",
					"dist/js/person-transfers-filter.js": "dev/es6/person-transfers-filter.js",
					"dist/js/people-filter-subpages.js": "dev/es6/people-filter-subpages.js",
				}
			}
		},

		uglify: {
			main: {
				files: {
					"dist/js/custom.min.js": "dist/js/custom.js"
				}
			}
		},

		htmllint: {
			all: ["*.html"]
		}

	});

	grunt.registerTask("dev", ["sass", "babel", "eslint:build", "htmllint"]);
	grunt.registerTask("build", ["sass", "babel", "eslint:build", "postcss", "imagemin", "htmllint", "uglify"]);

	grunt.loadNpmTasks("grunt-contrib-sass");
	grunt.loadNpmTasks("grunt-postcss");
	grunt.loadNpmTasks("grunt-contrib-imagemin");
	grunt.loadNpmTasks("grunt-contrib-uglify");
	grunt.loadNpmTasks("grunt-contrib-watch");
	grunt.loadNpmTasks("grunt-contrib-concat");
	grunt.loadNpmTasks("grunt-babel");
	grunt.loadNpmTasks("grunt-eslint");
	grunt.loadNpmTasks("grunt-html");
};
