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
                    .state('home', {
                        url: '/home',
                        // template:'<h1>首页</h1>'
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
                    // .state('404',{
                    //   url:'/404',
                    //   templateUrl:'404.tpl'
                    // })
                ;
                $urlRouterProvider.otherwise('/404');
            }
        ])
        .service('userService', ['$http', function($http) {

            var me = this;
            me.signup_data = {}; //就算没创建也会为我们递归创建
            me.signup = function() {
                    console.log("signup");
                    console.log(me.signup_data);
                },
                me.userName_exist = function() {

                    $http.post('/api/user/exists', {
                            username: me.signup_data.username
                        })
                        .then(function(r) {
                            console.log("r" + r);
                        }, function(e) {
                            console.log("e" + e);
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
                }, function(n, o) {//检测用户名的不同（新旧数据）
                    if (n.username != o.username) {
                        userService.userName_exist();//检测用户是否注册
                    }
                }, true);//深度递归检测
            }
        ])
        // .controller('TestController',['$scope',function($scope){
        //   $scope.name='zhangsan';
        // }])
    ;
})(); //闭包结束
