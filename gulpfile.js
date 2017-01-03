// var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

// elixir(function(mix) {
//     mix.sass('app.scss');
// });
// 引入依赖模块
var gulp=require('gulp'),

    // clean=require('gulp-clean'),
    // spritesmith=require('gulp.spritesmith'),
    // imagemin=require('gulp-imagemin'),
    // cache=require('gulp-cache'),

    // cssmin=require('gulp-minify-css'),

    // concat=require('gulp-concat'),
    // uglify=require('gulp-uglify'),

    // rename=require('gulp-rename'),
    // sequence=require('run-sequence'),
    // debug=require('gulp-debug'),
    connect=require('gulp-connect'),
    livereload=require('gulp-livereload'),
    // autoprefixer=require('gulp-autoprefixer'),
    rubysass=require('gulp-ruby-sass')
    // fileinclude=require('gulp-file-include')

    ;


// gulp.task('default',['clean','build'],function(){
//     // gulp.watch(['src/*.html','src/scss/*.scss','src/css/*.css','src/js/*.js','src/images/*.*']);
// });
gulp.task('default',function(){
    // gulp.watch(['src/*.html','src/scss/*.scss','src/css/*.css','src/js/*.js','src/images/*.*']);
});
//web服务
gulp.task('webserver',function(){
  connect.server({
    livereload:true,
    port: 80,
    host: 'localhost/xiaohu'
  })
});
//监听文件
gulp.task('watch',['webserver'],function(){
    livereload.listen();
    gulp.watch('resources/assets/sass/*.scss',['sass']);
    // gulp.watch('src/pages/*',['fileinclude']);
    gulp.watch(['resources/views/*.html'],function(file){
      livereload.changed(file.path);
    });
});
//合成雪碧图
// gulp.task("sprite",function(){
//   return gulp.src("src/images/icon/*.png")
//   .pipe(spritesmith({
//     imgName:"images/sprite.png",
//     cssName:"css/sprite.css",
//     padding:5,
//     algorithm:"binary-tree",
//     cssTemplate: function (data) {
//               var arr=[];
//               data.sprites.forEach(function (sprite) {
//                   arr.push(".icon-"+sprite.name+
//                   "{" +
//                   "display:inline-block;"+
//                   "background-image: url('"+sprite.escaped_image+"');"+
//                   "background-repeat: no-rep;"+
//                   "background-position: "+sprite.px.offset_x+" "+sprite.px.offset_y+";"+
//                   "width:"+sprite.px.width+";"+
//                   "height:"+sprite.px.height+";"+
//                   "}\n");
//               });
//               return arr.join("");
//           }
//   }))
//   .pipe(gulp.dest('src/'));
// });

//图片压缩
// gulp.task('imagesmin',function(){
//   gulp.src('src/images/*.*')
//       .pipe(debug({title:'imagesmin'}))
//       // .pipe(imagemin())压缩图片
//       //只压缩修改过的图片
//       .pipe(cache(imagemin()))
//       .pipe(gulp.dest('dist/images/'));
// });
//单一编译sass
gulp.task('sass', function () {
    return rubysass('resources/assets/sass/app.scss')
        .on('error', function (err) {
            console.error('Error!', err.message);
        })
        // .pipe(autoprefixer({
        //       browsers: ['last 2 version', 'safari 5', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'],
        //       cascade: true, //是否美化属性值 默认：true 像这样：
        //       //-webkit-transform: rotate(45deg);
        //       //        transform: rotate(45deg);
        //       remove:true //是否去掉不必要的前缀 默认：true
        //   }))
        .pipe(gulp.dest('public/css'));
        // .pipe(livereload());
});
// Styles任务
/*
gulp.task('styles',function() {
    gulp.src('src/css')
    //编译sass
    return gulp.src('src/scss/main.scss')
    .pipe(rubysass({sourcemap: true, sourcemapPath: '../scss'}).on('error',sass.logError))
    rubysass('src/scss/main.scss')
        .on('error', function (err) {
            console.error('Error!', err.message);
        })
    //添加前缀
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    //保存未压缩文件到我们指定的目录下面
    .pipe(gulp.dest('src/css'))
    //给文件添加.min后缀
    // .pipe(rename({ suffix: '.min' }))
    //压缩样式文件
    .pipe(cssmin())
    //输出压缩文件到指定目录
    .pipe(gulp.dest('dist/css'));
    //提醒任务完成
    // .pipe(notify({ message: 'Styles task complete' }));
});
*/
//自动添加前缀
// gulp.task('autoprefixer',function(){
//   gulp.src('src/scss/*.scss')
//       .pipe(autoprefixer({
//             browsers: ['last 2 version', 'safari 5', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'],
//             cascade: true, //是否美化属性值 默认：true 像这样：
//             //-webkit-transform: rotate(45deg);
//             //        transform: rotate(45deg);
//             remove:true //是否去掉不必要的前缀 默认：true
//         }))
//         .pipe(gulp.dest('src/scss/main.scss'));
// });
//压缩css
// gulp.task('cssmin',function(){
//   gulp.src('src/css/*.css')
//       .pipe(debug({title:'cssmin'}))
//       .pipe(cssmin())
//       .pipe(gulp.dest('dist/css/'));
// });
//合并、压缩js
// gulp.task('script',function(){
//   gulp.src('src/js/*.js')
//       .pipe(debug({title:'script'}))
//       .pipe(concat('all.js'))
//       // .pipe(gulp.dest('./dist/js'))
//       // .pipe(rename('all.min.js'))
//       .pipe(uglify())
//       .pipe(gulp.dest('./dist/js'));
// });
//html压缩

//清除dist文件夹下的所有文件
// gulp.task('clean',function(){
//   gulp.src('dist/*')
//   .pipe(debug({title:'clean'}))
//   .pipe(clean());
// });
// gulp.task('fileinclude', function() {
//     gulp.src(['src/pages/**.html','!src/pages/template.html'])
//         .pipe(fileinclude({
//           prefix: '@@',
//           basepath: '@file'
//         }))
//     .pipe(gulp.dest('src'));
// });
// gulp.task('copyfile',function(){
//   // gulp.src(['src/**/*'])
//   gulp.src('src/font-awesome/**/*.*')
//       .pipe(debug({title:'copyfile'}))
//   // .pipe(print())
//   .pipe(gulp.dest('dist/font-awesome'));
// });
// 复制html文件
// gulp.task('copy',function(){
//   // gulp.src(['src/**/*'])
//   gulp.src('src/*.html')
//       .pipe(debug({title:'copy'}))
//   // .pipe(print())
//   .pipe(gulp.dest('dist'));
// });

//构建工程,按顺序并行
gulp.task('build',function(done){
  // sequence('imagesmin','autoprefixer','sass','cssmin','script','fileinclude','copyfile','copy',done);
  // sequence('sass',done);
});
