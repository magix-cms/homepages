CREATE TABLE IF NOT EXISTS `mc_homepages` (
  `id_hs` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `id_pages` int(11) unsigned NOT NULL,
  `order_hs` smallint(3) unsigned NOT NULL default 0,
  PRIMARY KEY (`id_hs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;