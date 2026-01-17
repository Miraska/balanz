# ACF JSON Fields

This folder contains ACF (Advanced Custom Fields) field group definitions in JSON format.

## Automatic Sync

WordPress will automatically load these field groups when:
- ACF Pro plugin is installed and activated
- The theme is activated

No manual import needed! Just activate the theme and the fields will appear.

## Field Groups

### Global Options (Theme Settings)
- **General Content** - Logos, navigation texts, footer content
- **App Links** - App Store and Google Play links
- **Social Links** - Facebook, Instagram, LinkedIn, X (Twitter)
- **Contact Info** - Email, phone, address
- **Form Settings** - Email recipient for form submissions
- **SEO Settings** - Default meta tags and OG images

### Page-Specific Fields
- **Home Page Content** - Hero, programs, testimonials
- **About Page Content** - Team members, FAQ
- **Page SEO** - Custom SEO fields for any page (sidebar)

## Editing Content

After activating the theme:

1. Go to **Theme Settings** in WordPress admin to edit global content
2. Edit **Pages** (Home, About Us) to change page-specific content
3. All fields have default values and fallbacks, so the site will work even without filling them

## For Developers

When you modify field groups in WordPress admin:
- Changes are automatically saved to JSON files in this folder
- Commit these files to Git so other developers get the updates
- ACF will prompt you to sync if JSON files are newer than database
