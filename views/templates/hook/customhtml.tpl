{* modules/customhtml/views/templates/hook/customhtml.tpl *}

You can customize this template to change how the HTML content is rendered.

## Compatibility

- PrestaShop version: 1.7 and above.

## Author

Developed by **AutomaticHouseSystems**.

## License

This module is licensed under the [MIT License](LICENSE).

{if $html_content}
    <div class="custom-html-wrapper">
        <style>
            .custom-html-wrapper {
                margin: 15px 0;
                padding: 10px;
                border: 1px solid #eee;
                border-radius: 4px;
            }
            .custom-html-wrapper .custom-content {
                line-height: 1.5;
            }
        </style>
        <div class="custom-content">
            {$html_content nofilter}
        </div>
        <div class="custom-html-{$hook_name}">
            {$html_content nofilter}  
        </div>

{/if}