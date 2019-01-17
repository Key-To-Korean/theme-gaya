<?php
/**
 * @link https://wpadvancedads.com/codex/ad-placeholder/
 */
/**
 * Medium Rectangle - 300 x 250
 */
function wprig_ad_rectangle() {
  echo '<div style="width: 300px; height: 250px; background: #428bca; color: #fff; line-height: 250px; text-align: center; ">MEDIUM RECTANGLE</div>';
}

/**
 * Leaderboard - 728 x 90
 */
function wprig_ad_leaderboard() {
  echo '<div style="width: 728px; height: 90px; background: #428bca; color: #fff; line-height: 90px; text-align: center; ">LEADERBOARD</div>';
}

/**
 * Full Banner - 468 x 60
 */
function wprig_ad_banner() {
  echo '<div style="width: 468px; height: 60px; background: #428bca; color: #fff; line-height: 60px; text-align: center; ">FULL BANNER</div>';
}

/**
 * Mobile Banner - 320 x 50
 */
function wprig_ad_mobile() {
  echo '<div style="width: 320px; height: 50px; background: #428bca; color: #fff; line-height: 50px; text-align: center; ">MOBILE BANNER</div>';
}

/**
 * Wide Skyscraper = 600 x 160
 */
function wprig_ad_skyscraper() {
  echo '<div style="width: 160px; height: 600px; background: #428bca; color: #fff; line-height: 600px; text-align: center; ">SKYSCRAPER</div>';
}

/**
 * Placeholder Image URL
 */
function wprig_get_placeholder_image_url() {
  // return get_template_directory_uri() . '/images/contemporary_china.png';
  return '';
}

/**
 * Placeholder Image
 */
// function wprig_get_placeholder_image() {
//   echo '<img src="' . wprig_get_placeholder_image_url() . '" />';
// }