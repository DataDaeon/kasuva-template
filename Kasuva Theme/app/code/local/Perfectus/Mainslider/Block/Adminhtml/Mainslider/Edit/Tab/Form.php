<?php
class Perfectus_Mainslider_Block_Adminhtml_Mainslider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{
				$form = new Varien_Data_Form();
				$this->setForm($form);
					$fieldset = $form->addFieldset("mainslider_form", array("legend"=>Mage::helper("mainslider")->__("Slide Details")));
					
					$fieldset->addField("pslide_name", "text", array(
						"label" => Mage::helper("mainslider")->__("Name"),
						"name" => "pslide_name",
						"required"=>true,
						"class"=>"required-entry",
					));
					$fieldset->addField('pslide_store_id','multiselect',array(
						'name'      => 'stores[]',
						'label'     => Mage::helper('mainslider')->__('Store View'),
						'title'     => Mage::helper('mainslider')->__('Store View'),
						'required'  => true,
						'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true)
					));
					$fieldset->addField('pslide_image', 'image', array(
						'label' => Mage::helper('mainslider')->__('Image'),
						'name' => 'pslide_image',
						"required"=> true,
						"class"=>"required-entry",
						'note' => '(*.jpg, *.png, *.gif)',
					));
					$fieldset->addField('pslide_type', 'select', array(
						'label'     => Mage::helper('mainslider')->__('Slide Type'),
						'class'     => 'required-entry',
						"required"	=>true,
						'onchange'  => 'checkSelectedItem(this.value)',
						'values'    => 	array(array('value'=>'','label'=>'Select Type'),
										array('value'=>'1','label'=>'Image with Link'),
										array('value'=>'2','label'=>'Image with Content')),
						'name'      => 'pslide_type',
					));
					$fieldset->addField('pslide_cp', 'select', array(
						'label'     => Mage::helper('mainslider')->__('Content Position'),
						'class'     => '',
						"required"	=> false,
						'onchange'  => 'checkCPItem(this.value)',
						'values'    => 	array(array('value'=>'','label'=>'Select Type'),
										array('value'=>'cp-left','label'=>'Left'),
										array('value'=>'cp-center','label'=>'Center'),
										array('value'=>'cp-right','label'=>'Right'),
										array('value'=>'cp-custom','label'=>'Custom')),
						'name'      => 'pslide_cp',
					));
					$fieldset->addField("pslide_cptop", "text", array(
						"label" => Mage::helper("mainslider")->__("Content Position Top"),
						"after_element_html" => '<small>%</small>',
						'style'   => "width:50px;",
						"name" => "pslide_cptop",
					));
					$fieldset->addField("pslide_cpleft", "text", array(
						"label" => Mage::helper("mainslider")->__("Content Position Left"),
						"after_element_html" => '<small>%</small>',
						'style'   => "width:50px;",
						"name" => "pslide_cpleft",
					));
					$fieldset->addField("pslide_content", "textarea", array(
						"label" => Mage::helper("mainslider")->__("Content"),
						"name" => "pslide_content",
						'style'   => "width:600px;height:200px;",
					));
					$fieldset->addField("pslide_link", "text", array(
						"label" => Mage::helper("mainslider")->__("Link"),
						"name" => "pslide_link",
					));
					$fieldset->addField('pslide_status', 'select', array(
					  'label'     => Mage::helper('mainslider')->__('Status'),
					  'name'      => 'pslide_status',
					  "required"=>true,
					  'values'    => array(
						  array(
							  'value'     => 1,
							  'label'     => Mage::helper('mainslider')->__('Enabled'),
						  ),

						  array(
							  'value'     => 0,
							  'label'     => Mage::helper('mainslider')->__('Disabled'),
						  ),
					  ),
				  ));
					
				$fieldset->addField("pslide_order", "text", array(
					"label" => Mage::helper("mainslider")->__("Sort Order"),
					"class"=>"validate-number",
					"name" => "pslide_order",
				));
				
				$fieldset->addField("created_at", "hidden", array(
						"label" => Mage::helper("mainslider")->__("Created At"),
						"name" => "created_at",
				));
				$pslide_type=$fieldset->addField("updated_at", "hidden", array(
						"label" => Mage::helper("mainslider")->__("Updated At"),
						"name" => "updated_at",
				));
				$pslide_type->setAfterElementHtml('
                        <script>
						function selectedvariationhide(){
							document.getElementById("pslide_cptop").parentNode.parentNode.style.display="none";
							document.getElementById("pslide_cpleft").parentNode.parentNode.style.display="none";
							document.getElementById("pslide_content").parentNode.parentNode.style.display="none";
							document.getElementById("pslide_link").parentNode.parentNode.style.display="none";
						}
						selectedvariationhide();
                        function checkSelectedItem(val){
							if(val==1){
								document.getElementById("pslide_cp").parentNode.parentNode.style.display="none";
								document.getElementById("pslide_content").parentNode.parentNode.style.display="none";
								document.getElementById("pslide_link").parentNode.parentNode.style.display="";
							}else if(val==2){
								document.getElementById("pslide_cp").parentNode.parentNode.style.display="";
								document.getElementById("pslide_content").parentNode.parentNode.style.display="";
								document.getElementById("pslide_link").parentNode.parentNode.style.display="none";
							}else{
								selectedvariationhide();
							}
							
                        }
						function checkCPItem(val){
							if(val=="cp-custom"){
								document.getElementById("pslide_cptop").parentNode.parentNode.style.display="";
								document.getElementById("pslide_cpleft").parentNode.parentNode.style.display="";
							}else{
								document.getElementById("pslide_cptop").parentNode.parentNode.style.display="none";
								document.getElementById("pslide_cpleft").parentNode.parentNode.style.display="none";
							}
						}
						var pslidetype=document.getElementById("pslide_type");
						var pslidecp=document.getElementById("pslide_cp");
						if(pslidetype[pslidetype.selectedIndex].value){
							checkSelectedItem(pslidetype[pslidetype.selectedIndex].value);
							checkCPItem(pslidecp[pslidecp.selectedIndex].value);
						}
						
                        </script>
                    ');
				
				if (Mage::getSingleton("adminhtml/session")->getMainsliderData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getMainsliderData());
					Mage::getSingleton("adminhtml/session")->setMainsliderData(null);
				} 
				elseif(Mage::registry("mainslider_data")) {
				    $form->setValues(Mage::registry("mainslider_data")->getData());
				}
				return parent::_prepareForm();
		}
}
