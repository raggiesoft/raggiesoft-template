
# RaggieSoft Site Template (Standard Edition)

A lightweight, router-based PHP starter kit for deploying websites within the RaggieSoft network.

This template implements the **"Elara" Architecture**, designed for speed, portability, and separation of concerns. It decouples the application logic (PHP) from the presentation layer (CDN assets), allowing for instant theming and rapid deployment.

---

## 🚀 Features

* **Elara Smart Router:** A file-based routing engine (`index.php`) with auto-discovery for views. No complex configuration required for standard pages.
* **CDN Integration:** Pre-configured to load CSS, JS, and media assets from the central `assets.raggiesoft.com` repository.
* **Theme Engine:** Supports dynamic theme switching (e.g., "Corporate" vs. "Ad Astra") via simple configuration variables.
* **SEO Ready:** Built-in Open Graph metadata injection for rich social sharing.

---

## 📂 Directory Structure


/
├── public/
│   ├── index.php           # Entry Point & Router Logic
│   └── errors/             # Error pages (403, 404, 500)
├── includes/
│   ├── header.php          # Asset Loader & HTML Head
│   ├── footer.php          # Global Footer
│   ├── components/         # Reusable UI parts (Navbars, Sidebars)
│   └── utils/              # Helper scripts (Data Loaders)
└── pages/
    ├── home.php            # Default landing page
    └── templates/          # Copy/Paste starter files for new pages


---

## 🛠️ Quick Start

1. **Clone & Configure:** Copy this repository to your new project folder.
    
2. **Configure the Router:** Open `public/index.php` and update the **Global Configuration** block:
    
    PHP
    
    ```
    $siteConfig = [
        'name' => 'My New Project',
        'slug' => 'my-new-project', // Must match a folder on the CDN
        'default_theme' => 'corporate',
        // ...
    ];
    ```
    
3. **Create Pages:** Add new PHP files to the `/pages/` directory. The router will automatically map them.
    
    - `pages/about.php` -> `example.com/about`
        
    - `pages/contact.php` -> `example.com/contact`
        
4. **Deploy:** Point your web server (Nginx/Apache) document root to the `/public` directory.
    

---

## 📜 Licensing

This project operates under a specific **Dual-License Model** to distinguish between the underlying technology and the creative works it presents.

### 1. Source Code (The Engine)

All underlying software code, scripts, HTML structure, and architecture (including the "Elara" router logic) are licensed under the **MIT License**.

> Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files...

### 2. Creative Content (The Narrative)

All creative assets, including but not limited to narrative text, lore, character biographies, world-building elements, and visual artwork, are licensed under the **Creative Commons Attribution-ShareAlike 4.0 International (CC BY-SA 4.0)** License.

### 3. Proprietary Extensions

**Note:** Specific compiled applications or commercial media distributions (e.g., music albums, mobile apps) released through this platform may be subject to separate, proprietary licenses. Please refer to the specific terms included with those releases.