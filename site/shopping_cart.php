<?php
/*
  $Id: shopping_cart.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  require("includes/application_top.php");

  if ($cart->count_contents() > 0) {
    include(DIR_WS_CLASSES . 'payment.php');
    $payment_modules = new payment;
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SHOPPING_CART);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SHOPPING_CART));
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<?php require(DIR_WS_INCLUDES . 'header_includes.php'); ?>

</head>
<body>
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
    <td class="<?php echo CONTENT_WIDTH_TD; ?>"><?php include(DIR_WS_BOXES . 'panel_top.php');?><?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_SHOPPING_CART, 'action=update_product')); ?>
	
<?php echo tep_draw_top();?>

<?php echo tep_draw_title_top();?>

				<?php echo HEADING_TITLE; ?>
			
<?php echo tep_draw_title_bottom();?>


<?php echo tep_draw4_top();?>
<?php
  if ($cart->count_contents() > 0) {
?>
								


<?php
    $info_box_contents = array();
    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => ' class="s_cart_head s_cart_head_padd remove"',
                                    'text' => ''.TABLE_HEADING_REMOVE.'');

    $info_box_contents[0][] = array('align' => 'center',
									'params' => ' class="s_cart_head s_cart_head_padd products"',
                                    'text' => ''.TABLE_HEADING_PRODUCTS.'');

    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => ' class="s_cart_head s_cart_head_padd quantity"',
                                    'text' => ''.TABLE_HEADING_QUANTITY.'');

    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => ' class="s_cart_head s_cart_head_padd total"',
                                    'text' => ''.TABLE_HEADING_TOTAL.'');
									
    $any_out_of_stock = 0;
    $products = $cart->get_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
// Push all attributes information in an array
      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        while (list($option, $value) = each($products[$i]['attributes'])) {
          echo tep_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
          $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                                      from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                      where pa.products_id = '" . (int)$products[$i]['id'] . "'
                                       and pa.options_id = '" . (int)$option . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . (int)$value . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . (int)$languages_id . "'
                                       and poval.language_id = '" . (int)$languages_id . "'");
          $attributes_values = tep_db_fetch_array($attributes);

          $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
          $products[$i][$option]['options_values_id'] = $value;
          $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
          $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
          $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
        }
      }
    }

    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      if (($i/2) == floor($i/2)) {
        $info_box_contents[] = array('params' => '');
      } else {
        $info_box_contents[] = array('params' => '');
      }

      $cur_row = sizeof($info_box_contents) - 1;
	  $p_cart_pic	= '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '">' . tep_image(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>';
      $info_box_contents[$cur_row][] = array('align' => 'center',
                                             'params' => ' class="s_cart_td"',
                                             'text' => tep_draw_checkbox_field('cart_delete[]', $products[$i]['id']));

      $products_name = '
	  
	<table cellpadding="0" cellspacing="10" border="0">
		<tr><td class="name name3_padd"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '">' . $products[$i]['name'] . '</a></td></tr>
		<tr><td class="pic3_padd">'.tep_draw_prod_pic_top().''.$p_cart_pic.''.tep_draw_prod_pic_bottom().'</td></tr>';
				
      if (STOCK_CHECK == 'true') {
        $stock_check = tep_check_stock($products[$i]['id'], $products[$i]['quantity']);
        if (tep_not_null($stock_check)) {
          $any_out_of_stock = 1;

          $products_name .= $stock_check;
        }
      }

      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        reset($products[$i]['attributes']);
          $products_name .= '<tr><td style="width:100%;" align="center">';		
        while (list($option, $value) = each($products[$i]['attributes'])) {				
				
          $products_name .= '<i> - ' . $products[$i][$option]['products_options_name'] . ' ' . $products[$i][$option]['products_options_values_name'] . '</i><br><br>';
        }
          $products_name .= '</td></tr>';		
      }

      $products_name .= '</table><br>';

      $info_box_contents[$cur_row][] = array('params' => '',
                                             'text' => $products_name);

      $info_box_contents[$cur_row][] = array('align' => 'center',
                                             'params' => 'class="s_cart_td"',
                                             'text' => tep_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="2" class="input"') . tep_draw_hidden_field('products_id[]', $products[$i]['id']));

      $info_box_contents[$cur_row][] = array('align' => 'center',
                                             'params' => 'class="s_cart_td"',
                                             'text' => '<span class="productSpecialPrice">' . $currencies->display_price($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) . '</span>');
    }

    new productListingBox($info_box_contents);
?>

<?php
    if ($any_out_of_stock == 1) {
      if (STOCK_ALLOW_CHECKOUT == 'true') {
?>
<div class="cart_line_x padd2_gg"><?php echo tep_draw_separator('spacer.gif', '1', '1'); ?></div>     
	  <table cellpadding="0" cellspacing="0" border="0">
	  	<tr><td class="stockWarning" align="center"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></td></tr>
	  </table>
<?php
      } else {
?>
<div class="cart_line_x padd2_gg"><?php echo tep_draw_separator('spacer.gif', '1', '1'); ?></div>
      <table cellpadding="0" cellspacing="0" border="0">
	  	<tr><td class="stockWarning" align="center"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></td></tr>
	  </table>
<?php
      }
    }
?>
				
<?php  /* echo tep_draw_infoBox2_top(); */ ?>

