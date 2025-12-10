# SustainWear

## Development Environment Setup

### Requirements

- [MAMP](https://www.mamp.info/) - Local PHP (7+) server
- [Tailwind CSS Standalone CLI](https://tailwindcss.com/blog/standalone-cli) - CSS framework

### Setup Instructions

1. **Install MAMP**
   - Download and install MAMP from https://www.mamp.info/
   - Move SustainWear project files to `<MAMP PATH>/htdocs/`
   - Ensure rewrite_module is enabled in httpd.conf
      - Located at `<MAMP PATH>/conf/apache/httpd.conf`
      - Ensure `#` is removed from line `#LoadModule rewrite_module modules/mod_rewrite.so`  

2. **Install Tailwind CSS CLI**
   - Download the latest executable from https://github.com/tailwindlabs/tailwindcss/releases/latest

   - Rename executable to tailwindcss(.exe)

   - Make the file executable if required (macOS/Linux):
     ```bash
     chmod +x tailwindcss
     ```

   - Add to PATH
      - Can place in a bin/ directory
      - Or System32 if using Windows

### Usage Instructions

1. **Build CSS using Tailwind**
   ```bash
   # For development
   tailwindcss -o public/styles/output.css --watch

   # For production
   tailwindcss -o public/styles/output.css --minify

   # [Run commands from SustainWear directory]
   ```

2. **Start PHP server**
   - Launch MAMP

   - Click "Start" to run the PHP server

2. **Access the website**
   - Open a browser and visit http://localhost/

   - If no database has been set up, visit http://localhost/db-init.php to create one

### Source Tree Structure

```
app                 # MVC application
├── Controllers/          # Use data from models to render our view templates
├── Core/                 # Backend core - handles routing, authentication, etc
├── Models/               # Database abstraction used by controllers
└── Views/                # HTML templates and components

public              # All web-accessible files
├── db-init.php           # Database initialisation script
├── index.php             # Entry point for each request, specifies routes
├── js/                   # Client-side JavsScript
├── styles/               # Tailwind-generated CSS
└── uploads/              # User-uploaded content
```
