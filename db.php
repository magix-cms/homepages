<?php
class plugins_homepages_db
{
    /**
     * @var debug_logger $logger
     */
    protected debug_logger $logger;
    /**
     * @param array $config
     * @param array $params
     * @return array|bool
     */
    public function fetchData(array $config, array $params = []) {

		if ($config['context'] === 'all') {
			switch ($config['type']) {
				case 'mss':
					$query = "SELECT 
								hs.id_hs,
								hs.id_pages, 
								pc.name_pages as name_hs
							FROM mc_homepages as hs
							LEFT JOIN mc_cms_page as p ON (hs.id_pages = p.id_pages)
							LEFT JOIN mc_cms_page_content as pc ON (p.id_pages = pc.id_pages AND pc.id_lang = :id_lang)
							ORDER BY hs.order_hs ASC";
					break;
				case 'pages':
					$query = 'SELECT mcp.id_pages AS id, mcp.id_parent AS parent, mcpc.name_pages AS name 
                    FROM mc_cms_page AS mcp 
                    LEFT JOIN mc_cms_page_content AS mcpc USING ( id_pages ) 
                    LEFT JOIN mc_lang as ml ON (mcpc.id_lang = ml.id_lang) 
                    WHERE ml.id_lang = :default_lang AND mcp.menu_pages = 1
							AND mcpc.published_pages = 1
							ORDER BY mcp.id_pages';
					break;
				case 'order':
					$query = 'SELECT
								id_pages,
								order_hs
							FROM mc_homepages ORDER BY order_hs ASC';
					break;
                default:
                    return false;
            }

            try {
                return component_routing_db::layer()->fetchAll($query, $params);
            }
            catch (Exception $e) {
                if(!isset($this->logger)) $this->logger = new debug_logger(MP_LOG_DIR);
                $this->logger->log('statement','db',$e->getMessage(),$this->logger::LOG_MONTH);
            }
		}
		elseif ($config['context'] === 'one') {
			switch ($config['type']) {
				case 'newHs':
					$query = "SELECT 
								hs.id_hs,
								hs.id_pages, 
								pc.name_pages as name_hs
							FROM mc_homepages as hs
							LEFT JOIN mc_cms_page as p ON (hs.id_pages = p.id_pages)
							LEFT JOIN mc_cms_page_content as pc ON (p.id_pages = pc.id_pages AND pc.id_lang = :id_lang)
							ORDER BY hs.order_hs DESC LIMIT 0,1";
					break;
				case 'homeMsp':
					$query = "SELECT 
								GROUP_CONCAT(`id_pages` ORDER BY order_hs SEPARATOR ',') as hsids
						  	FROM mc_homepages";
					break;
                default:
                    return false;
            }

            try {
                return component_routing_db::layer()->fetch($query, $params);
            }
            catch (Exception $e) {
                if(!isset($this->logger)) $this->logger = new debug_logger(MP_LOG_DIR);
                $this->logger->log('statement','db',$e->getMessage(),$this->logger::LOG_MONTH);
            }
        }
        return false;
	}

    /**
     * @param array $config
     * @param array $params
     * @return bool|string
     */
    public function insert(array $config, array $params = []) {

		switch ($config['type']) {
			case 'homepages':
				$query = 'INSERT INTO mc_homepages (id_pages,  order_hs)  
						SELECT :id, COUNT(order_hs) FROM mc_homepages';
				break;
            default:
                return false;
        }

        try {
            component_routing_db::layer()->insert($query,$params);
            return true;
        }
        catch (Exception $e) {
            return 'Exception reçue : '.$e->getMessage();
        }
	}

    /**
     * @param array $config
     * @param array $params
     * @return bool|string
     */
    public function update(array $config, array $params = []) {

		switch ($config['type']) {
			case 'order':
				$query = 'UPDATE mc_homepages 
						SET order_hs = :order_hs
						WHERE id_hs = :id_hs';
				break;
            default:
                return false;
        }

        try {
            component_routing_db::layer()->update($query,$params);
            return true;
        }
        catch (Exception $e) {
            return 'Exception reçue : '.$e->getMessage();
        }
	}

	/**
	 * @param $config
	 * @param array $params
	 * @return bool|string
	 */
	public function delete($config, $params = array())
	{
		if (!is_array($config)) return '$config must be an array';
			$query = '';

			switch ($config['type']) {
				case 'homepages':
					$query = 'DELETE FROM mc_homepages
							WHERE id_hs = :id';
					break;
			}

		if($query === '') return 'Unknown request asked';

		try {
			component_routing_db::layer()->delete($query,$params);
			return true;
		}
		catch (Exception $e) {
			return 'Exception reçue : '.$e->getMessage();
		}
	}
}