<?php
class Perfectus_Megamenu_Model_Mysql4_Setup extends Mage_Eav_Model_Entity_Setup
{
    private $_category_attributes = array(
        'pu_megamenu_menu_type' => array(
            'label' => 'Menu Type',
            'type' => 'varchar',
            'input' => 'select',
            'source' => 'megamenu/category_attribute_source_menutype',
            'default' => '',
            'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => false,
        ),
    );

    public function getDefaultEntities()
    {
        $entities = array();

        $default_attribute_options = array(
            'group' => 'Mega Menu',
            'required' => false,
        );

        /* Build Catalog Attributes */
        $entities['catalog_category'] = array(
            'entity_model' => 'catalog/category',
            'attribute_model' => 'catalog/resource_eav_attribute',
            'table' => 'catalog/category',
            'additional_attribute_table' => 'catalog/eav_attribute',
            'entity_attribute_collection' => 'catalog/category_attribute_collection',
            'attributes' => array(),
        );

        foreach ($this->_category_attributes as $name => $options) {
            /* Override values provided by the defaults */
            $attribute_options = $default_attribute_options;
            foreach ($options as $k => $v) {
                $attribute_options[$k] = $v;
            }
            $entities['catalog_category']['attributes'][$name] = $attribute_options;
        }

        return $entities;
    }
}
