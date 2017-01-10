<!doctype html>
<html lang="en" ng-app='xiaohu'>
<head>
	<meta charset="UTF-8">
	<title>晓乎</title>
	<link rel="stylesheet" href="node_modules/normalize-css/normalize.css">
	<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="public/css/app.css">

</head>
<body>
	<!-- 导航条 -->
	<div class="navbar navbar-default">
		<div class="container">
			<!-- 头部和按钮 -->
			<div class="navbar-header">
				<button type="button" name="button" class="navbar-toggle collapsed"
				data-toggle='collapse'data-target='#collapseNavbar'>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="#" class="navbar-brand">晓乎</a>
			</div>
			<!-- 头部和按钮 -->
			<!-- 响应内容 -->
			<div class="collapse navbar-collapse" id="collapseNavbar">
				<form class="navbar-form navbar-left" method="post">
					<div class="form-group">
						<input type="text" name="keyword" class="form-control">
						<button type="submit" name="button" class="btn btn-default">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</div>
				</form>
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">首页</a></li>
					<li><a href="#">话题</a></li>
					<li><a href="#">发现</a></li>
					<li><a href="#">消息</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
        	<li><a ui-sref='signup'>注册</a></li>
        	<li><a ui-sref='login'>登录</a></li>
        	<li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">用户 <span class="caret"></span></a>
          	<ul class="dropdown-menu" role="menu">
            	<li><a href="#">Action</a></li>
            	<li><a href="#">Another action</a></li>
            	<li><a href="#">Something else here</a></li>
            	<li class="divider"></li>
            	<li><a href="#">Separated link</a></li>
          	</ul>
        	</li>
      	</ul>
			</div>
			<!-- 响应内容 -->
		</div>
	</div>
	<!-- 导航条 -->

	<div class="container">
		<div class="row">
			<div class="col-md-8">
				col-md-8
			</div>
			<div class="col-md-4">
				col-md4
			</div>
		</div>
	</div>
	<!-- 视图路由 -->
	<div ui-view></div>

	<script type="text/ng-template" id='home.tpl'>
		this is home page
		<a ui-sref="home">home</a>
		<a ui-sref="login">login</a>

	</script>
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
		    			<div class="col-sm-10">
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
								</div>
		    			</div>

		  			</div>
		  			<div class="form-group">
		    			<label class="col-sm-2 control-label">密码：</label>
		    			<div class="col-sm-10">
		      			<input type="password" name="signupPassword" class="form-control"
								placeholder="请输入密码"
								ng-model="User.signup_data.password"
								ng-minlength="6"
								ng-maxlength="16"
								required
								ng-model-options="{updateOn:'blur'}"
								>
		    			</div>
		  			</div>
						<div class="row">
							<div class="col-sm-10 col-sm-offset-2">
								<button type="submit" name="button" class="btn btn-primary"
								>注册</button>
							</div>
							<!-- ng-disabled="signupForm.$invalid" -->
						</div>
					</form>
				</div>
			</div>
		</div>

	</script>

	<script type="text/ng-template" id='login.tpl'>
		this is login page
		<a ui-sref="home">home</a>
		<a ui-sref="login">login</a>
	</script>

	<script type="text/ng-template" id='404.tpl'>
		this is 404 page
		<a ui-sref="home">home</a>
		<a ui-sref="login">login</a>
	</script>

	<script src="node_modules/jquery/dist/jquery.min.js"></script>
	<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="node_modules/angular/angular.min.js"></script>
	<script src="node_modules/angular-ui-router/release/angular-ui-router.min.js"></script>
	<script src="public/js/base.js"></script>

</body>
</html>
