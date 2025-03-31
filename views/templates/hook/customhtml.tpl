{* modules/customhtml/views/templates/hook/customhtml.tpl *}

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
		<script src="https://mny.ro/npId.js?p=149682"
				type="text/javascript"
				data-version="orizontal"
				data-contrast-color="#ffffff"></script>
    </div>
{/if}