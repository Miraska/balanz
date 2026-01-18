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

## Field Groups Overview

### 📱 Home Page Content

**Location:** Edit Front Page

All sections of the home page can be edited:

| Section              | Fields                                                                                                       |
| -------------------- | ------------------------------------------------------------------------------------------------------------ |
| **Hero**             | Title, description, background image, button text, programs (repeater with image, title, calories, subtitle) |
| **How It Works**     | Title, description, steps (repeater with title, description, image)                                          |
| **What This Offers** | Title, subtitle, food images, rational benefits list, emotional benefits list                                |
| **Why This Matters** | Title, subtitle, main image, food cards, benefits list                                                       |
| **Testimonials**     | Title, testimonials (repeater with quote, review, name, role, avatar, background image)                      |
| **CTA Section**      | Title, subtitle, background, buttons (text + links), phone mockup images                                     |
| **App Screens**      | Title, description, phone screenshots                                                                        |

### 📄 About Page Content

**Location:** Edit About Us page

| Section                | Fields                                                                         |
| ---------------------- | ------------------------------------------------------------------------------ |
| **Hero**               | Title (supports `<br>`), background image                                      |
| **Our Philosophy**     | Title, video file OR YouTube/Vimeo URL, poster image, quote, decorative text   |
| **Values in Action**   | Title, description, values (repeater with title, description, image)           |
| **How We Work**        | Title, subtitle, background, process steps (with icons)                        |
| **Team**               | Title, description, team members (name, role, photo, quote, bio, social links) |
| **FAQ**                | Title, description, image, FAQ items (question + answer)                       |
| **Share/Contact Form** | Title, description, background, form labels, success messages                  |
| **Always In Touch**    | Title, description                                                             |

### ⚙️ Global Options (Theme Settings)

Access via **Theme Settings** menu in WordPress admin:

#### General Content

- Site logos (main, secondary, footer)
- Site favicon (512x512px PNG recommended)
- Navigation text labels
- Download button text & link
- Footer tagline & copyright

#### App Links

- App Store URL
- Google Play URL

#### Social Links

- Facebook, Instagram, LinkedIn, X (Twitter)
- WhatsApp, Telegram
- YouTube, TikTok
- VKontakte (VK), Pinterest

#### Contact Info

**Basic Info:**

- Email, phone, address
- Working hours

**Messengers:**

- WhatsApp direct chat link
- Telegram direct chat link
- Viber link

**Map Settings:**

- Google Maps link (for "Open in Maps" button)
- Google Maps embed URL (for iframe)
- Static map image (optional fallback)

**Additional:**

- Secondary phone/email
- Company legal name
- Tax ID / Registration number

#### Form Settings

- Recipient email for form submissions
- SMTP configuration for email delivery

#### SEO Settings

- Default meta description
- Home page title & description
- Default OG image (1200x630px)
- Twitter username

### 📝 Page SEO Settings

**Location:** Edit any Page (appears below editor)

- Custom SEO title
- Custom SEO description
- Custom OG image

## 🎬 Video Support

The Philosophy section on About page supports:

1. **Uploaded Video** - Upload MP4/WebM directly to WordPress
2. **External URL** - Paste YouTube or Vimeo embed URL
3. **Poster Image** - Thumbnail shown before video plays

## 📱 Images Recommendations

| Image Type         | Recommended Size      |
| ------------------ | --------------------- |
| Hero Background    | 1920×1080px           |
| OG Image           | 1200×630px            |
| Favicon            | 512×512px PNG         |
| Program Card       | 400×400px             |
| Testimonial Avatar | 200×200px             |
| Team Photo         | 400×400px             |
| App Screenshots    | PNG with transparency |

## Editing Content

After syncing:

1. **Home Page:** Go to Pages → Edit Front Page
2. **About Page:** Go to Pages → Edit About Us
3. **Global Settings:** Go to Theme Settings menu
4. All fields have default values and fallbacks

## For Developers

When you modify field groups in WordPress admin:

- Changes are automatically saved to JSON files in this folder
- **Commit these files to Git** so other developers get the updates
- ACF will prompt you to sync if JSON files are newer than database

### Field Naming Convention

- Home page fields: `hero_*`, `hiw_*`, `offers_*`, `why_*`, `testimonials_*`, `cta_*`, `app_screens_*`
- About page fields: `about_hero_*`, `philosophy_*`, `via_*`, `hww_*`, `team_*`, `faq_*`, `share_*`, `always_in_touch_*`
- Global options: Use `get_field('field_name', 'option')`

## Troubleshooting

**Fields not showing after sync?**

- Make sure you're looking in the right place (Theme Settings for global, Pages for page-specific)
- Try deactivating and reactivating the theme
- Clear WordPress cache

**Can't sync?**

- Check file permissions on this folder
- Make sure ACF Pro is activated (free version doesn't support JSON sync)

**Images not saving?**

- Check WordPress upload folder permissions
- Increase PHP upload limits if needed

**Video not playing?**

- Make sure video is in MP4 format with H.264 codec
- Check file size (recommended max 50MB)
- For YouTube/Vimeo, use the embed URL, not the regular page URL
