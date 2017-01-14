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