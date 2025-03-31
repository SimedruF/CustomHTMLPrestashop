# CustomHTML Module for PrestaShop

The **CustomHTML** module allows you to add custom HTML content to various sections of your PrestaShop store, such as the home page, footer, left column, and right column.

## Features

- Add custom HTML content to:
  - Home page
  - Footer
  - Left column
  - Right column
- Easy-to-use configuration form in the admin panel.
- Supports rich text editing for HTML content.

## Installation

1. Copy the `CustomHTML` module folder to the `modules` directory of your PrestaShop installation.
2. Go to the PrestaShop admin panel.
3. Navigate to `Modules` > `Module Manager`.
4. Search for `CustomHTML` and click **Install**.

## Configuration

1. After installation, go to the module's configuration page.
2. Add your custom HTML content for the desired sections (Home, Footer, Left Column, Right Column).
3. Save the settings.

## Hooks Used

The module uses the following hooks to display content:

- `displayHome` - Displays content on the home page.
- `displayFooter` - Displays content in the footer.
- `displayLeftColumn` - Displays content in the left column.
- `displayRightColumn` - Displays content in the right column.

## Template

The module uses a Smarty template located at:  views/templates/hook/customhtml.tpl