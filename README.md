# Elara Starter Kit

A lightweight, data-driven PHP routing engine designed for building content-heavy websites with minimal overhead. 

Based on the architecture of *The Stardust Engine*, Elara separates content (PHP views), configuration (JSON), and assets (CDN-based), allowing for rapid site deployment without a heavy framework.

## 🚀 Key Features

* **Smart Routing:** Automatically maps URLs (e.g., `/about/team`) to file paths (`pages/about/team.php`) without manual configuration.
* **H1 Auto-Discovery:** If a page title isn't defined in the config, Elara automatically scrapes the first `<h1>` tag from the file to generate the `<title>` tag.
* **JSON Configuration:** Manage metadata, Open Graph tags, and sidebar visibility via simple JSON files in `data/routes/`.
* **Context-Aware Layouts:** Automatically injects specific Sidebars or Headers based on the URL section (e.g., `/docs/*` loads the Documentation sidebar).
* **CDN Asset Loading:** A centralized header architecture designed to load CSS/JS from an external asset host or CDN.

---

## 📂 Directory Structure


/
├── data/
│   ├── routes/              # Route-specific metadata overrides
│   │   └── core.json
│   └── settings.json        # Global site configuration (Name, CDN URL, Defaults)
├── includes/
│   ├── header.php          # Asset Loader & HTML Head
│   ├── footer.php          # Global Footer
│   ├── components/         # Reusable UI parts (Navbars, Sidebars)
│   └── utils/              # Helper scripts (Data Loaders)
└── pages/
    ├── home.php            # Default landing page
    └── templates/          # Copy/Paste starter files for new pages


---

## ⚙️ Installation & Setup

### 1. Server Requirements

- PHP 8.0 or higher
    
- Apache (with mod_rewrite) OR Nginx
    

### 2. Document Root

Point your web server's document root to the `/public` folder.

### 3. URL Rewriting

Ensure all requests are forwarded to `index.php`.

**For Apache (.htaccess in /public):**

Apache


RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]


**For Nginx:**

Nginx


location / {
    try_files $uri $uri/ /index.php?$query_string;
}


---

## 📖 Usage Guide

### 1. Creating a New Page

Simply create a PHP file in the `pages/` directory. The router automatically finds it.

- **File:** `pages/contact.php`
    
- **URL:** `your-site.com/contact`
    

**Example Content (`pages/contact.php`):**


<div class="container py-5">
    <h1>Contact Us</h1> 
    <p>Email us at hello@example.com</p>
</div>


### 2. Overriding Metadata (Optional)

If you want to customize the browser title, add Open Graph images, or change the sidebar for a specific page, add an entry to `data/routes/core.json`.

{
  "/contact": {
    "title": "Get in Touch - Official Support",
    "ogDescription": "Contact our support team available 24/7.",
    "showSidebar": true,
    "sidebar": "sidebar-support"
  }
}


### 3. Global Configuration

Edit `data/settings.json` to control site-wide defaults.

- **`siteName`**: Appended to auto-generated titles.
    
- **`cdnBaseUrl`**: The root URL for your CSS/JS assets (used in `header.php`).
    
- **`sidebarMap`**: Automatically applies specific sidebars to URL patterns.
    

**Example `settings.json`:**

{
  "siteName": "My Awesome Site",
  "cdnBaseUrl": "[https://assets.mysite.com](https://assets.mysite.com)",
  "defaultTheme": "light",
  "sidebarMap": {
    "/docs": "sidebar-docs", 
    "/blog": "sidebar-blog"
  }
}


_In this example, any page URL starting with `/docs` will automatically load `includes/components/sidebars/sidebar-docs.php`._

---

## 🎨 Theming & Assets

The `includes/header.php` file is pre-configured to load styles dynamically based on the **RaggieSoft Asset Architecture**.

It constructs CSS paths using the `$cdnBaseUrl` + `$site` + `$theme` variables.

1. **Default Behavior:** Loads `[CDN]/[site]/css/bootstrap/root.css` etc.
    
2. **Customizing:** If you are not using an external CDN, modify `includes/header.php` to point to your local CSS path:
    

    // Example Modification for Local CSS
    $path_theme_base = "/assets/css"; 

    

## 🧩 Advanced: Changing the Header/Logo per Page

You can completely rebrand the site for a specific section (e.g., a sub-project or landing page) by adding these parameters to your route JSON:

"/special-event": {
  "headerMenu": "headers/header-event",
  "navbarBrandText": "Special Event 2025",
  "navbarBrandLogo": "[https://cdn.site.com/event-logo.png](https://cdn.site.com/event-logo.png)",
  "theme": "dark-mode"
}