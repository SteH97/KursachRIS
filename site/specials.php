<?php
/*
  $Id: specials.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SPECIALS);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SPECIALS));
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<?php require(DIR_WS_INCLUDES . 'header_includes.php'); ?>

</head>
<body>
<!-- header //-->
<?php $tab_sel = 4; ?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" class="<?php echo MAIN_TABLE; ?>" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td class="<?php echo BOX_WIDTH_TD_LEFT; ?>"><table border="0" class="<?php echo BOX_WIDTH_LEFT; ?>" cellspacing="0" cellpadding="0">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td class="<?php echo CONTENT_WIDTH_TD; ?>"><?php include(DIR_WS_BOXES . 'panel_top.php');?>
	
<?php echo tep_draw_top();?>

				<?php new contentBoxHeading_ProdNew($info_box_contents);?>
											
				
<?php echo tep_draw3_top();?>
	
<?php
  $specials_query_raw = "select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' order by s.specials_date_added DESC";
  $specials_split = new splitPageResults($specials_query_raw, MAX_DISPLAY_SPECIAL_PRODUCTS);

  if (($specials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>

<?php echo tep_draw_result1_top(); ?> 
       
		<table border="0" cellspacing="0" cellpadding="0" class="result result_top_padd">
          <tr>
            <td><?php echo $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS); ?></td>
            <td class="result_right"><?php echo TEXT_RESULT_PAGE . ' ' . $specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table>

<?php echo tep_draw_result1_bottom(); ?> 
	 
<?php
  }
?>

<?php
    $row = 0;
    $specials_query = tep_db_query($specials_split->sql_query);
  
  $row = 0;
  $col = 0;
  
  $col_items = (MAX_DISPLAY_SPECIAL_PER_ROW -1);
  $col_width = (int)(100 / ($col_items + 1)).'%';
  
  $info_box_contents = array();
   while ($specials = tep_db_fetch_array($specials_query)) {
    $specials['products_name'] = tep_get_products_name($specials['products_id']);
// ----------	
	$product_query = tep_db_query("select products_description, products_id from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$specials['products_id'] . "' and language_id = '" . (int)$languages_id . "'");
	$product = tep_db_fetch_array($product_query);
	$p_desc = substr(strip_tags($product['products_description']), 0, MAX_DESCR_1).'...';
	$p_id = $product['products_id'];
	
	$p_pic = '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $specials['products_image'], $specials['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>';
	
	$p_name = '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']) . '">' .$specials['products_name'] . '</a>';
	
	$p_price = '<s>'.$currencies->display_price($specials['products_price'], tep_get_tax_rate($specials['products_tax_class_id'])).'</s>&nbsp;&nbsp; <span class="productSpecialPrice">' . $currencies->display_price($specials['specials_new_products_price'], tep_get_tax_rate($specials['products_tax_class_id'])) . '</span>';
	
  $p_details = '<a href="' . tep_href_link('product_info.php?products_id='.$p_id) . '">'.tep_image_button('button_details.gif', '', ' class="btn1"').'</a>';
  $p_buy_now = '<a href="'.tep_href_link("products_new.php","action=buy_now&products_id=".$p_id).'">'.tep_image_button('button_add_to_cart1.gif', '', ' class="btn1"').'</a>';
  $p_button = '<a href="'.tep_href_link("products_new.php","action=buy_now&products_id=".$p_id).'">'.tep_image_button('button_buy_now1.gif', '', ' class="btn1"').'</a>';
    $info_box_contents[$row][$col] = array('align' => 'center',
                                           'params' => ' style="width:'.$col_width.'"',
                                           'text' => ''.tep_draw_prod2_top().'
	<table cellpadding="0" cellspacing="0" border="0" class="wrapper_box">
		<tr><td class="pic2_padd">'.tep_draw_prod_pic_top().''.$p_pic.''.tep_draw_prod_pic_bottom().'</td></tr>
		<tr><td class="name name2_padd">'.$p_name.'</td></tr>
		<tr><td class="price2_padd"><b>'.PRICE.':</b> '.$p_price.'</td></tr>
		<tr><td class="desc desc2_padd">'.$p_desc.'</td></tr>
		
			
		<tr><td class="button2__padd">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="button2_padd"  id="bg_button2" onMouseOut="this.id=\'bg_button2\';" onMouseOver="this.id=\'bg_button2-act\';"><a href="' . tep_href_link('product_info.php?products_id='.$p_id) . '">'.DETAILS .'</a></td>
					<td>|</td>
					<td class="button22_padd"  id="bg_button22" onMouseOut="this.id=\'bg_button22\';" onMouseOver="this.id=\'bg_button22-act\';" style="width:100%;"><a href="'.tep_href_link("products_new.php","action=buy_now&products_id=".$p_id).'">'.ADD_TO_CART.'</a></td>
				</tr>
			</table>
		</td></tr>
	</table>									   
	'.tep_draw_prod2_bottom().'');
										   
	  $col ++;
    if ($col > $col_items) {
      $col = 0;
      $row ++;
    }
  }
  new contentBox($info_box_contents);
?>
      		
<?php
  if (($specials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>

<?php echo tep_draw_result2_top(); ?> 
       
		<table border="0" cellspacing="0" cellpadding="0" class="result result_bottom_padd">
          <tr>
            <td><?php echo $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS); ?></td>
            <td class="result_right"><?php echo TEXT_RESULT_PAGE . ' ' . $specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table>

<?php echo tep_draw_result2_bottom(); ?> 
       
<?php
  }
?>

<?php echo tep_draw3_bottom();?>

<?php echo tep_draw_bottom();?>
	
	</td>
<!-- body_text_eof //-->
	<td class="<?php echo BOX_WIDTH_TD_RIGHT; ?>"><table border="0" class="<?php echo BOX_WIDTH_RIGHT; ?>" cellspacing="0" cellpadding="0">
<!-- right_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_right.php'); ?>
<!-- right_navigation_eof //-->
    </table></td>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
<?php require(DIR_WS_INCLUDES . 'footer_includes.php'); ?>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
