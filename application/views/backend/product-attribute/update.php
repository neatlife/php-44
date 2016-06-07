<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>SHOP 管理中心 - 属性管理 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="backend/styles/general.css" rel="stylesheet" type="text/css" />
  <link href="backend/styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>

<h1>
<span class="action-span"><a href="index.php?p=admin&c=attribute&a=index">商品属性</a></span>
<span class="action-span1"><a href="index.php?act=main">SHOP 管理中心</a> </span><span id="search_id" class="action-span1"> - 添加属性 </span>
<div style="clear:both"></div>
</h1>

<div class="main-div">
  <form action="index.php?controller=backend/ProductAttribute&action=update&id=<?php echo $productAttribute['id'] ?>" method="post" name="theForm">
  <table width="100%" id="general-table">
      <tbody><tr>
        <td class="label">属性名称：</td>
        <td>
          <input type="text" name="attr_name" value="<?php echo $productAttribute['name'] ?>" size="30">
          <span class="require-field">*</span>        </td>
      </tr>
      <tr>
        <td class="label">所属商品类型：</td>
        <td>
          <select name="type_id">
          <option value="0">请选择...</option>
            <?php foreach($productAttributeCategorys as $productAttributeCategory): ?>
              <option <?php if($productAttributeCategory['id'] == $productAttribute['category_id']): ?>selected<?php endif; ?> value="<?php echo $productAttributeCategory['id'] ?>"><?php echo $productAttributeCategory['name'] ?></option>
            <?php endforeach; ?>
            </select> <span class="require-field">*</span>        </td>
      </tr>
      <tr>
        <td class="label">该属性值的录入方式：</td>
        <td>
          <input type="radio" <?php if ($productAttribute['input_value_type'] == '2'): ?>checked<?php endif; ?> name="attr_input_type" value="2" onclick="radioClicked(0)">
          手工录入
          <input type="radio" <?php if ($productAttribute['input_value_type'] == '1'): ?>checked<?php endif; ?> name="attr_input_type" value="1" onclick="radioClicked(1)">
            从下面的列表中选择（一行代表一个可选值）
        </td>
      </tr>
      <tr>
        <td class="label">可选值列表：</td>
        <td>
          <textarea name="attr_value" cols="30" rows="5" disabled=""><?php echo $productAttribute['value'] ?></textarea>
        </td>
      </tr>
      <tr>
        <td colspan="2">
        <div class="button-div">
          <input type="submit" value=" 确定 " class="button">
          <input type="reset" value=" 重置 " class="button">
        </div>
        </td>
      </tr>
      </tbody></table>
  </form>
</div>

<div id="footer">
	版权所有 &copy; 2012-2013 传智播客 - PHP培训 - </div>
</div>
<script type="text/javascript">
/**
 * 点击类型按钮时切换选项的禁用状态
 */
function radioClicked(n)
{
  document.forms['theForm'].elements["attr_value"].disabled = n > 0 ? false : true;
}

window.onload = function() {
  if (document.forms['theForm'].elements['attr_input_type'][1].checked) {
    document.forms['theForm'].elements["attr_value"].disabled = false;
  }
}

</script>
</body>
</html>