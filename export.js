const fs = require("fs");
const path = require("path");
const { execSync } = require("child_process");

const themeName = "siosm-linpasse";
const distDir = path.resolve(__dirname, "dist");
const exportDir = path.join(distDir, themeName);

console.log("[export] Cleaning previous builds...");
if (fs.existsSync(distDir)) {
  fs.rmSync(distDir, { recursive: true, force: true });
}
fs.mkdirSync(exportDir, { recursive: true });

// Files and directories to copy
const targets = [
  "blocks",
  "functions",
  "public",
  "build",
  "style.css",
  "screenshot.png",
  "theme.json",
  "functions.php",
];

// Collect all root PHP templates (page.php, single.php, template-*.php, etc.)
const rootFiles = fs.readdirSync(__dirname);
rootFiles.forEach((file) => {
  if (file.endsWith(".php") && !targets.includes(file)) {
    targets.push(file);
  }
});

// Helper to copy files/folders recursively
function copyRecursiveSync(src, dest) {
  const exists = fs.existsSync(src);
  const stats = exists && fs.statSync(src);
  const isDirectory = exists && stats.isDirectory();
  if (isDirectory) {
    fs.mkdirSync(dest, { recursive: true });
    fs.readdirSync(src).forEach((childItemName) => {
      copyRecursiveSync(
        path.join(src, childItemName),
        path.join(dest, childItemName)
      );
    });
  } else {
    fs.copyFileSync(src, dest);
  }
}

console.log("[export] Copying production assets to export directory...");
targets.forEach((target) => {
  const srcPath = path.resolve(__dirname, target);
  if (fs.existsSync(srcPath)) {
    copyRecursiveSync(srcPath, path.join(exportDir, target));
  }
});

console.log("[export] Zipping theme folder...");
try {
  // Zip the folder. cwd: exportDir makes sure the zip root is the theme files themselves.
  execSync(`zip -r ../${themeName}.zip .`, { cwd: exportDir, stdio: "ignore" });
  console.log(`\n🎉 Success! Your production theme zip is ready:`);
  console.log(`📁 Target directory: dist/${themeName}/`);
  console.log(`📦 Zip file: dist/${themeName}.zip\n`);
} catch (error) {
  console.error("[export] Failed to create ZIP file:", error.message);
}
