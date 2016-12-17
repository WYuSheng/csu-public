  <div class="col-md-4" style="padding:0 35px 0 0;">
    <h3 class="homepage-title" style="margin-bottom: 28px;">
      <?= T('实验室动态') ?>
      <small class="pull-right">
        <a href="article/list/<?= \Gini\ORM\Article::TYPE_LAB?>"><?= T('更多>>') ?></a>
      </small>
    </h3>
    <?php foreach ($labArticles as $article) :?>
      <a href="article/content/<?= $article->id?>" style="text-decoration: none;">
        <p class="title1"><?= T($article->title) ?></p>
      </a>
    <?php endforeach; ?>
  </div>
  <div class="col-md-4">
    <h3 class="homepage-title" style="margin-bottom: 28px;"><?= T('仪器查询') ?></h3>
    <form role="search" method="post" action="equipment/list">
      <p class="title2"><?= T('类型查询：') ?></p>
      <div class="input-group">
        <div class="input-group-btn" style="width:80px">
          <select name="search" class="form-control input-login form-blue" style="border: 0px;outline: 1px solid #2b4584;height: 47px;">
            <option value="name"><?= T('名称') ?></option>
            <option value="tag"><?= T('分类') ?></option>
          </select>
        </div><!-- /btn-group -->
        <input type="text" class="form-control form-blue" name="searchtext" placeholder="<?= T('请输入仪器名称');?>">
        <span class="input-group-btn">
          <button class="btn btn-default form-blue-button" type="submit"><span class="glyphicon glyphicon-search"></span></button>
        </span>
      </div><!-- /input-group -->
    </form>
    <form role="search" method="post" action="equipment/list">
      <p class="title2" style="margin-top:18px"><?= T('智能搜索：') ?></p>
      <div class="input-group">
        <input type="text" class="form-control form-blue" name="eq_name" placeholder="<?= T('请输入仪器名称');?>">
        <span class="input-group-btn">
          <button class="btn btn-default form-blue-button" type="submit"><span class="glyphicon glyphicon-search"></span></button>
        </span>
      </div><!-- /input-group -->
    </form>
  </div>
  <div class="col-md-4" style="padding:0 0 0 35px;">
    <h3 class="homepage-title">
      <?= T('预约登录') ?>
    </h3>
    <form class="form-login" style="margin: 0;" role="form" action="<?= \Gini\Config::get('server.login')?>">
      <div class="form-group">
        <input type="text" name="token" class="form-control input-login" placeholder="<?= T('用户名') ?>">
      </div>
      <div class="form-group" style="display: none;">
        <select name="token_backend" class="form-control input-login">
          <option value="database"><?= T('普通用户') ?></option>
        </select>
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control input-login" placeholder="<?= T('密码') ?>">
      </div>
      <div class="form-group" style="margin-bottom: 7px;">
        <input type="submit" name="submit" class="btn btn-default submit-login" value="<?= T('登录') ?>" />
        <a href="<?= \Gini\Config::get('server.signup')?>" style="line-height: 31px;" class="btn btn-default submit-login" ><?= T('注册') ?></a>
      </div>
      <div class="form-group">
        <a href="<?= \Gini\Config::get('server.caslogin')?>" style="line-height: 31px;width: 99%;" class="btn btn-default submit-login" ><?= T('校内用户登录') ?></a>
      </div>
    </form>
  </div>