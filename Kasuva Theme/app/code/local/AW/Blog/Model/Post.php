<?php
class AW_Blog_Model_Post extends Mage_Core_Model_Abstract
{
    const NOROUTE_PAGE_ID = 'no-route';

    protected function _construct()
    {
        $this->_init('blog/post');
    }

    public function load($id, $field = null)
    {
        return $post = parent::load($id, $field);
    }

    public function noRoutePage()
    {
        $this->setData($this->load(self::NOROUTE_PAGE_ID, $this->getIdFieldName()));
        return $this;
    }

    public function getShortContent()
    {
        $content = $this->getData('short_content');
        if (Mage::getStoreConfig(AW_Blog_Helper_Config::XML_BLOG_PARSE_CMS)) {
            $processor = Mage::getModel('core/email_template_filter');
            $content = $processor->filter($content);
        }
        return $content;
    }

    public function getPostContent()
    {
        $content = $this->getData('post_content');
        if (Mage::getStoreConfig(AW_Blog_Helper_Config::XML_BLOG_PARSE_CMS)) {
            $processor = Mage::getModel('core/email_template_filter');
            $content = $processor->filter($content);
        }
        return $content;
    }

    public function getCategoriesForPosts($posts = array())
    {
        return $this->getResource()->getCategoriesForPost($posts);

    }

    public function loadByIdentifier($v)
    {
        return $this->load($v, 'identifier');
    }

    public function getCats()
    {
        $route = Mage::getStoreConfig('blog/blog/route');
        if ($route == "") {
            $route = "blog";
        }
        $route = Mage::getUrl($route);

        $cats = Mage::getModel('blog/cat')->getCollection()
            ->addPostFilter($this->getId())
            ->addStoreFilter(Mage::app()->getStore()->getId())
        ;

        $catUrls = array();
        foreach ($cats as $cat) {
            $catUrls[$cat->getTitle()] = $route . "cat/" . $cat->getIdentifier();
        }
        return $catUrls;
    }
	public function resizeImg($fileName, $width, $height = '')
	{
		$folderURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."blog".DS;
		$imageURL = $folderURL . $fileName;
		$resizedir=$width.'x'.$height;
		$basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA).DS."blog".DS.$fileName;
		$newPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA).DS."blog".DS. $resizedir . DS . $fileName;
		//if width empty then return original size image's URL
		if ($width != '') {
			//if image has already resized then just return URL
			if (file_exists($basePath) && is_file($basePath) && !file_exists($newPath)) {
				$imageObj = new Varien_Image($basePath);
				$imageObj->constrainOnly(TRUE);
				$imageObj->keepAspectRatio(true);
				$imageObj->keepFrame(FALSE);
				$imageObj->resize($width, $height);
				$imageObj->save($newPath);
			}
			$resizedURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."blog".DS. $resizedir . DS . $fileName;
		 } else {
			$resizedURL = $imageURL;
		 }
		 return $resizedURL;
	}
}