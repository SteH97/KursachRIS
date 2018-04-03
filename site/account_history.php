<?php
/*
  $Id: account_history.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT_HISTORY);

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<?php require(DIR_WS_INCLUDES . 'header_includes.php'); ?>

</head>

<body>
<!-- header //-->
<?php $tab_sel = 5; ?>
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

				<?php echo HEADING_TITLE; ?>
			
<?php echo tep_draw_title_bottom();?>
								
<?php echo tep_draw1_top();?>
	
<?php
  $orders_total = tep_count_customer_orders();

  if ($orders_total > 0) {
    $history_query_raw = "select o.orders_id, o.date_purchased, o.delivery_name, o.billing_name, ot.text as order_total, s.orders_status_name from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$customer_id . "' and o.orders_id = ot.orders_id and ot.class = 'ot_total' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and s.public_flag = '1' order by orders_id DESC";
    $history_split = new splitPageResults($history_query_raw, MAX_DISPLAY_ORDER_HISTORY);
    $history_query = tep_db_query($history_split->sql_query);

    while ($history = tep_db_fetch_array($history_query)) {
      $products_query = tep_db_query("select count(*) as count from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$history['orders_id'] . "'");
      $products = tep_db_fetch_array($products_query);

      if (tep_not_null($history['delivery_name'])) {
        $order_type = TEXT_ORDER_SHIPPED_TO;
        $order_name = $history['delivery_name'];
      } else {
        $order_type = TEXT_ORDER_BILLED_TO;
        $order_name = $history['billing_name'];
      }
?>
          <table border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr>
              <td class="main indent_2">&nbsp;<?php echo '<b>' . TEXT_ORDER_NUMBER . '</b> ' . $history['orders_id']; ?></td>
              <td class="main" align="right"><?php echo '<b>' . TEXT_ORDER_STATUS . '</b> ' . $history['orders_status_name']; ?></td>
            </tr>
          </table>
				
<?php echo tep_draw_infoBox_top();?>

			  <table border="0" width="100%" cellspacing="2" cellpadding="4">
                <tr>
                  <td class="main" width="50%"><?php echo '<b>' . TEXT_ORDER_DATE . '</b> ' . tep_date_long($history['date_purchased']) . '<br><b>' . $order_type . '</b> ' . tep_output_string_protected($order_name); ?></td>
                  <td class="main" width="30%"><?php echo '<b>' . TEXT_ORDER_PRODUCTS . '</b> ' . $products['count'] . '<br><b>' . TEXT_ORDER_COST . '</b> ' . strip_tags($history['order_total']); ?></td>
                  <td class="main" width="20%"><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, (isset($HTTP_GET_VARS['page']) ? 'page=' . $HTTP_GET_VARS['page'] . '&' : '') . 'order_id=' . $history['orders_id'], 'SSL') . '">' . tep_image_button('button_view.gif', SMALL_IMAGE_BUTTON_VIEW) . '</a>'; ?></td>
                </tr>
              </table>
				
<?php echo tep_draw_infoBox_bottom();?>

<?php echo tep_pixel_trans();?>

<?php
    }
  } else {
?>
				
<?php echo tep_draw_infoBox_top();?>
			  
			  <table border="0" width="100%" cellspacing="2" cellpadding="4">
                <tr>
                  <td class="main"><?php echo TEXT_NO_PURCHASES; ?></td>
                </tr>
              </table>
				
<?php echo tep_draw_infoBox_bottom();?>
			  
<?php
  }
?>

<?php
  if ($orders_total > 0) {
?>
      	<table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="smallText"><?php echo $history_split->display_count(TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
            <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $history_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table>
		
<?php
  }
?>

<?php echo tep_pixel_trans();?>
				
<?php echo tep_draw_infoBox2_top();?>

			<table border="0" width="100%" cellspacing="0" cellpadding="2">
				<tr><td><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . tep_image_button('button_back1.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td></tr>
            </table>
				
<?php echo tep_draw_infoBox2_bottom();?>
				
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
