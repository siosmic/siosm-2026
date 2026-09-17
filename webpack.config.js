const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const path = require("path");
const fs = require("fs");

const jsDir = path.resolve(__dirname, "app/js");

const getEntryPoints = () => {
  const entries = {};
  
  if (fs.existsSync(jsDir)) {
    const files = fs.readdirSync(jsDir);
    files.forEach((file) => {
      const filePath = path.join(jsDir, file);
      const stat = fs.statSync(filePath);
      
      // Ignore les sous-dossiers, les fichiers de déclaration (.d.ts) et les fichiers de travail commençant par '_'
      if (stat.isFile() && !file.endsWith(".d.ts") && !file.startsWith("_")) {
        const ext = path.extname(file);
        if ([".js", ".jsx", ".ts", ".tsx"].includes(ext)) {
          const name = path.basename(file, ext);
          // Préfixe js/ pour ranger dans build/js/
          entries[`js/${name}`] = filePath;
        }
      }
    });
  }
  
  return entries;
};

module.exports = {
  ...defaultConfig,
  entry: getEntryPoints(),
  output: {
    filename: "[name].js",
    path: path.resolve(__dirname, "build"),
  },
};
