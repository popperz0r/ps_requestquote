<?php
/**
 * 2007-2015 PrestaShop.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2015 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

/**
 * @since 1.5.0
 */
class Ps_RequestQuoteActionsModuleFrontController extends ModuleFrontController
{
    /**
     * @var int
     */
    public $id_product;
    public $id_product_attribute;

    public function init()
    {
        parent::init();

        $this->id_product = (int) Tools::getValue('id_product');
        $this->id_product_attribute = (int) Tools::getValue('id_product_attribute');
    }

    public function postProcess()
    {
        if (Tools::getValue('process') == 'add') {
            $this->processAdd();
        }
    }


    /**
     * Add a favorite product.
     */
    public function processAdd()
    {

        $context = Context::getContext();

        if ($context->customer->isLogged()) {
            $id_customer = (int) $context->customer->id;
            $customer = new Customer($id_customer);
            $customer_email = (string) $customer->email;
        } else if (Validate::isEmail((string)Tools::getValue('customer_email'))) {
            $customer_email = (string) Tools::getValue('customer_email');
            $customer = $context->customer->getByEmail($customer_email);
            $id_customer = (isset($customer->id) && ($customer->id != null)) ? (int) $customer->id : null;
        } else {
            die(json_encode(
                array(
                    'error' => true,
                    'message' => $this->trans('Your e-mail address is invalid', array(), 'Modules.Requestquote.Shop'),
                )
            ));
        }

        $id_product = (int) Tools::getValue('id_product');
        $id_product_attribute = (int) Tools::getValue('id_product_attribute');
        $id_shop = (int) $context->shop->id;
        $id_lang = (int) $context->language->id;
        $product = new Product($id_product, false, $id_lang, $id_shop, $context);

        //lets validate submission
        if(empty(Tools::getValue('cname')) ||
            (!Validate::isEmail((string)Tools::getValue('customer_email')) && !$customer_email) ||
            empty(Tools::getValue('cphone'))
      ){
            die(json_encode(
                array(
                    'error' => true,
                    'message' => $this->trans('Please validate your inputs.', array(), 'Modules.Requestquote.Shop'),
                )
            ));
      }

        $email_sent = Mail::Send(
            (int)(Configuration::get('PS_LANG_DEFAULT')), // defaut language id
            'quote', // email template file to be use
            'Pedido de Cotação', // email subject
            array(
                '{email}' => $customer_email, // sender email address
                '{name}' => Tools::getValue('cname'), // name
                '{phone}' => Tools::getValue('cphone'), // name
                '{message}' => 'Pedido de Cotação do Produto '.$product->name // email content
            ),
            Configuration::get('PS_SHOP_EMAIL'), // receiver email address
            NULL, //receiver name
            $customer_email, //from email address
            NULL,  //from name
            NULL,
            NULL,
            _PS_MODULE_DIR_.$this->module->name.'/mails/'
        );

        if ($email_sent) {
            die(json_encode(
                array(
                    'error' => false,
                    'message' => $this->trans('Your request was registered', array(), 'Modules.Requestquote.Shop'),
                )
            ));
        }

        die(json_encode(
            array(
                'error' => true,
                'message' => $this->trans('Your e-mail address is invalid', array(), 'Modules.Requestquote.Shop'),
            )
        ));
    }

}
