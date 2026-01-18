# ACF JSON Fields

This folder contains ACF (Advanced Custom Fields) field group definitions in JSON format.

## ⚠️ Important: Requires ACF PRO

This theme requires **ACF PRO** (paid version) for the Options Pages feature.

### First Time Setup

1. Install and activate **ACF PRO** plugin
2. Go to **Custom Fields → Tools** in WordPress admin
3. Click on **"Sync available"** tab
4. Click **"Sync"** for each field group
5. Done! Now you can edit content in Theme Settings

## Field Groups Overview

### 📱 Home Page Content

**Location:** Edit Front Page (Pages → Home)

| Section              | Fields                                                          |
| -------------------- | --------------------------------------------------------------- |
| **Hero**             | Title, description, background, button text, programs (repeater) |
| **How It Works**     | Title, description, steps (title, description, image)           |
| **What This Offers** | Title, subtitle, food images, rational & emotional benefits     |
| **Why This Matters** | Title, subtitle, main image, food cards, benefits list          |
| **Testimonials**     | Title, testimonials (quote, review, name, role, avatar, image)  |
| **CTA Section**      | Title, subtitle, background, buttons, phone images              |
| **App Screens**      | Title, description, 3 phone screenshots                         |

### 📄 About Page Content

**Location:** Edit About Us page (Pages → About Us)

| Section                | Fields                                                  |
| ---------------------- | ------------------------------------------------------- |
| **Hero**               | Title (supports `<br>`), background image               |
| **Our Philosophy**     | Title, video file OR URL, poster, quote, decorative text |
| **Values in Action**   | Title, description, values (title, description, image)  |
| **How We Work**        | Title, subtitle, background, process steps with icons   |
| **Team**               | Title, description, team members with social links      |
| **FAQ**                | Title, description, image, FAQ items                    |
| **Share/Contact Form** | Title, description, background, form labels, success msg |
| **Always In Touch**    | Title, description                                      |

### ⚙️ Theme Settings (Global Options)

Access via **Theme Settings** menu in WordPress admin sidebar.

#### General Content

| Field                 | Description                    |
| --------------------- | ------------------------------ |
| Site Logo (Main)      | Left part of header logo       |
| Site Logo (Secondary) | Right part of header logo      |
| Footer Logo           | Logo in footer                 |
| Site Favicon          | Browser tab icon (512x512 PNG) |
| Home Link Text        | Navigation text for Home       |
| About Link Text       | Navigation text for About Us   |
| Download Button Text  | Header button text             |
| Download Button Link  | Where button links to          |
| Footer Tagline        | Text below footer logo         |
| Download Section Title| Title above app store buttons  |
| Copyright Text        | Footer copyright notice        |

#### App Links

| Field           | Description            |
| --------------- | ---------------------- |
| App Store Link  | iOS app download URL   |
| Google Play Link| Android app download URL |

#### Social Links (Footer)

| Field     | Description                   |
| --------- | ----------------------------- |
| Facebook  | Facebook page URL             |
| Instagram | Instagram profile URL         |
| LinkedIn  | LinkedIn page URL             |
| X (Twitter)| Twitter/X profile URL        |

#### Contact Info (About Page)

| Field                | Description                      |
| -------------------- | -------------------------------- |
| Contact Email        | Main email address               |
| Contact Phone        | Main phone number                |
| Address              | Physical address                 |
| Working Hours        | Business hours                   |
| WhatsApp Link        | Direct chat link (wa.me/...)     |
| Telegram Link        | Direct chat link (t.me/...)      |
| Google Maps Link     | Link to open in Maps             |
| Google Maps Embed URL| iframe src for embedded map      |
| Map Image            | Static fallback image            |

#### Form Settings

| Field            | Description                    |
| ---------------- | ------------------------------ |
| Recipient Email  | Where form submissions are sent |
| SMTP Settings    | Email server configuration     |

#### SEO Settings

| Field               | Description                  |
| ------------------- | ---------------------------- |
| Default Description | Fallback meta description    |
| Default OG Image    | Social sharing image         |
| Home Page Title     | Custom title for home page   |
| Home Page Description | Custom description for home |
| Twitter Username    | For Twitter cards            |

### 📝 Page SEO Settings

**Location:** Appears on every Page edit screen

- Custom SEO title
- Custom SEO description  
- Custom OG image

## 📱 Image Recommendations

| Image Type         | Size          |
| ------------------ | ------------- |
| Hero Background    | 1920×1080px   |
| OG Image           | 1200×630px    |
| Favicon            | 512×512px PNG |
| Team Photo         | 400×400px     |
| Testimonial Avatar | 200×200px     |
| App Screenshots    | PNG with transparency |

## Troubleshooting

**Theme Settings menu not showing?**
- ACF PRO is required (not the free version)
- Go to Custom Fields → Tools → Sync

**Fields not appearing?**
- Make sure ACF field groups are synced
- Check you're editing the correct page

**Images not saving?**
- Check WordPress upload permissions
- Increase PHP upload_max_filesize if needed

## For Developers

Field changes in WordPress admin are auto-saved to these JSON files.
Commit them to Git so changes sync across environments.

### Field Naming Convention

- Home page: `hero_*`, `hiw_*`, `offers_*`, `why_*`, `testimonials_*`, `cta_*`, `app_screens_*`
- About page: `about_hero_*`, `philosophy_*`, `via_*`, `hww_*`, `team_*`, `faq_*`, `share_*`
- Global options: Use `get_field('field_name', 'option')`
