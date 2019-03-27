/**
* 2007-2019 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2019 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/
function  addRequest() {

      var ids = $('div.js-mailalert > input[type=hidden]');

      $.ajax({
            type: 'POST',
            url: $('div.js-mailalert').data('url'),
            data: 'id_product='+ids[0].value+'&id_product_attribute='+ids[1].value+'&customer_email='+$('div.js-mailalert > input[type=email]').val()+'&cname='+$('div.js-mailalert > input[name=cname]').val()+'&cphone='+$('div.js-mailalert > input[name=cphone]').val(),
            success: function (resp) {
                  resp = JSON.parse(resp);

                  if (!resp.error) {
                        $('div.js-mailalert > span').html('<article class="alert alert-success" role="alert" data-alert="success">'+resp.message+'</article>').show();
                        $('div.js-mailalert > button').hide();
                        $('div.js-mailalert > input[type=email]').hide();
                        $('div.js-mailalert > #gdpr_consent').hide();
                  }else{
                        $('div.js-mailalert > span').html('<article class="alert alert-danger" role="alert" data-alert="success">'+resp.message+'</article>').show();
                  }
            }
      });
      return false;
}
