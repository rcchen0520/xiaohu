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