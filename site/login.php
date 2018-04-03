<?php
/*
  $Id: login.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
  if ($session_started == false) {
    tep_redirect(tep_href_link(FILENAME_COOKIE_USAGE));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGIN);

  $error = false;
  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process')) {
    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);
    $password = tep_db_prepare_input($HTTP_POST_VARS['password']);

// Check if email exists
    $check_customer_query = tep_db_query("select customers_id, customers_firstname, customers_password, customers_email_address, customers_default_address_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
    if (!tep_db_num_rows($check_customer_query)) {
      $error = true;
    } else {
      $check_customer = tep_db_fetch_array($check_customer_query);
// Check that password is good
      if (!tep_validate_password($password, $check_customer['customers_password'])) {
        $error = true;
      } else {
        if (SESSION_RECREATE == 'True') {
          tep_session_recreate();
        }

        $check_country_query = tep_db_query("select entry_country_id, entry_zone_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$check_customer['customers_id'] . "' and address_book_id = '" . (int)$check_customer['customers_default_address_id'] . "'");
        $check_country = tep_db_fetch_array($check_country_query);

        $customer_id = $check_customer['customers_id'];
        $customer_default_address_id = $check_customer['customers_default_address_id'];
        $customer_first_name = $check_customer['customers_firstname'];
        $customer_country_id = $check_country['entry_country_id'];
        $customer_zone_id = $check_country['entry_zone_id'];
        tep_session_register('customer_id');
        tep_session_register('customer_default_address_id');
        tep_session_register('customer_first_name');
        tep_session_register('customer_country_id');
        tep_session_register('customer_zone_id');

        tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1 where customers_info_id = '" . (int)$customer_id . "'");

// restore cart contents
        $cart->restore_contents();

        if (sizeof($navigation->snapshot) > 0) {
          $origin_href = tep_href_link($navigation->snapshot['page'], tep_array_to_string($navigation->snapshot['get'], array(tep_session_name())), $navigation->snapshot['mode']);
          $navigation->clear_snapshot();
          tep_redirect($origin_href);
        } else {
          tep_redirect(tep_href_link(FILENAME_DEFAULT));
        }
      }
    }
  }

  if ($error == true) {
    $messageStack->add('login', TEXT_LOGIN_ERROR);
  }

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_LOGIN, '', 'SSL'));
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<?php require(DIR_WS_INCLUDES . 'header_includes.php'); ?>

<script language="javascript"><!--
function session_win() {
  window.open("<?php echo tep_href_link(FILENAME_INFO_SHOPPING_CART); ?>","info_shopping_cart","height=559,width=465,toolbar=no,statusbar=no,scrollbars=yes").focus();
}
//--></script>
</head>
<body>
<!-- header //-->
<?php $tab_sel = 6; ?>
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
    <td class="<?php echo CONTENT_WIDTH_TD; ?>"><?php include(DIR_WS_BOXES . 'panel_top.php');?><?php echo tep_draw_form('login', tep_href_link(FILENAME_LOGIN, 'action=process', 'SSL')); ?>
	
<?php echo tep_draw_top();?>

<?php echo tep_draw_title_top();?>

				<?php echo HEADING_TITLE; ?>
			
<?php echo tep_draw_title_bottom();?>
								
<?php echo tep_draw1_top();?>
 
<?php
  if ($messageStack->size('login') > 0) {
?>
    <table cellpadding="0" cellspacing="0" border="0">
	  <tr>
        <td><?php echo $messageStack->output('login'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	</table>
<?php
  }

  if ($cart->count_contents() > 0) {
?>
    <table cellpadding="0" cellspacing="0" border="0">
	  <tr><td style="padding:0px 10px 0px 10px;" class="smallText"><?php echo TEXT_VISITORS_CART; ?></td></tr>
	</table>

<?php echo tep_pixel_trans();?>
	
<?php
  }
?>
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main indent_2" width="50%"><b><?php echo HEADING_NEW_CUSTOMER; ?></b></td>
			<td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
            <td class="main indent_2" width="50%"><b><?php echo HEADING_RETURNING_CUSTOMER; ?></b></td>
          </tr>
          <tr>
            <td width="50%" height="100%">
				
<?php echo tep_draw_infoBox_top();?>

				<table border="0" width="100%" height="100%" cellspacing="5" cellpadding="0" style="height:240px;">
                  <tr>
                    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td class="main" style="height:100%;"><?php echo TEXT_NEW_CUSTOMER . '<br><br>' . TEXT_NEW_CUSTOMER_INTRODUCTION; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                  </tr>
                  <tr>
                    <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                        <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL') . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      </tr>
                    </table>
					
					</td>
                  </tr>
                </table>
				
<?php echo tep_draw_infoBox_bottom();?>

			</td>
			<td><?php echo tep_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
            <td width="50%" height="100%">
				
<?php echo tep_draw_infoBox_top();?>

				<table border="0" width="100%" height="100%" cellspacing="5" cellpadding="0" style="height:240px;">
                  <tr><td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td></tr>
                  <tr> <td class="main" colspan="2"><?php echo TEXT_RETURNING_CUSTOMER; ?></td></tr>
                  <tr><td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td></tr>
                  <tr><td class="main"><b><?php echo ENTRY_EMAIL_ADDRESS; ?></b></td></tr>
                  <tr><td class="main width3_100"><?php echo tep_draw_input_field('email_address'); ?></td></tr>
                  <tr><td class="main"><b><?php echo ENTRY_PASSWORD; ?></b></td></tr>
                    <td class="main width3_100"><?php echo tep_draw_password_field('password'); ?></td></tr>
                  <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td></tr>
                  <tr><td class="smallText"><?php echo '<a href="' . tep_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?></td></tr>
                  <tr><td height="100%"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td></tr>
                  <tr><td>
                  	<table border="0" width="100%" cellspacing="0" cellpadding="2">
                      <tr>
                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                        <td align="right"><?php echo tep_image_submit('button_login1.gif', IMAGE_BUTTON_LOGIN); ?></td>
                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      </tr>
                    </table>
                  </td></tr>
                </table>
				
<?php echo tep_draw_infoBox_bottom();?>

			</td>
          </tr>
        </table>
	
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
