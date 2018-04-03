<?php
/*
  $Id: best_sellers.php,v 1.21 2003/06/09 22:07:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
    $best_sellers_scroll_query = tep_db_query("select distinct p.products_id, pd.products_description, p.products_image, p.products_price, p.products_tax_class_id, pd.products_name from " . 			 	TABLE_PRODUCTS . " p, " . 
	TABLE_PRODUCTS_DESCRIPTION . " pd, " . 
	TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . 
	TABLE_CATEGORIES . " c where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . 
	(int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and '" . 
	(int)$current_category_id . "' in (c.categories_id, c.parent_id) order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS_SLIDER);
	

?>
<?php
    $info_box_contents = array();
    $info_box_contents[] = array('text' => BOX_HEADING_BESTSELLERS_TITLE);

    new infoBoxHeadingTitle($info_box_contents, false, false);
?>	

<div class="carousel-box main">
    <div class="inner">
        <button class="prev"></button>
        <button class="next"></button>
        <div class="carousel">
            <ul>
<?php 
	$rows = 0;
	$count = 0;

	
    while ($best_sellers = tep_db_fetch_array($best_sellers_scroll_query)) {
	
	$name_prod = '<b><a href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers['products_id']).'">'.$best_sellers['products_name'].'</a></b>';
	
	$pic_prod = '<a href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers['products_id']).'">'.tep_image(DIR_WS_IMAGES . $best_sellers['products_image'], $best_sellers['products_name'], BESTSELLERS_IMAGE_WIDTH, BESTSELLERS_IMAGE_HEIGHT).'</a>';
	
	$p_buy_now = '<a href="'.tep_href_link("products_new.php","action=buy_now&products_id=".$best_sellers['products_id']).'">'.tep_image_button('button_add_to_cart1.gif', '', '').'</a>';
	
	$p_details = '<a href="' . tep_href_link('product_info.php?products_id='.$best_sellers['products_id']) . '">'.tep_image_button('button_details.gif', '', '').'</a>';
	
	$p_desc = ''.substr(strip_tags($best_sellers['products_description']), 0, MAX_DESCR_1).' ...';
	
	$best_sellers['specials_new_products_price'] = tep_get_products_special_price($best_sellers['products_id']);
									
	if (tep_not_null($best_sellers['specials_new_products_price'])) {
      
	  
	  
	  $best_sellers_price = '<span class="productSpecialPrice">' . $currencies->display_price($best_sellers['specials_new_products_price'], tep_get_tax_rate($best_sellers['products_tax_class_id'])) . '</span> ';
	  
	  
    } else {
      $best_sellers_price = '<span class="productSpecialPrice">'.$currencies->display_price($best_sellers['products_price'], tep_get_tax_rate($best_sellers['products_tax_class_id'])).'</span>';}									
	
	
?>
                                     				
                    <li>
                        <div class="div">
	<table cellpadding="0" cellspacing="0" border="0" class="wrapper_box ie_width">
		<tr><td class="pic2_padd"><?php echo $pic_prod;?></td>
        	<td style="width:100%;">
            	<table cellpadding="0" cellspacing="0" border="0">
                	<tr><td class="name name_2_padd"><?php echo $name_prod;?></td></tr>
                    <tr><td class="price_2_padd"><?php echo $p_price;?></td></tr>
                </table>
            </td>
        </tr>
	</table>									   
                       </div>		
                    </li>
<?php
	}
?>
                    
           </ul>
        </div>
    </div>
</div>


				