<div class="cart_line_x padd2_gg"><?php echo tep_draw_separator('spacer.gif', '1', '1'); ?></div>
			
				<table cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td width="80%" align="right" class="cart_total_left"><?php echo SUB_TITLE_SUB_TOTAL; ?></td>
						<td width="20%" align="center" class="cart_total_right main">														
							<span class="productSpecialPrice"><?php echo $currencies->format($cart->show_total()); ?></span>
						</td>
					</tr>
				</table>

<div class="cart_line_x padd2_gg"><?php echo tep_draw_separator('spacer.gif', '1', '1'); ?></div>
						
				<table cellspacing="0" cellpadding="0" border="0" >
					<tr>
						<td class="cart_button_padd button2_marg bg_input"><?php echo tep_image_submit('button_update_cart1.gif', IMAGE_BUTTON_UPDATE_CART); ?>&nbsp; <?php
				
    		$back = sizeof($navigation->path)-2;
    			if (isset($navigation->path[$back])) {
				echo '<a href="' . tep_href_link($navigation->path[$back]['page'], tep_array_to_string($navigation->path[$back]['get'], array('action')), $navigation->path[$back]['mode']) . '">' . tep_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>'; 
				}
				?>&nbsp; <?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . tep_image_button('button_checkout1.gif', IMAGE_BUTTON_CHECKOUT) . '</a>'; ?></td>
					</tr>
				</table>	
				
<?php  /* echo tep_draw_infoBox2_bottom(); */ ?>
		
<?php
    $initialize_checkout_methods = $payment_modules->checkout_initialization_method();

    if (!empty($initialize_checkout_methods)) {
?>
    <table cellpadding="0" cellspacing="0" border="0">
	  <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main" style="padding-right:50px;"><?php echo TEXT_ALTERNATIVE_CHECKOUT_METHODS; ?></td>
      </tr>
<?php
      reset($initialize_checkout_methods);
      while (list(, $value) = each($initialize_checkout_methods)) {
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo $value; ?></td>
      </tr>
	</table>


    
<?php
      }
    }
    }else {
?>


<?php echo tep_draw2_top();?>

				<table cellpadding="0" cellspacing="0" class="main">
					<tr><td style="padding:25px 20px 20px 20px;"><?php echo TEXT_CART_EMPTY ?></td></tr>
				</table>


<?php /* new infoBox_search_criteria(array(array('text' => ''.TEXT_CART_EMPTY))); */ ?>

<?php echo tep_draw2_bottom();?>

<?php echo tep_pixel_trans();?>
				
<?php /*  echo tep_draw_infoBox2_top();  */?>

			<table border="0" width="100%" cellspacing="0" cellpadding="2"><tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td align="right" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table>
			
<?php  /* echo tep_draw_infoBox2_bottom(); */ ?>

<?php
  }
?>
<?php echo tep_draw4_bottom();?>
      		
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
