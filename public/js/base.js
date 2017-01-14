;
(function() {
    'use strict';
    angular.module('xiaohu', ['ui.router','common','user','question'])//引入多个模块
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
                        templateUrl: 'tpl/page/home'//服务器返回的路由地址，返回视图
                    })
                    .state('signup', {
                        url: '/signup',
                        // template:'首页'
                        templateUrl: 'tpl/page/signup'
                    })
                    .state('login', {
                        url: '/login',
                        // template:'首页'
                        templateUrl: 'tpl/page/login'
                    })
                    .state('question',{
                      abstract:true,
                      url:'/question',
                      template:'<div ui-view></div>'//该状态机为抽象路由，不可url访问，但需要为子级提供路由容器
                    })
                    .state('question.add',{
                      url:'/add',
                      templateUrl:'tpl/page/question_add'
                    })
                    .state('404',{
                      url:'/404',
                      templateUrl:'tpl/page/404'
                    })
                ;
                
            }
        ])
        
          ;
        // .controller('TestController',['$scope',function($scope){
        //   $scope.name='zhangsan';
        // }])
    ;
})(); //闭包结束
