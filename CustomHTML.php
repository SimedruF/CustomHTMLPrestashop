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
        $this->version = '1.0.1';
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
			&& Configuration::updateValue('CUSTOM_HTML_FOOTER', '')
            && Configuration::updateValue('CUSTOM_HTML_LEFT', '')
            && Configuration::updateValue('CUSTOM_HTML_RIGHT', '');
    }

    public function uninstall()
    {
        return parent::uninstall() 
            && Configuration::deleteByName('CUSTOM_HTML_HOME')
            && Configuration::deleteByName('CUSTOM_HTML_FOOTER') 
            && Configuration::deleteByName('CUSTOM_HTML_LEFT')
            && Configuration::deleteByName('CUSTOM_HTML_RIGHT');
    }

    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submitCustomHtml')) {
            Configuration::updateValue('CUSTOM_HTML_HOME', Tools::getValue('CUSTOM_HTML_HOME', false));
            Configuration::updateValue('CUSTOM_HTML_FOOTER', Tools::getValue('CUSTOM_HTML_FOOTER', false));
            Configuration::updateValue('CUSTOM_HTML_LEFT', Tools::getValue('CUSTOM_HTML_LEFT', false));
            Configuration::updateValue('CUSTOM_HTML_RIGHT', Tools::getValue('CUSTOM_HTML_RIGHT', false));
            $this->_clearCache('*'); // Curăță cache-ul
            $output .= $this->displayConfirmation($this->l('Settings updated'));
        }

        return $output . $this->renderForm();
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
                        'name' => 'CUSTOM_HTML_HOME',
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
                    [
						'type' => 'textarea',
						'label' => $this->l('Left column HTML'),
						'name' => 'CUSTOM_HTML_LEFT',
						'autoload_rte' => true,
						'cols' => 60,
						'rows' => 10
					],
                    [
						'type' => 'textarea',
						'label' => $this->l('Right column HTML'),
						'name' => 'CUSTOM_HTML_RIGHT',
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
            'CUSTOM_HTML_HOME' => Configuration::get('CUSTOM_HTML_HOME'),
            'CUSTOM_HTML_FOOTER' => Configuration::get('CUSTOM_HTML_FOOTER'),
            'CUSTOM_HTML_LEFT' => Configuration::get('CUSTOM_HTML_LEFT'),
            'CUSTOM_HTML_RIGHT' => Configuration::get('CUSTOM_HTML_RIGHT')
        ];
    }

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
       $htmlContent = Configuration::get('CUSTOM_HTML_FOOTER');
	   if (!$htmlContent) {
        return '<p>Debug: CUSTOM_HTML_FOOTER is empty</p>';
       }

        $this->context->smarty->assign([
            'html_content' => $htmlContent,
            'hook_name' => 'footer',
        ]);

   	  return $this->display(__FILE__, 'views/templates/hook/customhtml.tpl');
	}

    public function hookDisplayLeftColumn($params)
	{
		$this->context->smarty->assign([
			'html_content' => Configuration::get('CUSTOM_HTML_LEFT'),
			'hook_name' => 'footer',
		]);
		return $this->display(__FILE__, 'views/templates/hook/customhtml.tpl');
	}

    public function hookDisplayRightColumn($params)
	{
		$this->context->smarty->assign([
			'html_content' => Configuration::get('CUSTOM_HTML_RIGHT'),
			'hook_name' => 'footer',
		]);
		return $this->display(__FILE__, 'views/templates/hook/customhtml.tpl');
	}
     
}