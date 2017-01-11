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

                $stateProvider
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
                // $urlRouterProvider.otherwise('/404');
            }
        ])
        .service('userService', ['$http', '$state', function($http, $state) {

            var me = this;
            me.signup_data = {}; //就算没创建也会为我们递归创建
            me.login_data={};
            me.signup = function() {
              $http.post('/xiaohu/api/signup', me.signup_data)
                  .then(function(r) {
                    console.log(r.data);
                      if (r.data.status) { //r.data是angularjs获取到的对象
                          me.signup_data = {};
                          $state.go('login');
                      }
                  }, function(e) {
                    console.log("e" +JSON.parse(e)+eval("("+e+")"));
                  });
            },
            me.userName_exist = function() { //后台API未完成
              $http.post('/api/user/exists', {
                username: me.signup_data.username
              })
              .then(function(r) {
                console.log("r" + r);
              }, function(e) {
                console.log("e" + e);
              });
            },
            me.login=function(){
              $http.post('/api/login',me.login_data)
              .then(function(r){
                if(r.data.status){
                  location.href='/';
                }else{
                  me.login_failed=true;//登录失败标志
                }
              },function(e){
                console.log("e"+e);
              });
            }
        }])
        .controller('signupController', [
            '$scope',
            'userService',
            function($scope, userService) {
                $scope.User = userService;
                $scope.$watch('User', function() {
                    return userService.signup_data;
                }, function(n, o) { //检测用户名的不同（新旧数据）
                    if (n.username != o.username) {
                        userService.userName_exist(); //检测用户是否注册
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
        .service('questionService',['$http',function($http){
          var me=this;

        }])
        .controller('questionAddController',[
          '$scope',
          'questionService'
          ,function($scope,questionService){
            $scope.Question=questionService;
          }
        ])
          ;
        // .controller('TestController',['$scope',function($scope){
        //   $scope.name='zhangsan';
        // }])
    ;
})(); //闭包结束
