<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class CustomHTML extends Module
{
    public function __construct()
    {
        $this->name = 'CustomHTML';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'AutomaticHouseSystems';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Custom HTML');
        $this->description = $this->l('Add custom HTML anywhere in your shop');
    }

    public function install()
    {
		return parent::install() 
			&& $this->registerHook('displayHome')
			&& $this->registerHook('displayFooter')
			&& $this->registerHook('displayLeftColumn')
			&& $this->registerHook('displayRightColumn')
			&& Configuration::updateValue('CUSTOM_HTML_HOME', '')
			&& Configuration::updateValue('CUSTOM_HTML_FOOTER', '');
    }

    public function uninstall()
    {
        return parent::uninstall() 
            && Configuration::deleteByName('CUSTOM_HTML_CONTENT');
    }

    public function getContent()
    {
        $output = '';
    if (Tools::isSubmit('submitCustomHtml')) {
			Configuration::updateValue('CUSTOM_HTML_HOME', Tools::getValue('CUSTOM_HTML_HOME'));
			Configuration::updateValue('CUSTOM_HTML_FOOTER', Tools::getValue('CUSTOM_HTML_FOOTER'));
			$this->_clearCache('*'); // Curăță cache-ul
			$output .= $this->displayConfirmation($this->l('Settings updated'));
        }

        return $output.$this->renderForm();
    }

    public function renderForm()
    {
        $fields_form = [
            'form' => [
                'legend' => [
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cog'
                ],
                'input' => [
                    [
                        'type' => 'textarea',
                        'label' => $this->l('HTML Content'),
                        'name' => 'CUSTOM_HTML_CONTENT',
                        'autoload_rte' => true,
                        'cols' => 60,
                        'rows' => 10
                    ],
					[
						'type' => 'textarea',
						'label' => $this->l('Footer HTML'),
						'name' => 'CUSTOM_HTML_FOOTER',
						'autoload_rte' => true,
						'cols' => 60,
						'rows' => 10
					],
                ],
                'submit' => [
                    'title' => $this->l('Save')
                ]
            ]
        ];

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->submit_action = 'submitCustomHtml';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = [
            'fields_value' => $this->getConfigFieldsValues()
        ];

        return $helper->generateForm([$fields_form]);
    }

    public function getConfigFieldsValues()
    {
        return [
            'CUSTOM_HTML_CONTENT' => Configuration::get('CUSTOM_HTML_CONTENT')
        ];
    }

  /*  public function hookDisplayHome($params)
    {
            $this->context->smarty->assign([
        'html_content' => Configuration::get('CUSTOM_HTML_CONTENT'),
        'hook_name' => 'home' // pentru varianta avansată
    ]);

    return $this->display(__FILE__, 'customhtml.tpl');
    }*/
	// Adaugă o nouă metodă pentru footer:
/*	public function hookDisplayFooter($params)
	{
		return $this->hookDisplayHome($params); // Folosește același conținut ca în home
	}*/
	
	public function hookDisplayHome($params)
	{
		$this->context->smarty->assign([
			'html_content' => Configuration::get('CUSTOM_HTML_HOME'),
			'hook_name' => 'home',
		]);
		return $this->display(__FILE__, 'views/templates/hook/customhtml.tpl');
	}

	public function hookDisplayFooter($params)
	{
		$this->context->smarty->assign([
			'html_content' => Configuration::get('CUSTOM_HTML_FOOTER'),
			'hook_name' => 'footer',
		]);
		return $this->display(__FILE__, 'views/templates/hook/customhtml.tpl');
	}

	//public function getTemplatePath()
	//{
//		return _PS_MODULE_DIR_.$this->name.'/views/templates/hook/customhtml.tpl';
	//}
		// Adaugă metode hook pentru alte poziții după nevoie
}