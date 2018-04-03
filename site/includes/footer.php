<?php
/*
  $Id: footer.php,v 1.26 2003/02/10 22:30:54 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<?php
  require(DIR_WS_INCLUDES . 'counter.php');
?>


	</div>
	<div class="row_4">
				
    	<div class="width_table footer">
<?php   
		if ($tab_sel == 222){
?>	
	<div align="center"><?php include(DIR_WS_BOXES . 'best_sellers_scroller.php');?>
<?php
		}else{
?>		   
        	
<?php
		    }    
?>		
        	<div class="footer_wrapper_tl">
                    <div class="footer_wrapper_tr">
                        <div class="footer_wrapper_rep fs_lh">
                <table cellpadding="0" cellspacing="0" border="0" align="center">
                                <tr>
        
                    <td <?php echo $item_menu_01;?> nowrap="nowrap" onClick="document.location='<?php echo tep_href_link('index.php')?>'"><a><?php printf(BOX_MANUFACTURER_INFO_HOMEPAGE,"")?></a></td>
                    <td class="menu_separator"><?php echo tep_image(DIR_WS_IMAGES.'footer_separator.gif')?></td>
                    <td <?php echo $item_menu_02;?> nowrap="nowrap"  onClick="document.location='<?php echo tep_href_link('products_new.php')?>'"><a><?php echo BOX_HEADING_WHATS_NEW?></a></td>
                    <td class="menu_separator"><?php echo tep_image(DIR_WS_IMAGES.'footer_separator.gif')?></td>
                    <td <?php echo $item_menu_03;?> nowrap="nowrap" onClick="document.location='<?php echo tep_href_link('specials.php')?>'"><a><?php echo BOX_HEADING_SPECIALS?></a></td>
                    <td class="menu_separator"><?php echo tep_image(DIR_WS_IMAGES.'footer_separator.gif')?></td>
<?php if (tep_session_is_registered('customer_id')) { 

 $acc_link = tep_href_link('account.php');
 $acc_title= HEADER_TITLE_MY_ACCOUNT;
} else{ 
 $acc_link = tep_href_link('create_account.php');
 $acc_title= HEADER_TITLE_CREATE_ACCOUNT;
} 
?>                                                           
                    <td <?php echo $item_menu_04;?> nowrap="nowrap" onClick="document.location='<?php echo $acc_link;?>'"><a><?php echo $acc_title;?></a></td>
                    <td class="menu_separator"><?php echo tep_image(DIR_WS_IMAGES.'footer_separator.gif')?></td>                    
                    <td <?php echo $item_menu_06;?> nowrap="nowrap" onClick="document.location='<?php echo tep_href_link('contact_us.php')?>'"><a><?php echo BOX_INFORMATION_CONTACT?></a></td>
                                </tr>

				</table>
                        </div>
                    </div>
                </div>
                <div class="footer2_td"><?php echo FOOTER_TEXT_BODY?>&nbsp;&nbsp;&nbsp;&nbsp; <b><a href="<?php echo tep_href_link('privacy.php')?>"><?php echo BOX_INFORMATION_PRIVACY?></a> &nbsp;|&nbsp; <a href="<?php echo tep_href_link('conditions.php')?>"><?php echo BOX_INFORMATION_CONDITIONS?></a><!––{%FOOTER_LINK} ––></b><br /><strong><a href="http://www.templatemonster.com/oscommerce-templates.php" target="_blank" rel="nofollow">osCommerce template</a></strong>&nbsp;designed by TemplateMonster.com &nbsp;|&nbsp; <strong><a href="http://www.templates.com/product/3d-models/" target="_blank">3D Models</a></strong>&nbsp;provided by Templates.com</div>
           </div>
       </div>
    </div>
<?php
  if ($banner = tep_banner_exists('dynamic', '468x50')) {
?>
    <div>
        <table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><?php echo tep_display_banner('static', $banner); ?></td></tr></table>
    </td></tr>
<?php
  }
?>
	</div>
</div></div>
