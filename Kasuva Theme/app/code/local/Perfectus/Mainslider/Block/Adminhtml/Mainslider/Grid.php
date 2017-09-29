<?php
class daeon_Mainslider_Block_Adminhtml_Mainslider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("mainsliderGrid");
				$this->setDefaultSort('pslide_id');
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
				$this->setVarNameFilter('product_filter');
		}
		
		protected function _prepareCollection()
		{
				$collection = Mage::getModel("mainslider/mainslider")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("pslide_id", array(
					"header" => Mage::helper("mainslider")->__("ID"),
					"align" =>"right",
					"width" => "50px",
					"type" => "number",
					"index" => "pslide_id",
				));
				
				 $this->addColumn('pslide_image', array(
					'header' => Mage::helper('mainslider')->__('Image'),
					'align' => 'left',
					'type'      => 'text',
					'index' => 'pslide_image',
					'filter'    => false,
					'sortable'  => false,
					'renderer'  => 'mainslider/adminhtml_mainslider_renderer_image',
					'width'     => '200',
				));
				
				$this->addColumn("pslide_name", array(
					"header" => Mage::helper("mainslider")->__("Slide Name"),
					"index" => "pslide_name",
				));
				
						
						
				$this->addColumn('pslide_status', array(
					'header'    => Mage::helper('mainslider')->__('Status'),
					'align'     => 'left',
					'width'     => '80px',
					'index'     => 'pslide_status',
					'type'      => 'options',
					'options'   => array(
						1 => 'Enabled',
						0 => 'Disabled',
					),
				));
						
				$this->addColumn("pslide_order", array(
					"header" => Mage::helper("mainslider")->__("Sort Order"),
					"index" => "pslide_order",
				));
				
				$this->addColumn('created_at', array(
					'header'    => Mage::helper('mainslider')->__('Created At'),
					'align'     => 'left',
					'type'      => 'datetime',
					'time' =>   'true',
					'width'     => '170px',
					'default'   => '--',
					'index'     => 'created_at',
				));
				$this->addColumn('updated_at', array(
					'header'    => Mage::helper('mainslider')->__('Updated At'),
					'align'     => 'left',
					'type'      => 'datetime',
					'width'     => '170px',
					'time' =>   'true',
					'default'   => '--',
					'index'     => 'updated_at',
				));
					
					
				$this->addColumn('action',
					array(
						'header'    =>  Mage::helper('mainslider')->__('Action'),
						'width'     => '100',
						'type'      => 'action',
						'getter'    => 'getId',
						'actions'   => array(
							array(
								'caption'   => Mage::helper('mainslider')->__('Edit'),
								'url'       => array('base'=> '*/*/edit'),
								'field'     => 'id'
							)
						),
						'filter'    => false,
						'sortable'  => false,
						'index'     => 'stores',
						'is_system' => true,
				));
        
				$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
				$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

			return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}
		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('pslide_id');

			$this->getMassactionBlock()->setFormFieldName('mainslider');
			$this->getMassactionBlock()->addItem('delete', array(
				 'label'    => Mage::helper('mainslider')->__('Delete'),
				 'url'      => $this->getUrl('*/*/massDelete'),
				 'confirm'  => Mage::helper('mainslider')->__('Are you sure?')
				));
				
				$statuses = Mage::getSingleton('mainslider/status')->getOptionArray();
				array_unshift($statuses, array('label'=>'', 'value'=>''));
				$this->getMassactionBlock()->addItem('pslide_status', array(
					 'label'=> Mage::helper('mainslider')->__('Change status'),
					 'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
					 'additional' => array(
							'visibility' => array(
								 'name' => 'pslide_status',
								 'type' => 'select',
								 'default'=>2,
								 'class' => 'required-entry',
								 'label' => Mage::helper('mainslider')->__('Status'),
								 'values' => $statuses
							 )
					 )
				));       
			return $this;
		}
		static public function getOptionArray6()
		{
            $data_array=array(); 
			$data_array[0]='Yes';
			$data_array[1]='No';
            return($data_array);
		}
		static public function getValueArray6()
		{
            $data_array=array();
			foreach(daeon_Mainslider_Block_Adminhtml_Mainslider_Grid::getOptionArray6() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);
		}
}
