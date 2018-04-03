<?php
/*
  $Id: account_notifications.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

// needs to be included earlier to set the success message in the messageStack
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT_NOTIFICATIONS);

  $global_query = tep_db_query("select global_product_notifications from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . (int)$customer_id . "'");
  $global = tep_db_fetch_array($global_query);

  if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'process')) {
    if (isset($HTTP_POST_VARS['product_global']) && is_numeric($HTTP_POST_VARS['product_global'])) {
      $product_global = tep_db_prepare_input($HTTP_POST_VARS['product_global']);
    } else {
      $product_global = '0';
    }

    (array)$products = $HTTP_POST_VARS['products'];

    if ($product_global != $global['global_product_notifications']) {
      $product_global = (($global['global_product_notifications'] == '1') ? '0' : '1');

      tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set global_product_notifications = '" . (int)$product_global . "' where customers_info_id = '" . (int)$customer_id . "'");
    } elseif (sizeof($products) > 0) {
      $products_parsed = array();
      reset($products);
      while (list(, $value) = each($products)) {
        if (is_numeric($value)) {
          $products_parsed[] = $value;
        }
      }

      if (sizeof($products_parsed) > 0) {
        $check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$customer_id . "' and products_id not in (" . implode(',', $products_parsed) . ")");
        $check = tep_db_fetch_array($check_query);

        if ($check['total'] > 0) {
          tep_db_query("delete from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$customer_id . "' and products_id not in (" . implode(',', $products_parsed) . ")");
        }
      }
    } else {
      $check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$customer_id . "'");
      $check = tep_db_fetch_array($check_query);

      if ($check['total'] > 0) {
        tep_db_query("delete from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$customer_id . "'");
      }
    }

    $messageStack->add_session('account', SUCCESS_NOTIFICATIONS_UPDATED, 'success');

    tep_redirect(tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));
  }

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL'));
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<?php require(DIR_WS_INCLUDES . 'header_includes.php'); ?>

<script language="javascript"><!--
function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}

function checkBox(object) {
  document.account_notifications.elements[object].checked = !document.account_notifications.elements[object].checked;
}
//--></script>
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
    <td class="<?php echo CONTENT_WIDTH_TD; ?>"><?php include(DIR_WS_BOXES . 'panel_top.php');?><?php echo tep_draw_form('account_notifications', tep_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL')) . tep_draw_hidden_field('action', 'process'); ?>
	
<?php echo tep_draw_top();?>

<?php echo tep_draw_title_top();?>

				<?php echo HEADING_TITLE; ?>
			
<?php echo tep_draw_title_bottom();?>
								
<?php echo tep_draw1_top();?>

	<table cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td class="main indent_2"><b><?php echo MY_NOTIFICATIONS_TITLE; ?></b></td>
      </tr>
	</table>
				
<?php echo tep_draw_infoBox_top();?>

			<table border="0" width="100%" cellspacing="0" cellpadding="2"><tr>
                <td class="main"><?php echo MY_NOTIFICATIONS_DESCRIPTION; ?></td>
              </tr>
            </table>
				
<?php echo tep_draw_infoBox_bottom();?>

	<table cellpadding="0" cellspacing="0" border="0">
      <tr><td class="main indent_2"><b><?php echo GLOBAL_NOTIFICATIONS_TITLE; ?></b></td></tr>
	</table> 
				
<?php echo tep_draw_infoBox_top();?>

			<table border="0" width="100%" cellspacing="0" cellpadding="2"><tr>
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr class="moduleRow" onMouseOver="rowOverEffect(this)" onMouseOut="rowOutEffect(this)" onClick="checkBox('product_global')">
                    <td class="main" width="30"><?php echo tep_draw_checkbox_field('product_global', '1', (($global['global_product_notifications'] == '1') ? true : false), 'onclick="checkBox(\'product_global\')"'); ?></td>
                    <td class="main"><b><?php echo GLOBAL_NOTIFICATIONS_TITLE; ?></b></td>
                  </tr>
                  <tr>
                    <td width="30">&nbsp;</td>
                    <td class="main"><?php echo GLOBAL_NOTIFICATIONS_DESCRIPTION; ?></td>
                  </tr>
                </table></td>
              </tr>
            </table>
				
<?php echo tep_draw_infoBox_bottom();?>

<?php echo tep_pixel_trans();?>

<?php
  if ($global['global_product_notifications'] != '1') {
?>
    <table cellpadding="0" cellspacing="0" border="0">
	  <tr><td class="main indent_2"><b><?php echo NOTIFICATIONS_TITLE; ?></b></td></tr>
	</table>
				
<?php echo tep_draw_infoBox_top();?>

			<table border="0" width="100%" cellspacing="0" cellpadding="2"><tr>
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
    $products_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_NOTIFICATIONS . " where customers_id = '" . (int)$customer_id . "'");
    $products_check = tep_db_fetch_array($products_check_query);
    if ($products_check['total'] > 0) {
?>
                  <tr>
                    <td class="main" colspan="2"><?php echo NOTIFICATIONS_DESCRIPTION; ?></td>
                  </tr>
<?php
      $counter = 0;
      $products_query = tep_db_query("select pd.products_id, pd.products_name from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_NOTIFICATIONS . " pn where pn.customers_id = '" . (int)$customer_id . "' and pn.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by pd.products_name");
      while ($products = tep_db_fetch_array($products_query)) {
?>
                  <tr class="moduleRow" onMouseOver="rowOverEffect(this)" onMouseOut="rowOutEffect(this)" onClick="checkBox('products[<?php echo $counter; ?>]')">
                    <td class="main" width="30"><?php echo tep_draw_checkbox_field('products[' . $counter . ']', $products['products_id'], true, 'onclick="checkBox(\'products[' . $counter . ']\')"'); ?></td>
                    <td class="main"><b><?php echo $products['products_name']; ?></b></td>
                  </tr>
<?php
        $counter++;
      }
    } else {
?>
                  <tr>
                    <td class="main"><?php echo NOTIFICATIONS_NON_EXISTING; ?></td>
                  </tr>
<?php
    }
?>
                </table></td>
              </tr>
            </table>
				
<?php echo tep_draw_infoBox_bottom();?>

<?php echo tep_pixel_trans();?>

<?php
  }
?>      
				
<?php echo tep_draw_infoBox2_top();?>

			<table border="0" width="100%" cellspacing="0" cellpadding="2">
				<tr><td><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . tep_image_button('button_back1.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
                <td align="right"><?php echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td></tr>
            </table>
				
<?php echo tep_draw_infoBox2_bottom();?>
	
<?php echo tep_draw1_bottom();?>
      		
<?php echo tep_draw_bottom();?>

	</form></td>
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
