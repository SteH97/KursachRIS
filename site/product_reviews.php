<?php
/*
  $Id: product_reviews.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  $product_info_query = tep_db_query("select p.products_id, p.products_model, p.products_image, p.products_price, p.products_tax_class_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'");
  if (!tep_db_num_rows($product_info_query)) {
    tep_redirect(tep_href_link(FILENAME_REVIEWS));
  } else {
    $product_info = tep_db_fetch_array($product_info_query);
  }

  if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
    $products_price = '<s>' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
  } else {
    $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
  }

  if (tep_not_null($product_info['products_model'])) {
    $products_name = $product_info['products_name'] . '<br><span class="smallText">[' . $product_info['products_model'] . ']</span>';
  } else {
    $products_name = $product_info['products_name'];
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_REVIEWS);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params()));
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<?php require(DIR_WS_INCLUDES . 'header_includes.php'); ?>

<script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
</head>
<body>
<?php $tab_sel = 8; ?>
<!-- header //-->
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

<?php echo tep_draw_title_top();?>

			<?php echo $products_name; ?>
			
<?php echo tep_draw_title_bottom();?>




<?php
  $reviews_query_raw = "select r.reviews_id, left(rd.reviews_text, 100) as reviews_text, r.reviews_rating, r.date_added, r.customers_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.products_id = '" . (int)$product_info['products_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' order by r.reviews_id desc";
  $reviews_split = new splitPageResults($reviews_query_raw, MAX_DISPLAY_NEW_REVIEWS);

  if ($reviews_split->number_of_rows > 0) {
    if ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')) {
?>

<?php echo tep_draw_result1_top(); ?> 
       
		<table border="0" cellspacing="0" cellpadding="0" class="result result_top_padd">
          <tr>
            <td><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></td>
            <td class="result_right"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></td>
          </tr>
        </table>

<?php echo tep_draw_result1_bottom(); ?> 
    
<?php /*  echo tep_draw2_top();  */?>		

<?php
    }
?>								
<?php echo tep_draw1_top();?>	
<?php
    $reviews_query = tep_db_query($reviews_split->sql_query);
    while ($reviews = tep_db_fetch_array($reviews_query)) {
?>
				
				<table border="0" width="100%" cellspacing="0" cellpadding="0" style="margin:10px 0px 10px 0px;">
                  <tr>
                    <td class="main indent_2"><?php echo '<b><a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $product_info['products_id'] . '&reviews_id=' . $reviews['reviews_id']) . '">' . sprintf(TEXT_REVIEW_BY, tep_output_string_protected($reviews['customers_name'])) . '</a></b>'; ?></td>
                    <td class="smallText" align="right"><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, tep_date_long($reviews['date_added'])); ?></td>
                  </tr>
                </table>
				
					<table border="0" cellspacing="0" cellpadding="0">
					  <tr><td align="center">
						
		<?php
		  if (tep_not_null($product_info['products_image'])) {
		?>
<div class="main" style="float:left;padding:1px 1px 1px 1px;margin-right:15px; text-align:center; width:<?php echo (SMALL_IMAGE_WIDTH +23);?>px;">

<?php echo tep_draw_prod_pic_top();?>

<script language="javascript"><!--
document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'pID=' . $product_info['products_id']) . '\\\')">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, '') . '</a>'; ?>');
//--></script>
<noscript>
<?php echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image']) . '" target="_blank">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], $product_info['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, '') . '</a>'; ?>
</noscript>

<?php echo tep_draw_prod_pic_bottom();?>

<script language="javascript"><!--
document.write('<?php echo '<a class="enlarge" href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'pID=' . $product_info['products_id']) . '\\\')">' . TEXT_CLICK_TO_ENLARGE . '</a>'; ?>');
//--></script>
<noscript>
<?php echo '<a class="enlarge" href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image']) . '" target="_blank">' .  TEXT_CLICK_TO_ENLARGE . '</a>'; ?>
</noscript>

</div>	

		<?php
		  }
		?>
						</td>
						<td align="right"><br><a href="<?php echo tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now')?>"><?php echo tep_image_button('button_add_to_cart1.gif', IMAGE_BUTTON_IN_CART)?></a></td>
					  </tr>
					  
					</table>

<?php echo tep_pixel_trans();?>              
            
<?php echo tep_draw_infoBox_top();?>
					
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                        <td class="main"><?php echo tep_break_string(tep_output_string_protected($reviews['reviews_text']), 60, '-<br>') . ((strlen($reviews['reviews_text']) >= 100) ? '..' : '') . '<br><br><i>' . sprintf(TEXT_REVIEW_RATING, tep_image(DIR_WS_IMAGES . 'stars_' . $reviews['reviews_rating'] . '.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])), sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])) . '</i>'; ?></td>
                        <td width="10" align="right"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      </tr>
                    </table>
				
<?php echo tep_draw_infoBox_bottom();?>

<?php
    }
?>
<?php echo tep_draw1_bottom();?>
<?php
  } else {
?>
<?php echo tep_draw1_top();?>

			  <table cellpadding="0" cellspacing="0" border="0">
			 	<tr><td style="padding:25px 0px 20px 0px;"><?php new infoBox_search_criteria(array(array('text' => TEXT_NO_REVIEWS))); ?></td></tr>
			  </table>
<?php echo tep_draw1_bottom();?>               
<?php
  }
?>
 

<?php
  if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>

<?php echo tep_pixel_trans();?>

<?php echo tep_draw_result2_top(); ?> 
       
		<table border="0" cellspacing="0" cellpadding="0" class="result result_bottom_padd">
          <tr>
            <td><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></td>
            <td class="result_right"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></td>
          </tr>
        </table>

<?php echo tep_draw_result1_top(); ?> 

<?php /*  echo tep_draw2_bottom();  */?>

<?php
  }
?>

<?php echo tep_separat();?>
<?php echo tep_draw1_top();?>
<?php echo tep_separat();?>

					<table border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="100%"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params()) . '">' . tep_image_button('button_back1.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
                        <td><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, tep_get_all_get_params()) . '">' . tep_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a>'; ?></td>
                      </tr>
                    </table>					 
<?php echo tep_draw1_bottom();?>    		
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
