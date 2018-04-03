<?php
/*
  $Id: languages.php,v 1.15 2003/06/09 22:10:48 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<div class="width_div">
      <div id="slides-box" class="slides-box-table">
        <div class="container">
            <div id="featured">
               <ul class="ui-tabs-nav">
                  <li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-1"><a href="#fragment-1" class="un"><span><strong>50% Discount Insanity</strong></span></a></li>
                  <li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-2"><a href="#fragment-2"><span><strong>Premium Products</strong></span></a></li>
                  <li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-3"><a href="#fragment-3"><span><strong>Exclusive Offer</strong></span></a></li>
                  <li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-4"><a href="#fragment-4"><span><strong>Red Hot Stuff</strong></span></a></li>
                  <li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-5"><a href="#fragment-5" class="un5"><span><strong>Summertime Discount</strong></span></a></li>
               </ul>
               <!-- First Content -->
               <div id="fragment-1" class="ui-tabs-panel"><?php if ($banner = tep_banner_exists('dynamic', 'banner3')) { echo tep_display_banner('static', $banner); }?></div>
               <!-- Second Content -->
               <div id="fragment-2" class="ui-tabs-panel ui-tabs-hide"><?php if ($banner = tep_banner_exists('dynamic', 'banner4')) { echo tep_display_banner('static', $banner); }?></div>
               <!-- Third Content -->
               <div id="fragment-3" class="ui-tabs-panel ui-tabs-hide"><?php if ($banner = tep_banner_exists('dynamic', 'banner5')) { echo tep_display_banner('static', $banner); }?></div>
               <!-- 4 Content -->
               <div id="fragment-4" class="ui-tabs-panel ui-tabs-hide"><?php if ($banner = tep_banner_exists('dynamic', 'banner6')) { echo tep_display_banner('static', $banner); }?></div>
               <!-- 5 Content -->
               <div id="fragment-5" class="ui-tabs-panel ui-tabs-hide"><?php if ($banner = tep_banner_exists('dynamic', 'banner7')) { echo tep_display_banner('static', $banner); }?></div>               
            </div>
         </div>
      </div>
</div>
               

			


