{* modules/customhtml/views/templates/hook/customhtml.tpl *}
{* You can customize this template to change how the HTML content is rendered. *}
{* ## Compatibility *}
{* - PrestaShop version: 1.7 and above. *}
{* ## Author *}
{* Developed by **AutomaticHouseSystems**. *}
{* ## License *}
{* This module is licensed under the [MIT License](LICENSE). *}

{if $html_content}
    <div class="custom-html-wrapper">
        <style>
            .custom-html-wrapper {
                margin: 25px 0;
                padding: 10px;
                border: 1px solid #eee;
                border-radius: 4px;
            }
            .custom-html-wrapper .custom-content {
                line-height: 1.5;
            }
        </style>
      <div class="custom-html-{$hook_name}">
        <ul>
            <li><a href="http://www.anpc.gov.ro/">Protecția consumatorilor A.N.C.P</a> </li>
            <li> <a href="https://ec.europa.eu/consumers/odr/main/index.cfm?event=main.home2.show&lng=RO">Soluționarea litigiilor</a></li>
        </ul>
        <hr> 
          {Configuration::get('CUSTOM_HTML_FOOTER') nofilter} 
      </div>
      {literal} 
      <script src="https://mny.ro/npId.js?p=149682" type="text/javascript" data-version="orizontal"
                    data-contrast-color="#ffffff">
      </script>
     {/literal}
     
    </div>   
{/if}