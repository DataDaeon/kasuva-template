<?php
$installer = $this;
$installer->startSetup();
$installer->run("
CREATE TABLE IF NOT EXISTS {$this->getTable('perfectus_mainslider')} (
	`pslide_id` int(11) unsigned NOT NULL auto_increment,
	`pslide_name` varchar(255),
	`pslide_image` varchar(255),
	`pslide_type` varchar(255),
	`pslide_cp` varchar(255),
	`pslide_cptop` int(11),
	`pslide_cpleft` int(11),
	`pslide_content` text,
	`pslide_link` text,
	`pslide_order` int(11),
	`pslide_status` int(11),
	`created_at` datetime,
	`updated_at` datetime,
	`pslide_store_id` int(11) NOT NULL,
	primary key(pslide_id));
");

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('perfectus_mainslider_store')};
CREATE TABLE {$this->getTable('perfectus_mainslider_store')} (                                
 `pslide_id` int(11) NOT NULL,                               
 `pslide_store_id` smallint(5) unsigned NOT NULL,                    
 PRIMARY KEY  (`pslide_id`,`pslide_store_id`),                      
 KEY `FK_BANNERS_STORE_STORE` (`pslide_store_id`)                    
);
");

try {
$installer->run("
	INSERT INTO `perfectus_mainslider` (`pslide_name`, `pslide_image`, `pslide_type`, `pslide_cp`, `pslide_cptop`, `pslide_cpleft`, `pslide_content`, `pslide_link`, `pslide_order`, `pslide_status`, `created_at`, `updated_at`, `pslide_store_id`) VALUES
('Fashion Slide 1', 'mf1.jpg', '2', 'cp-center', 0, 0, '<div class=\"caption vertical-center text-center style1\">\r\n<div class=\"big-text animate\" data-animation=\"fadeInDown\">Sale!</div>\r\n<div class=\"excerpt animate\" data-animation=\"fadeInDown\" data-delay=\"0.2s\" >Save up to <span class=\"theme--color\">25%</span> off</div>\r\n<div class=\"button-holder  animate\" data-animation=\"fadeInDown\" data-delay=\"0.5s\">\r\n<a href=\"#\" class=\"big btn btn-primary btn-black btn-flat\">check now</a>\r\n</div>\r\n</div>', NULL, 1, 1, '2017-07-28 12:42:18', '2017-07-28 12:42:18', 0),
('Fashion Slide 2', 'mf2.jpg', '2', 'cp-left', 0, 0, '<div class=\"caption vertical-center text-left style2 animate\" data-animation=\"lightSpeedIn\">\r\n					<div class=\"big-text\">\r\n						The new <span class=\"highlight theme--color\">imac</span> for you\r\n					</div>\r\n\r\n					<div class=\"excerpt\">\r\n					\r\n					<span>21.5-Inch Now Starting At $1099 </span>\r\n					<span>27-Inch Starting At $1799</span>\r\n					</div>\r\n					<div class=\"button-holder\">\r\n						<a href=\"#\" class=\"btn-lg btn btn-uppercase btn-primary shop-now-button\">Shop Now</a>\r\n					</div>\r\n				</div>', NULL, 2, 1, '2017-07-28 12:43:40', '2017-07-29 03:51:38', 0),
('Fashion Slide 3', 'mf3.jpg', '2', 'cp-right', 0, 0, '<div class=\"caption vertical-center text-right style3 animate\" data-animation=\"slideInRight\">\r\n	<div class=\"mid-text text-white\"><em>A great selection of superb brands </em></div>\r\n	<div class=\"big-text-bold text-white fntuc-head\">50% off</div>\r\n	<div class=\"excerpt\">\r\n		<span class=\"tp-caption3 text-white\">ON ALL CLOTHES</span>\r\n	</div>\r\n	<div class=\"button-holder\">\r\n		<a href=\"#\" class=\"btn-lg btn btn-uppercase btn-primary btn-white shop-now-button\">Shop Now</a>\r\n	</div>\r\n</div>', NULL, 3, 1, '2017-07-28 12:44:36', '2017-07-29 03:51:24', 0),
('Furniture Slide 1', 'fb1.jpg', '2', 'cp-right', 0, 0, '<div class=\"caption vertical-center text-right style3\" >\r\n	<div class=\"animate text-white fntuc-style1\" data-animation=\"fadeIn\" data-delay=\"0.2s\" data-duration=\"0.6s\" style=\"font-size:49px;\">SALE OFF</div>\r\n	<div class=\"animate text-white fntuc-gen\" data-animation=\"fadeIn\" data-delay=\"0.4s\" data-duration=\"0.6s\" style=\"font-size:24px;margin-bottom:10px;\">NEW COLLECTION </div>\r\n	<div class=\"animate text-white fntuc-gen\" data-animation=\"fadeIn\" data-delay=\"0.6s\" data-duration=\"0.6s\" style=\"\">\r\n		<span class=\"tp-caption2\" style=\"letter-spacing:1px;\">Quisque tempor felis hendrerit, lobortis nibh <br> vitae, dignissim justo. </span>\r\n	</div>\r\n	<div class=\"button-holder animate\" data-animation=\"fadeIn\" data-delay=\"0.6s\" data-duration=\"0.6s\">\r\n		<a href=\"#\" class=\"btn-lg btn btn-uppercase btn-primary btn-white shop-now-button\">Show More</a>\r\n	</div>\r\n</div>', NULL, 1, 1, '2017-07-29 03:46:51', '2017-08-14 10:27:43', 0),
('Furniture Slide 2', 'fb2.jpg', '2', 'cp-right', 0, 0, '<div class=\"caption vertical-center text-right style3\" style=\"width:120%;\">\r\n	<div class=\"animate text-white fntuc-style1\" data-animation=\"fadeIn\" data-delay=\"0.2s\" data-duration=\"0.6s\" style=\"font-size:31px;padding:10px;background-color:rgb(191, 191, 193);text-align:left;margin-bottom:10px;\">THE NEW IMS CHAIR </div>\r\n	<div class=\"animate text-white fntuc-gen\" data-animation=\"fadeIn\" data-delay=\"0.4s\" data-duration=\"0.6s\" style=\"font-size:18px;margin-bottom:10px;padding:10px;background-color:rgb(191, 191, 193);text-align:left;max-width:85%;\">Sed ut perspiciatis unde omnis</div>\r\n	<div class=\"animate text-white fntuc-gen\" data-animation=\"fadeIn\" data-delay=\"0.4s\" data-duration=\"0.6s\" style=\"font-size:16px;margin-bottom:10px;padding:10px;background-color:rgb(191, 191, 193);text-align:left;max-width:70%;\">Unde omnis iste natusets </div>\r\n	<div class=\"animate\" data-animation=\"fadeIn\" data-delay=\"0.6s\" data-duration=\"0.6s\" style=\"text-align:left;\">\r\n		<a href=\"#\" class=\"btn btn-uppercase btn-primary btn-flat btn-hover\">SHOW MORE</a>\r\n	</div>\r\n</div>', NULL, 2, 1, '2017-07-29 03:52:59', '2017-07-29 06:20:39', 0),
('Electricle Slide 1', 'es1.jpg', '2', 'cp-custom', 15, 1, '<div class=\"caption vertical-center text-right style3\" >\r\n	<div class=\"animate fntuc-style1 fnt42\" data-animation=\"fadeIn\" data-delay=\"0.2s\" data-duration=\"0.6s\">SAMSUNG</div>\r\n	<div class=\"animate fntuc-gen fnt25 theme--color\" data-animation=\"fadeIn\" data-delay=\"0.4s\" data-duration=\"0.6s\">GALAXY NOTE 10.2</div>\r\n	<div class=\"animate fntuc-gen\" data-animation=\"fadeIn\" data-delay=\"0.6s\" data-duration=\"0.6s\" style=\"\">\r\n		<span class=\"tp-caption2\" style=\"letter-spacing:1px;\">Quisque tempor felis hendrerit, lobortis nibh <br> vitae, dignissim justo. </span>\r\n	</div>\r\n	<div class=\"button-holder animate\" data-animation=\"fadeIn\" data-delay=\"0.6s\" data-duration=\"0.6s\">\r\n		<a href=\"#\" class=\"btn-lg btn btn-uppercase btn-primary shop-now-button\">Show More</a>\r\n	</div>\r\n</div>', NULL, 1, 1, '2017-08-14 10:18:08', '2017-08-14 11:38:04', 0),
('Electricle Slide 2', 'es3.jpg', '2', 'cp-custom', 15, 5, '<div class=\"caption vertical-center text-center style3\" >\r\n	<div class=\"animate fntuc-style1 fnt42\" data-animation=\"fadeIn\" data-delay=\"0.2s\" data-duration=\"0.6s\">MACBOOK PRO</div>\r\n	<div class=\"animate fntuc-gen fnt25 theme--color\" data-animation=\"fadeIn\" data-delay=\"0.4s\" data-duration=\"0.6s\">THE MACBOOK PEOPLE LOVE</div>\r\n	<div class=\"animate fntuc-gen\" data-animation=\"fadeIn\" data-delay=\"0.6s\" data-duration=\"0.6s\" style=\"\">\r\n		<span class=\"tp-caption2\" style=\"letter-spacing:1px;\">Quisque tempor felis hendrerit, lobortis nibh <br> vitae, dignissim justo. </span>\r\n	</div>\r\n	<div class=\"button-holder animate\" data-animation=\"fadeIn\" data-delay=\"0.6s\" data-duration=\"0.6s\">\r\n		<a href=\"#\" class=\"btn-lg btn btn-uppercase btn-primary shop-now-button\">Show More</a>\r\n	</div>\r\n</div>', NULL, 0, 1, '2017-08-14 11:41:14', '2017-08-14 11:42:39', 0),
('Electricle Slide 3', 'es2.jpg', '2', 'cp-right', 15, 5, '<div class=\"caption vertical-center text-right style3\" style=\"width:120%;\">\r\n	<div class=\"animate text-white fntuc-style1\" data-animation=\"fadeIn\" data-delay=\"0.2s\" data-duration=\"0.6s\" style=\"font-size:31px;padding:10px;background-color:rgb(191, 191, 193);text-align:left;margin-bottom:10px;\">THE NEW IMS CHAIR </div>\r\n	<div class=\"animate text-white fntuc-gen\" data-animation=\"fadeIn\" data-delay=\"0.4s\" data-duration=\"0.6s\" style=\"font-size:18px;margin-bottom:10px;padding:10px;background-color:rgb(191, 191, 193);text-align:left;max-width:85%;\">Sed ut perspiciatis unde omnis</div>\r\n	<div class=\"animate text-white fntuc-gen\" data-animation=\"fadeIn\" data-delay=\"0.4s\" data-duration=\"0.6s\" style=\"font-size:16px;margin-bottom:10px;padding:10px;background-color:rgb(191, 191, 193);text-align:left;max-width:70%;\">Unde omnis iste natusets </div>\r\n	<div class=\"animate\" data-animation=\"fadeIn\" data-delay=\"0.6s\" data-duration=\"0.6s\" style=\"text-align:left;\">\r\n		<a href=\"#\" class=\"btn btn-uppercase btn-primary btn-flat btn-hover\">SHOW MORE</a>\r\n	</div>\r\n</div>', NULL, 3, 1, '2017-08-14 11:44:56', '2017-08-14 11:45:40', 0);
");
} catch (Exception $e) {
    Mage::logException($e);
}
$installer->endSetup();