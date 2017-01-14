<!doctype html>
<html lang="en" ng-app='xiaohu'>
<head>
	<meta charset="UTF-8">
	<title>知乎</title>
	<link rel="stylesheet" href="node_modules/normalize-css/normalize.css">
	<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="public/css/app.css">

</head>
<body>
	<!-- 导航条 -->
	<div class="navbar navbar-blue">
		<div class="container">
			<!-- 头部和按钮 -->
			<div class="navbar-header">
				<button type="button" name="button" class="navbar-toggle collapsed"
				data-toggle='collapse'data-target='#collapseNavbar'>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="#" class="navbar-brand">知乎</a>
			</div>
			<!-- 头部和按钮 -->
			<!-- 响应内容 -->
			<div class="collapse navbar-collapse" id="collapseNavbar">
				<form class="navbar-form navbar-left" method="post"
				ng-controller="questionAddController"
				ng-submit="Question.go()">
					<div class="form-group">
						<input type="text" name="keyword" ng-model="Question.new_question.title" class="form-control">
						<button type="submit" name="button" class="btn btn-default">
							<!-- <span class="glyphicon glyphicon-search"></span> -->
							提问
						</button>
					</div>
				</form>
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">首页</a></li>
					<li><a href="#">话题</a></li>
					<li><a href="#">发现</a></li>
					<!-- <li><a href="#">消息</a></li> -->
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if(user_ins()->is_logged_in())

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{session('username')}} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Action</a></li>
								<li><a href="#">Another action</a></li>
								<li><a href="#">Something else here</a></li>
								<li class="divider"></li>
								<li><a href="#">Separated link</a></li>
							</ul>
						</li>
					@else
						<li><a ui-sref='signup'>注册</a></li>
						<li><a ui-sref='login'>登录</a></li>
					@endif
				</ul>

			</div>
			<!-- 响应内容 -->
		</div>
	</div>
	<!-- 导航条 -->

<!-- 	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<h2>最新动态</h2>
				<hr>
				<div class="media-group">

					<div class="media item-content">
					  <a class="media-left vote">
					    <span>投票</span>
					  </a>
					  <div class="media-body item-content-body">
					  	<p class="content-act">某某某赞了这篇文章</p>
					    <h4 class="media-heading content-title">什么时候你觉得读书最有用？</h4>
					    <p class="content-owner">回答者</p>
					    <p class="content-main">
					    	这里问题的描述内容！这里问题的描述内容！
					    	这里问题的描述内容！这里问题的描述内容！
					    	这里问题的描述内容！这里问题的描述内容！
					    	这里问题的描述内容！这里问题的描述内容！
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
					</div>
					<hr>

				</div>
			</div>
			<div class="col-sm-4 ">
				侧边栏
			</div>
		</div>
	</div> -->
	<!-- 视图路由 -->
	<div ui-view></div>

	<script src="node_modules/jquery/dist/jquery.min.js"></script>
	<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="node_modules/angular/angular.min.js"></script>
	<script src="node_modules/angular-ui-router/release/angular-ui-router.min.js"></script>
	<!-- 模块化js -->
	<script src="public/js/base.js"></script>
	<script src="public/js/common.js"></script>
	<script src="public/js/user.js"></script>
	<script src="public/js/question.js"></script>

</body>
</html>
