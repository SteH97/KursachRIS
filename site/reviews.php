<?php
/*
  $Id: reviews.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_REVIEWS);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_REVIEWS));
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<?php require(DIR_WS_INCLUDES . 'header_includes.php'); ?>

</head>
<body>
<!-- header //-->
<?php $tab_sel = 8; ?>
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
  $reviews_query_raw = "select r.reviews_id, left(rd.reviews_text, 100) as reviews_text, r.reviews_rating, r.date_added, p.products_id, pd.products_name, p.products_image, r.customers_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = r.products_id and r.reviews_id = rd.reviews_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and rd.languages_id = '" . (int)$languages_id . "' order by r.reviews_id DESC";
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

<?php
  }
?>

<?php echo tep_pixel_trans();?>

<?php /*  echo tep_draw2_top();  */?>

<?php
    $reviews_query = tep_db_query($reviews_split->sql_query);
    while ($reviews = tep_db_fetch_array($reviews_query)) {
?>
			
			<table border="0" width="100%" cellspacing="0" cellpadding="0" class="reviews_padd">
              <tr>
                <td class="main"><?php echo '<b><a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $reviews['products_id'] . '&reviews_id=' . $reviews['reviews_id']) . '">' . $reviews['products_name'] . '</a></b> <span class="smallText">' . sprintf(TEXT_REVIEW_BY, tep_output_string_protected($reviews['customers_name'])) . '</span>'; ?></td>
                <td class="smallText vam" align="right"><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, tep_date_long($reviews['date_added'])); ?></td>
              </tr>
            </table>
            
<?php echo tep_pixel_trans();?>            
				
<?php echo tep_draw_infoBox_top();?>

				<table border="0" width="100%" cellspacing="0" cellpadding="2"><tr>
                    <td width="<?php echo SMALL_IMAGE_WIDTH + 10; ?>" align="center" class="main"><?php echo tep_draw_prod_pic_top().'<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $reviews['products_id'] . '&reviews_id=' . $reviews['reviews_id']) . '">' . tep_image(DIR_WS_IMAGES . $reviews['products_image'], $reviews['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>'. tep_draw_prod_pic_bottom(); ?></td>
                    <td class="main" style="padding-left:9px; width:100%;"><?php echo tep_break_string(tep_output_string_protected($reviews['reviews_text']), 60, '-<br>') . ((strlen($reviews['reviews_text']) >= 100) ? '..' : '') . '<br><br><i>' . sprintf(TEXT_REVIEW_RATING, tep_image(DIR_WS_IMAGES . 'stars_' . $reviews['reviews_rating'] . '.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])), sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])) . '</i>'; ?></td>
                  </tr>
                </table>
				
<?php echo tep_draw_infoBox_bottom();?>



<?php
    }
?>
<?php
  } else {
?>
<?php echo tep_draw4_top();?>
        <table cellpadding="0" cellspacing="0" border="0">
		  <tr>
            <td><?php new infoBox(array(array('text' => TEXT_NO_REVIEWS))); ?></td>
          </tr>
		</table>
<?php echo tep_draw4_bottom();?>


<?php
  }
?>

<?php /*  echo tep_draw2_bottom();  */?>

<?php
  if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>

<?php echo tep_draw_result2_top(); ?>
			
		<table border="0" cellspacing="0" cellpadding="0" class="result result_bottom_padd">
          <tr>
            <td><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></td>
            <td class="result_right"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></td>
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
