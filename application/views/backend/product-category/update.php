<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SHOP 管理中心 - 添加分类 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="backend/styles/general.css" rel="stylesheet" type="text/css" />
<link href="backend/styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>

<h1>
<span class="action-span"><a href="index.php?controller=backend/ProductCategory&action=index">商品分类</a></span>
<span class="action-span1"><a href="index.php?act=main">SHOP 管理中心</a> </span><span id="search_id" class="action-span1"> - 添加分类 </span>
<div style="clear:both"></div>
</h1>
<!-- start add new category form -->
<div class="main-div">
  <form action="index.php?controller=backend/ProductCategory&action=update&id=<?php echo $productCategory['id'] ?>" method="post" name="theForm" enctype="multipart/form-data">
	 <table width="100%" id="general-table">
		<tbody>
			<tr>
				<td class="label">分类名称:</td>
				<td><input type="text" name="cat_name" maxlength="20" value="<?php echo $productCategory['name'] ?>" size="27"> <font color="red">*</font></td>
			</tr>
			<tr>
				<td class="label">上级分类:</td>
				<td>
					<select name="parent_id">
						<option value="0">顶级分类</option>
						<?php foreach($productCategorys as $item): ?>
							<option <?php if ($productCategory['parent_id'] == $item['id']): ?>selected<?php endif;?> value="<?php echo $item['id'] ?>"><?php echo str_repeat('&nbsp;', $item['level'] * 2) ?><?php echo $item['name'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>

			<tr id="measure_unit">
				<td class="label">数量单位:</td>
				<td><input type="text" name="unit" value="<?php echo $productCategory['unit'] ?>" size="12"></td>
			</tr>
			<tr>
				<td class="label">排序:</td>
				<td><input type="text" name="sort_order" value="<?php echo $productCategory['display_order'] ?>" size="15"></td>
			</tr>

			<tr>
				<td class="label">是否显示:</td>
				<td><input type="radio" <?php if ($productCategory['is_show'] == 1): ?>checked<?php endif; ?> name="is_show" value="1"  <?php if ($productCategory['is_show'] == 0): ?>checked<?php endif; ?> > 是<input type="radio" name="is_show" value="0"> 否  </td>
			</tr>
      <tr>
        <td class="label">分类描述:</td>
        <td>
          <textarea name="cat_desc" rows="6" cols="48"><?php echo $productCategory['description'] ?></textarea>
        </td>
      </tr>
      </tbody></table>
      <div class="button-div">
        <input type="submit" value=" 确定 ">
        <input type="reset" value=" 重置 ">
      </div>
  
  </form>
</div>



<div id="footer">
	版权所有 &copy; 2012-2013 传智播客 - PHP培训 - 
</div>

</div>

</body>
</html>