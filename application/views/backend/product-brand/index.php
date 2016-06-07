<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SHOP 管理中心 - 品牌管理 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="backend/styles/general.css" rel="stylesheet" type="text/css" />
<link href="backend/styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>

<h1>
<span class="action-span"><a href="index.php?controller=backend/ProductBrand&action=create">添加品牌</a></span>
<span class="action-span1"><a href="index.php?act=main">SHOP 管理中心</a> </span><span id="search_id" class="action-span1"> - 商品品牌 </span>
<div style="clear:both"></div>
</h1>

<div class="form-div">
  <form action="javascript:search_brand()" name="searchForm">
    <img src="backend/images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH">
     <input type="text" name="brand_name" size="15">
    <input type="submit" value=" 搜索 " class="button">
  </form>
</div>

<form method="post" action="" name="listForm">
<!-- start brand list -->
<div class="list-div" id="listDiv">

  <table cellpadding="3" cellspacing="1">
    <tbody>
		<tr>
			<th>品牌名称</th>
			<th>品牌描述</th>
			<th>排序</th>
			<th>是否显示</th>
			<th>操作</th>
		</tr>
    <?php foreach($productBrands as $productBrand): ?>
      <tr>
  			<td class="first-cell"><span style="float:right"><a href="../data/brandlogo/1240803062307572427.gif" target="_brank"><img src="upload/<?php echo $productBrand['image_path'] ?>" width="16" height="16" border="0" alt="品牌LOGO"></a></span>
  			<span onclick="javascript:listTable.edit(this, 'edit_brand_name', 1)" title="点击修改内容" style=""><?php echo $productBrand['name'] ?></span>
  			</td>
  			<td align="left" ><?php echo $productBrand['description'] ?></td>
  			<td align="right"><span onclick="javascript:listTable.edit(this, 'edit_sort_order', 1)"><?php echo $productBrand['display_order'] ?></span></td>
  			<td align="center"><img src="backend/images/<?php echo $productBrand['is_show'] ? "yes" : "no" ?>.gif"></td>
  			<td align="center">
  				<a href="index.php?controller=backend/ProductBrand&action=update&id=<?php echo $productBrand['id'] ?>" title="编辑">编辑</a> |
  				<a href="index.php?controller=backend/ProductBrand&action=delete&id=<?php echo $productBrand['id'] ?>" onclick="return confirm('确定删除？')" title="编辑">移除</a> 
  			</td>
  		</tr>
    <?php endforeach; ?>
    <tr>
		<td align="right" nowrap="true" colspan="6">
            <div id="turn-page">
			总计  <span id="totalRecords">11</span>
        个记录分为 <span id="totalPages">2</span>
        页当前第 <span id="pageCurrent">1</span>
        页，每页 <input type="text" size="3" id="pageSize" value="10" onkeypress="return listTable.changePageSize(event)">
        <span id="page-link">
          <a href="javascript:listTable.gotoPageFirst()">第一页</a>
          <a href="javascript:listTable.gotoPagePrev()">上一页</a>
          <a href="javascript:listTable.gotoPageNext()">下一页</a>
          <a href="javascript:listTable.gotoPageLast()">最末页</a>
          <select id="gotoPage" onchange="listTable.gotoPage(this.value)">
            <option value="1">1</option><option value="2">2</option>          </select>
        </span>
      </div>
      </td>
    </tr>
  </tbody></table>

<!-- end brand list -->
</div>
</form>


<div id="footer">
	版权所有 &copy; 2012-2013 传智播客 - PHP培训 - </div>
</div>

</body>
</html>