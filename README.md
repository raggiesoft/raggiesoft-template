
# RaggieSoft Narrative Template (v1.1)

A lightweight, PHP-based website engine designed for storytelling, world-building, and narrative archives. This template separates **Content** (PHP/HTML) from **Presentation** (CSS Themes), allowing you to spin up new narrative universes quickly while maintaining a consistent, robust architecture.

## 🚀 Tech Stack

* **Backend Logic:** Custom "Elara" Router (PHP 8.x+)
* **Frontend Framework:** Bootstrap 5.3.8 (Specific Version Locked)
* **Icons:** Font Awesome Pro (via Kit)
* **Theming:** CSS Custom Properties (Variables) with Dark Mode support
* **Asset Management:** CDN-ready architecture (DigitalOcean Spaces compatible)

---

## 📂 Directory Structure

```text
/raggiesoft-template
├── public/
│   └── index.php          <-- The Brain (Entry Point & Router)
├── includes/
│   ├── header.php         <-- Global <head>, Meta Tags, Theme Loader
│   ├── footer.php         <-- Global Footer & Scripts
│   └── components/        <-- Reusable UI Elements (Navs, Cards, Buttons)
├── pages/                 <-- Your Content Lives Here
│   ├── home.php
│   └── discography/       <-- Supports nested directories
│       └── overview.php
├── assets/
│   └── css/
│       └── theme-template.css  <-- The Master Color Palette
└── errors/
    └── 404.php
````

---

## 🛠️ Getting Started

### 1. Configuration

Open `public/index.php` and configure the **Global Defaults** block at the top:

PHP

```
$siteName = 'Luna and Leo'; // Your Project Name
$projectSlug = 'luna-and-leo'; // Matches your CDN folder
$defaultTheme = 'luna-leo'; // Matches theme-luna-leo.css
$cdnBaseUrl = '[https://assets.raggiesoft.com](https://assets.raggiesoft.com)';
```

### 2. Theming

This engine uses a **Dual-Layer Theme Stack**:

1. **Logic Layer:** `bootstrap-overrides.css` (Hosted globally on your CDN). Handles component fixes and dark mode logic.
    
2. **Paint Layer:** Your project-specific theme file (e.g., `theme-luna-leo.css`).
    

To create a new theme:

1. Copy `assets/css/theme-template.css`.
    
2. Rename it (e.g., `theme-neon-city.css`).
    
3. Upload it to your CDN folder: `/$projectSlug/css/`.
    
4. Edit the CSS Variables in the `:root` block to define your palette.
    

**Example Palette:**

CSS

```
:root {
    --color-bg-dark: #0D061A;       /* Deep Space Purple */
    --color-accent-primary: #FF4D6A; /* Nebula Red */
    --color-accent-highlight: #00F0FF; /* Cyan Links */
}
```

### 3. The "Elara" Router

The router uses **Auto-Discovery** to map URLs to files, keeping your configuration minimal.

- **URL:** `/about` -> **File:** `pages/about.php`
    
- **URL:** `/discography` -> **File:** `pages/discography/overview.php`
    

**Custom Routes:** You can override this behavior in `index.php` to set specific titles or themes for a single page:

PHP

```
'/special-event' => [
    'view' => 'pages/events/2024-gala',
    'title' => 'The Gala - ' . $siteName,
    'theme' => 'midnight-gold' // Loads theme-midnight-gold.css
],
```

---

## 📦 Components & Features

- **Smart Sidebar:** Automatically injects a sidebar if `$showSidebar` is true, or renders full-width if false.
    
- **WCAG AAA Compliance:** The theme logic automatically handles contrast for buttons and alerts (forcing dark text on light backgrounds and vice-versa).
    
- **CDN Integration:** Assets (images, CSS, audio) are linked dynamically using `$cdnBaseUrl`, keeping the Git repo lightweight.
    

---

## 📜 License

This project operates under the standard **RaggieSoft Dual-License Model**:

- **Source Code:** [MIT License](https://www.google.com/search?q=LICENSE)
    
- **Creative Content:** CC BY-SA 4.0 (Applies to narrative text, characters, and lore).
    

© 2025 RaggieSoft.