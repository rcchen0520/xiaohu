;(function(){
	'use strict';
	angular.module('user',[])
	//user实例：service和controller
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
	;
})();