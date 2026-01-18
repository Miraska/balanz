# ACF JSON Fields

This folder contains ACF (Advanced Custom Fields) field group definitions in JSON format.

## ⚠️ Important: First Time Setup

**After uploading the theme, you MUST sync ACF fields:**

1. Make sure **ACF Pro** plugin is installed and activated
2. Go to **Custom Fields → Tools** in WordPress admin
3. Click on **"Sync available"** tab
4. You'll see a list of field groups - click **"Sync"** button for each one
5. Done! Now you can edit content in Theme Settings

**If you don't see "Sync available" tab:**

- Check that ACF Pro is activated
- Make sure these JSON files are uploaded to the server
- Check folder permissions (should be readable by WordPress)

## Field Groups

### Global Options (Theme Settings)

After syncing, you'll see **Theme Settings** menu in WordPress admin with these sub-pages:

- **General Content** - Logos, navigation texts, footer content
- **App Links** - App Store and Google Play links
- **Social Links** - Facebook, Instagram, LinkedIn, X (Twitter)
- **Contact Info** - Email, phone, address
- **Form Settings** - Email recipient for form submissions
- **SEO Settings** - Default meta tags and OG images

### Page-Specific Fields

Will appear when editing pages:

- **Home Page Content** - Hero, programs, testimonials (Front Page only)
- **About Page Content** - Team members, FAQ (About Us page only)
- **Page SEO** - Custom SEO fields for any page (sidebar)

## Editing Content

After syncing:

1. Go to **Theme Settings** in WordPress admin to edit global content
2. Edit **Pages** (Home, About Us) to change page-specific content
3. All fields have default values and fallbacks, so the site will work even without filling them

## For Developers

When you modify field groups in WordPress admin:

- Changes are automatically saved to JSON files in this folder
- **Commit these files to Git** so other developers get the updates
- ACF will prompt you to sync if JSON files are newer than database

## Troubleshooting

**Fields not showing after sync?**

- Make sure you're looking in the right place (Theme Settings for global, Pages for page-specific)
- Try deactivating and reactivating the theme
- Clear WordPress cache

**Can't sync?**

- Check file permissions on this folder
- Make sure ACF Pro is activated (free version doesn't support JSON sync)
