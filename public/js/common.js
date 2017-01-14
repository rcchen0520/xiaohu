;(function(){
	angular.module('common',[])
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
})();