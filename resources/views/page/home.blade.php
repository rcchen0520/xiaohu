<!--首页模板-->
<div class="container" ng-controller="homeController">
	<div class="row">
		<div class="col-sm-8">
			<h2>最新动态</h2>
			<hr>
			<div class="media-group">

				<div class="media item-content" ng-repeat="item in timeline.data">
				  <a class="media-left vote">
				    <span>投票</span>
				  </a>
				  <div class="media-body item-content-body">
				  	<p class="content-act">用户[:item.user_id:]赞了这篇文章</p>
				    <h4 class="media-heading content-title">[:item.title:]</h4>
				    <p class="content-owner">用户[:item.user_id:]</p>
				    <p class="content-main">
				    	[:item.desc:]
				    </p>
				    <p class="action-btn-group">
				    	<span class="action-btn comment-btn">
				    		<span class="glyphicon glyphicon-comment icon"></span> 评论
				    	</span>
				    	<span class="action-btn comment-btn">
				    		<span class="glyphicon glyphicon-comment icon"></span> 其他
				    	</span>
				    	<span class="action-btn comment-btn">
				    		<span class="glyphicon glyphicon-comment icon"></span> 其他
				    	</span>
				    </p>
				    <div class="comment-block">

				    	<div class="comment-item">
				    		<div class="media">
				    		  <a class="media-left">
				    		    <img src="public/images/userImg.jpg" class="avatar_25">
				    		  </a>
				    		  <div class="media-body">
				    		    <h4 class="media-heading">Media heading</h4>
				    		    <p>问题的评论</p>
				    		  </div>
				    		</div>
				    	</div>
				    	<div class="comment-item">
				    		<div class="media">
				    		  <a class="media-left" href="#">
				    		    <img src="public/images/userImg.jpg" class="avatar_25">
				    		  </a>
				    		  <div class="media-body">
				    		    <h4 class="media-heading">Media heading</h4>
				    		    <p>问题的评论</p>
				    		  </div>
				    		</div>
				    	</div>

				    </div>
				  </div>
				  <hr>
				</div>
				
			</div>
			<!--加载提示-->
			<div class="alert alert-info" ng-if="timeline.pending">正在加载中！请稍等</div>
			<div class="alert alert-info" ng-if="timeline.no_more_data">没有更多数据了！</div>
		</div>
		<div class="col-sm-4 ">
			侧边栏
		</div>
	</div>
</div>