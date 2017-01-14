;
(function() {
    'use strict';
    angular.module('xiaohu', ['ui.router'])
        .config([ //配置解析器，路由控制
            "$interpolateProvider",
            "$stateProvider",
            "$urlRouterProvider",
            function($interpolateProvider,
                $stateProvider,
                $urlRouterProvider) {
                // 修改解析器，防止与其他语言解析器冲突,注入$interpolateProvider
                $interpolateProvider.startSymbol('[:');
                $interpolateProvider.endSymbol(':]');
                //路由，配合html中的指令ui-view
                $urlRouterProvider.when("", "/home");
                // $urlRouterProvider.otherwise("/404");

                $stateProvider
                    // .state('/', {
                    //     url: '/',
                    //     template:'首页'
                    // })
                    .state('home', {
                        url: '/home',
                        // template:'首页'
                        templateUrl: 'home.tpl'
                    })
                    .state('signup', {
                        url: '/signup',
                        // template:'首页'
                        templateUrl: 'signup.tpl'
                    })
                    .state('login', {
                        url: '/login',
                        // template:'首页'
                        templateUrl: 'login.tpl'
                    })
                    .state('question',{
                      abstract:true,
                      url:'/question',
                      template:'<div ui-view></div>'//该状态机为抽象路由，不可url访问，但需要为子级提供路由容器
                    })
                    .state('question.add',{
                      url:'/add',
                      templateUrl:'question.add.tpl'
                    })
                    .state('404',{
                      url:'/404',
                      templateUrl:'404.tpl'
                    })
                ;
                
            }
        ])
        .service('userService', ['$http', '$state', function($http, $state) {

            var me = this;
            me.signup_data = {}; //注册表单数据，就算没创建也会为我们递归创建
            me.login_data={};//登录表单数据
            //用户注册
            me.signup = function() {
              $http.post('/api/signup', me.signup_data)
                  .then(function(r) {
                    console.log(r.data.status);
                      if (r.data.status) { //r.data是angularjs获取到的对象
                          me.signup_data = {};
                          $state.go('login');
                      }
                  }, function(e) {
                    console.log("e" +JSON.parse(e)+eval("("+e+")"));
                  });
            },
            //检测用户名是否已存在
            me.userName_exists = function() {
              $http.post('/api/user/exist', {
                username: me.signup_data.username
              })
              .then(function(r) {

                if(r.data.status&&r.data.data.count){
                  me.signup_username_exists=true;
                }else{
                  me.signup_username_exists=false;
                }
                // console.log("r" + r);
              }, function(e) {
                console.log("e" + e);
              });
            },
            //用户登录
            me.login=function(){
              $http.post('/api/login',me.login_data)
              .then(function(r){
                console.log(r.data);
                if(r.data.status){
                  me.login_data={};//登录成功之后清空数据，安全问题！
                  // console.log("登录成功");
                  $state.go('home');
                }else{
                  me.login_failed=true;//登录失败标志
                }
              },function(e){
                console.log(e);
              });
            }
        }])
        .controller('signupController', [
            '$scope',
            'userService',
            function($scope, userService) {
                $scope.User = userService;
                // 监控新旧数据，检测用户是否已经注册
                $scope.$watch(function() {
                    return userService.signup_data;
                }, function(n, o) { //检测用户名的不同（新旧数据）
                    if (n.username != o.username) {
                        userService.userName_exists(); //检测用户是否注册
                        console.log("watch");
                    }
                }, true); //深度递归检测
            }
        ])
        .controller('loginController',[
          '$scope','userService',
          function($scope,userService){
            $scope.User=userService;
        }])
        //提问
        .service('questionService',['$http','$state',function($http,$state){
          var me=this;
          me.new_question={};
          me.go=function(){
            $state.go('question.add');
          },
          me.add=function(){
            $http.post('/api/question/add',me.new_question)
            .then(function(r){
              if(r.data.status){
                me.new_question={};//清空问题
                $state.go('home');
              }
            },function(e){
              console.log(e);
            });
          }
        }])
        .controller('questionAddController',[
          '$scope',
          'questionService'
          ,function($scope,questionService){
            $scope.Question=questionService;
          }
        ])
        .service('timelineService',[
          '$http',
          function($http){
            var me=this;
            me.data=[];//首页空数组数据
            me.current_page=1;//当前页
            
            me.get=function(conf){//传参？
              //当前正在忙，直接return 
              if(me.pending){
                return ;
              }
              me.pending=true;//表示当前正在忙，不发送请求

              conf=conf || {page:me.current_page};//页码

              $http.post('/api/timeline',conf)
              .then(function(r){
                if(r.data.status){
                  if(r.data.data.length){
                    me.data=me.data.concat(r.data.data);
                    me.current_page++;//请求成功页数+1
                  }else{
                    me.no_more_data=true;//没有更多数据了
                  }
                  
                }else{
                  console.log("network error");
                }
              },function(e){
                console.log(e);
              })
              .finally(function(){
                me.pending=false;//可以请求
              });
            }
          }])
        .controller('homeController',[
          '$scope','timelineService',
          function($scope,timelineService){
            $scope.timeline=timelineService;
            $scope.timeline.get();
            // 窗口滚动自动加载信息
            var $win=$(window);

            $win.on('scroll',function(){
              
              if($win.scrollTop()-($(document).height()-$win.height())>-30){
                $scope.timeline.get();
              }
            });
        }])
          ;
        // .controller('TestController',['$scope',function($scope){
        //   $scope.name='zhangsan';
        // }])
    ;
})(); //闭包结束
