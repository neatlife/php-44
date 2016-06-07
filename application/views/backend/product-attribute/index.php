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
<span class="action-span"><a href="index.php?controller=backend/ProductAttribute&action=create">添加属性</a></span>
<span class="action-span1"><a href="index.php?act=main">SHOP 管理中心</a> </span><span id="search_id" class="action-span1"> - 商品属性 </span>
<div style="clear:both"></div>
</h1>

<div class="form-div">
  <form action="" name="searchForm">
    <img src="backend/images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH">
    按商品类型显示：
    <select name="goods_type" onchange="searchAttr(this.value)">
      <option value="0">所有商品类型</option>
      <?php foreach($productAttributeCategorys as $productAttributeCategory): ?>
        <option <?php if($categoryId == $productAttributeCategory['id']): ?>selected<?php endif; ?> value="<?php echo $productAttributeCategory['id'] ?>"><?php echo $productAttributeCategory['name'] ?></option>
      <?php endforeach; ?>
    </select>
  </form>
</div>

<form method="post" action="attribute.php?act=batch" name="listForm">
<div class="list-div" id="listDiv">

  <table cellpadding="3" cellspacing="1">
    <tbody>
		<tr>
			<th><input onclick="listTable.selectAll(this, &quot;checkboxes[]&quot;)" type="checkbox">编号 </th>
			<th>属性名称</th>
			<th>商品类型</th>
			<th>属性值的录入方式</th>
			<th>可选值列表</th>
			<th>操作</th>
		</tr>
      <?php foreach($productAttributes as $productAttribute): ?>
        <tr>
    			<td nowrap="true" valign="top"><span><input value="1" name="checkboxes[]" type="checkbox">1</span></td>
    			<td class="first-cell" nowrap="true" valign="top"><span onclick="listTable.edit(this, 'edit_attr_name', 1)"><?php echo $productAttribute['name'] ?></span></td>
    			<td nowrap="true" valign="top"><span><?php echo $productAttribute['category_name'] ?></span></td>
    			<td nowrap="true" valign="top"><span>
            <?php if ($productAttribute['input_value_type'] == 1):?>
              下拉选择
            <?php elseif ($productAttribute['input_value_type'] == 2): ?>
              手工录入
            <?php endif; ?>
          </span></td>
    			<td valign="top"><span><?php echo $productAttribute['value'] ?></span></td>
    			<td align="center" nowrap="true" valign="top">
    				<a href="index.php?controller=backend/ProductAttribute&action=update&id=<?php echo $productAttribute['id'] ?>" title="编辑"><img src="backend/images/icon_edit.gif" border="0" height="16" width="16"></a>
    				<a href="index.php?controller=backend/ProductAttribute&action=delete&id=<?php echo $productAttribute['id'] ?>" onclick="removeRow(1)" title="移除"><img src="backend/images/icon_drop.gif" border="0" height="16" width="16"></a>
    			</td>
    		</tr>
      <?php endforeach; ?>
      </tbody></table>

  <table cellpadding="4" cellspacing="0">
    <tbody><tr>
      <td style="background-color: rgb(255, 255, 255);"><input type="submit" id="btnSubmit" value="删除" class="button" disabled="true"></td>
      <td align="right" style="background-color: rgb(255, 255, 255);">      <!-- $Id: page.htm 14216 2008-03-10 02:27:21Z testyang $ -->
        <div id="turn-page"><?php echo $pageHtml ?></div>
</td>
    </tr>
  </tbody></table>
</div>

</form>

<div id="footer">
	版权所有 &copy; 2012-2013 传智播客 - PHP培训 - </div>
</div>

<script type="text/javascript">
  function searchAttr(categoryId) {
    window.location.href = 'index.php?controller=backend/ProductAttribute&action=index&category_id=' + categoryId;
  }
</script>
</body>
</html>