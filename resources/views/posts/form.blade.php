<form name="myForm" ng-submit="save()" novalidate>
    <div class="form-group"  ng-class="{ 'has-error' : myForm.title.$dirty && myForm.title.$invalid }">
        <label for="title" class="control-label">标题:</label>
        <input type="text" class="form-control" name="title" id="title" required ng-model="post.title">
        <p ng-show="myForm.title.$dirty && myForm.title.$invalid" class="help-block">不能为空</p>
    </div>
    <div class="form-group"  ng-class="{ 'has-error' : myForm.keyword.$dirty && myForm.keyword.$invalid }">
        <label for="keyword" class="control-label">关键字:</label>
        <input type="text" class="form-control" name="keyword" id="keyword" required ng-model="post.keyword">
        <p ng-show="myForm.keyword.$dirty && myForm.keyword.$invalid" class="help-block">不能为空</p>
    </div>
    <div class="form-group"  ng-class="{ 'has-error' : myForm.desc.$dirty && myForm.desc.$invalid }">
        <label for="desc" class="control-label">描述:</label>
        <input type="text" class="form-control" name="desc" id="desc" required ng-model="post.desc">
        <p ng-show="myForm.desc.$dirty && myForm.desc.$invalid" class="help-block">不能为空</p>
    </div>
    <div class="form-group"  ng-class="{ 'has-error' : myForm.cate_id.$dirty && myForm.cate_id.$invalid }">
        <label for="cate_id" class="control-label">所属分类:</label>
        <select chosen class="form-control" name="cate_id" id="cate_id"
                placeholder-text-single="'请选择分类'" no-results-text="'未找到'"
                required ng-model="post.cate_id"
                ng-options="s.id as s.name for s in data.categories">
            <option value=""></option>
        </select>
        <p ng-show="myForm.cate_id.$dirty && myForm.cate_id.$invalid" class="help-block">不能为空</p>
    </div>
    <div class="form-group"  ng-class="{ 'has-error' : myForm.tags.$dirty && myForm.tags.$invalid }">
        <label for="tags" class="control-label">所属TAG:</label>
        <select multiple chosen class="form-control" name="tags[]" id="tags"
                placeholder-text-multiple="'请选择TAG'" no-results-text="'未找到'"
                required ng-model="post.tags" ng-options="s.id as s.name for s in data.tags">
            <option value=""></option>
        </select>
        <p ng-show="myForm.tags.$dirty && myForm.tags.$invalid" class="help-block">不能为空</p>
    </div>
    <div class="form-group"  ng-class="{ 'has-error' : myForm.slug.$dirty && myForm.slug.$invalid }">
        <label for="slug" class="control-label">Slug:</label>
        <input type="text" class="form-control" name="slug" id="slug" required ng-model="post.slug">
        <p ng-show="myForm.slug.$dirty && myForm.slug.$invalid" class="help-block">不能为空</p>
    </div>
    <div class="form-group"  ng-class="{ 'has-error' : myForm.pic.$dirty && myForm.pic.$invalid }">
        <label for="pic" class="control-label">头图:</label>
        <input type="file" class="form-control" name="pic" id="pic" ng-model="post.pic">
        {{--<p ng-show="myForm.pic.$dirty && myForm.pic.$invalid" class="help-block">不能为空</p>--}}
    </div>
    <div class="form-group"  ng-class="{ 'has-error' : myForm.content.$dirty && myForm.content.$invalid }">
        <label for="content" class="control-label">内容:</label>
        <textarea name="content" id="editor1" rows="10" cols="80" ng-model="post.content" required>
        </textarea>
        <p ng-show="myForm.content.$dirty && myForm.content.$invalid" class="help-block">不能为空</p>
    </div>

    <button type="submit" class="btn btn-primary btn-block" ng-disabled="myForm.$invalid">保存</button>
</form>
