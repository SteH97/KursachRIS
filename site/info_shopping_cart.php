<?php
/*
  $Id: info_shopping_cart.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require("includes/application_top.php");

  $navigation->remove_current_page();

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_INFO_SHOPPING_CART);
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<?php require(DIR_WS_INCLUDES . 'header_includes.php'); ?>

</head>
<body class="popup_bg">

<table cellpadding="0" cellspacing="0" border="0" align="center" class="popup_width_table"><tr><td align="center" class="popup_width_td">
    <table cellpadding="0" cellspacing="0" border="0" class="popup">
        <tr><td class="popup_1"><a href="#" onClick="window.close()"><?php echo TEXT_CLOSE_WINDOW; ?></a></td></tr>
        <tr><td class="popup_2">
<?php	
  $info_box_contents = array();
  $info_box_contents[] = array('text' => HEADING_TITLE);

  new infoBoxHeading($info_box_contents, false, false);
  
  $info_box_contents = array();
  $info_box_contents[] = array('text' => '
<strong>'.SUB_HEADING_TITLE_1.'</strong>'.SUB_HEADING_TEXT_1.'
<strong>'.SUB_HEADING_TITLE_2.'</strong>'.SUB_HEADING_TEXT_2.'
<strong>'.SUB_HEADING_TITLE_3.'</strong>'.SUB_HEADING_TEXT_3.'');

    new infoBox($info_box_contents);
?>
	    
		</td></tr>
        <tr><td class="footer"><table cellpadding="0" cellspacing="0" border="0"><tr><td class="popup_footer"><?php echo FOOTER_TEXT_BODY; ?></td></tr></table></td></tr>
    </table>
</td></tr></table>

</body>
<?php require(DIR_WS_INCLUDES . 'footer_includes.php'); ?>
</html>
<?php
  require("includes/counter.php");
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
