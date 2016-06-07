<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SHOP 管理中心 - 商品分类 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="backend/styles/general.css" rel="stylesheet" type="text/css" />
<link href="backend/styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>

<h1>
<span class="action-span"><a href="index.php?controller=backend/ProductCategory&action=create">添加分类</a></span>
<span class="action-span1"><a href="index.php?p=admin&c=index&a=index">SHOP 管理中心</a> </span><span id="search_id" class="action-span1"> - 商品分类 </span>
<div style="clear:both"></div>
</h1>

<form method="post" action="" name="listForm">
<!-- start ad position list -->
	<div class="list-div" id="listDiv">
		<table width="100%" cellspacing="1" cellpadding="2" id="list-table">
			<tbody>
				<tr>
          <th>分类名称</th>
          <th>分类描述</th>
					<th>数量单位</th>
					<th>是否显示</th>
					<th>排序</th>
					<th>操作</th>
				</tr>
        <?php foreach($productCategorys as $productCategory): ?>
          <tr align="center" class="<?php echo $productCategory['parent_id'] ?>" id="<?php echo $productCategory['parent_id'] ?>_<?php echo $productCategory['level'] ?>">
            <td align="left" class="first-cell">
              <img src="backend/images/menu_minus.gif" id="icon_<?php echo $productCategory['parent_id'] ?>_<?php echo $productCategory['level'] ?>" width="9" height="9" border="0" style="margin-left:<?php echo $productCategory['level'] * 2 ?>em" onclick="rowClicked(this)">
              <span><a href="goods.php?act=list&amp;cat_id=1"><?php echo $productCategory['name'] ?></a></span>
             </td>
            <td width="10%"><?php echo $productCategory['description'] ?></td>
            <td width="10%"><?php echo $productCategory['unit'] ?></td>
            <td width="10%"><img src="backend/images/<?php echo $productCategory['is_show'] ? "yes" : "no" ?>.gif" onclick="listTable.toggle(this, 'toggle_is_show', 1)"></td>
            <td width="10%" align="right"><?php echo $productCategory['display_order'] ?></td>
            <td width="24%" align="center">
              <a href="index.php?controller=backend/ProductCategory&action=update&id=<?php echo $productCategory['id'] ?>">编辑</a> |
              <a href="index.php?controller=backend/ProductCategory&action=delete&id=<?php echo $productCategory['id'] ?>" title="移除" onclick="return confirm('确定删除？');">移除</a>
            </td>
          </tr>
        <?php endforeach; ?>
	</tbody>
  </table>
</div>
</form>

  </table>
</div>
</form>


<div id="footer">
	版权所有 &copy; 2012-2013 传智播客 - PHP培训 - </div>
</div>
 <script>
	/**
 * 折叠分类列表
 */
var imgPlus = new Image();
imgPlus.src = "backend/images/menu_plus.gif";

function rowClicked(obj)
{
  // 当前图像
  img = obj;
  // 取得上二级tr>td>img对象
  obj = obj.parentNode.parentNode;
  // 整个分类列表表格
  var tbl = document.getElementById("list-table");
  // 当前分类级别
  var lvl = parseInt(obj.className);
  // 是否找到元素
  var fnd = false;
  var sub_display = img.src.indexOf('menu_minus.gif') > 0 ? 'none' : 'table-row' ;
  // 遍历所有的分类
  for (i = 0; i < tbl.rows.length; i++)
  {
      var row = tbl.rows[i];
      if (row == obj)
      {
          // 找到当前行
          fnd = true;
          //document.getElementById('result').innerHTML += 'Find row at ' + i +"<br/>";
      }
      else
      {
          if (fnd == true)
          {
              var cur = parseInt(row.className);
              var icon = 'icon_' + row.id;
              if (cur > lvl)
              {
                  row.style.display = sub_display;
                  if (sub_display != 'none')
                  {
                      var iconimg = document.getElementById(icon);
                      iconimg.src = iconimg.src.replace('plus.gif', 'minus.gif');
                  }
              }
              else
              {
                  fnd = false;
                  break;
              }
          }
      }
  }

  for (i = 0; i < obj.cells[0].childNodes.length; i++)
  {
      var imgObj = obj.cells[0].childNodes[i];
      if (imgObj.tagName == "IMG" && imgObj.src != 'backend/images/menu_arrow.gif')
      {
          imgObj.src = (imgObj.src == imgPlus.src) ? 'backend/images/menu_minus.gif' : imgPlus.src;
      }
  }
}
</script>
</body>
</html>