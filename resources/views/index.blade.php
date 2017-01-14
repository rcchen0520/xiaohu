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

	<script type="text/ng-template" id='signup.tpl'>
		<!-- 注册模板 -->
		<div class="container" ng-controller="signupController">
			<div class="panel panel-default">
				<div class="panel-heading">注册</div>
				<div class="panel-body">
					<form class="form-horizontal" name="signupForm" ng-submit="User.signup()">
						<div class="form-group">
							<div>测试：[:User.signup_data:]</div>
							<label class="col-sm-2 control-label">用户名：</label>
		    			<div class="col-sm-8">
								<input type="text" name="username" class="form-control"
								placeholder="请输入用户名"
								ng-model="User.signup_data.username"
								ng-model-options="{updateOn:'blur'}"
								ng-minlength="6"
								ng-maxlength="16"
								required
								>
								<div class="help-block" ng-if="signupForm.username.$touched">
									<div class="text-danger" ng-if="signupForm.username.$error.required">
										用户名为必填项!
									</div>
									<div class="text-danger" ng-if="signupForm.username.$error.minlength||signupForm.username.$error.maxlength">
										用户名长度必须为6-16位!
									</div>
									<div class="text-danger" ng-if="User.signup_username_exists">
										用户名已存在！
									</div>
								</div>
		    			</div>

		  			</div>
		  			<div class="form-group">
		    			<label class="col-sm-2 control-label">密码：</label>
		    			<div class="col-sm-8">
		      			<input type="password" name="password" class="form-control"
								placeholder="请输入密码"
								ng-model="User.signup_data.password"
								ng-minlength="6"
								ng-maxlength="16"
								required
								ng-model-options="{updateOn:'blur'}"
								>
								<div class="help-block" ng-if="signupForm.password.$touched">
									<div class="text-danger" ng-if="signupForm.password.$error.required">
										密码为必填项!
									</div>
									<div class="text-danger" ng-if="signupForm.password.$error.minlength||signupForm.username.$error.maxlength">
										密码长度必须为6-16位!
									</div>
								</div>
		    			</div>
		  			</div>
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<button type="submit" name="button" class="btn btn-primary"
								ng-disabled="signupForm.$invalid">注册</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- 注册模板 -->
	</script>

	<script type="text/ng-template" id='login.tpl'>
		<!-- 登录模板 -->
		<div class="container" ng-controller="loginController">
			<div class="panel panel-default">
				<div class="panel-heading">登录</div>
				<div class="panel-body">
					<form class="form-horizontal" name="loginForm" ng-submit="User.login()">
						<div class="form-group">
							<div>测试：[:User.login_data:]</div>
							<!-- ng-model-options="{updateOn:'blur'}" -->
							<label class="col-sm-2 control-label">用户名：</label>
		    			<div class="col-sm-8">
								<input type="text" name="username" class="form-control"
								placeholder="请输入用户名"
								ng-model="User.login_data.username"
								ng-model-options="{debounce:500}"
								ng-minlength="6"
								ng-maxlength="16"
								required
								>
								<div class="help-block" ng-if="loginForm.username.$touched">
									<div class="text-danger" ng-if="loginForm.username.$error.required">
										用户名为必填项!
									</div>
									<div class="text-danger" ng-if="loginForm.username.$error.minlength||
									loginForm.username.$error.maxlength">
										用户名长度在6-12位之间！
									</div>
								</div>
		    			</div>

		  			</div>
		  			<div class="form-group">
		    			<label class="col-sm-2 control-label">密码：</label>
		    			<div class="col-sm-8">
		      			<input type="password" name="password" class="form-control"
								placeholder="请输入密码"
								ng-model="User.login_data.password"
								ng-minlength="6"
								ng-maxlength="16"
								required
								ng-model-options="{updateOn:'blur'}"
								>
								<div class="help-block" ng-if="loginForm.password.$touched">
									<div class="text-danger" ng-if="loginForm.password.$error.required">
										密码为必填项!
									</div>
									<div class="text-danger" ng-if="loginForm.password.$error.minlength||
									loginForm.password.$error.maxlength">
										用户名长度在6-12位之间！
									</div>
									<div class="text-danger" ng-if="User.login_failed">
										用户名或密码错误！
									</div>
								</div>
		    			</div>

		  			</div>
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<button type="submit" name="button" class="btn btn-success"
								ng-disabled="loginForm.$invalid">登录</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- 登录模板 -->
	</script>

	<script type="text/ng-template" id='question.add.tpl'>
		<!-- 提问 -->
		<div class="container" ng-controller="questionAddController">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">添加提问</div>
						<div class="panel-body">
							<form class="form-horizontal" name="questionAddForm" ng-submit="Question.add()">
								<div class="form-group">
									<label class="col-sm-2 control-label">标题：</label>
				    			<div class="col-sm-8">
										<input type="text" name="question_title" class="form-control"
										placeholder="请输入问题标题"
										required
										ng-minlength="5"
										ng-maxlength="255"
										ng-model="Question.new_question.title"
										>
										<div class="help-block" ng-if="questionAddForm.question_title.$touched">
											<div class="text-danger" ng-if="questionAddForm.question_title.$error.required">
												问题标题不能为空！
											</div>
											<div class="text-danger" ng-if="questionAddForm.question_title.$error.minlength||
											questionAddForm.question_title.$error.maxlength">
												问题标题不能少于5位！
											</div>
										</div>
				    			</div>

								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">描述：</label>
									<div class="col-sm-8">
										<textarea class="form-control" rows="3"
											name="question_desc"
											ng-model="Question.new_question.desc"
										></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn btn-primary" ng-disabled="questionAddForm.$invalid">提问</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- 提问 -->
	</script>

	<script type="text/ng-template" id='404.tpl'>
		this is 404 page
		<a ui-sref="home">home</a>
		<a ui-sref="login">login</a>
	</script>
	<script type="text/ng-template" id='home.tpl'>
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
	</script>

	<script src="node_modules/jquery/dist/jquery.min.js"></script>
	<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="node_modules/angular/angular.min.js"></script>
	<script src="node_modules/angular-ui-router/release/angular-ui-router.min.js"></script>
	<script src="public/js/base.js"></script>

</body>
</html>
