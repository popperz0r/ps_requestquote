{*
      * 2007-2015 PrestaShop
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
      *}

      <div class="tabs">
            <div class="row">
                  <div class="col col-md-12 col-lg-8">
                        <form>
                              <p>{l s='Request us a quote.' mod='ps_requestquote'}</p>
                              <div class="js-mailalert" data-url="{url entity='module' name='ps_requestquote' controller='actions' params=['process' => 'add']}">
                                    <input name="cname" class="form-control" type="text" placeholder="{l s='Name' mod='ps_requestquote'}"/><br />
                                    {if isset($email) AND $email}
                                    <input name="cemail" class="form-control" type="email" placeholder="{l s='yourr@email.com' mod='ps_requestquote'}"/><br />
                                    {/if}
                                    <input name="cphone" class="form-control" type="text" placeholder="{l s='Phone Number' mod='ps_requestquote'}"/><br />
                                    {if isset($id_module)}
                                    {hook h='displayGDPRConsent' id_module=$id_module}
                                    {/if}
                                    <input type="hidden" value="{$id_product}"/>
                                    <input type="hidden" value="{$id_product_attribute}"/>
                                    <button class="btn btn-primary" type="submit" rel="nofollow" onclick="return addRequest();">{l s='Request Quote' mod='ps_requestquote'}</button>
                                    <span style="display:none;padding:5px"></span>
                              </div>
                        </form>
                  </div>
            </div>
      </div>
