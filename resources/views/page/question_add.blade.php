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