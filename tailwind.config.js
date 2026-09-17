const _ = require("lodash");
const theme = require("./theme.json");
const tailpress = require("./theme.js");

module.exports = {
  tailpress,
  content: [
    "*.php",
    "./blocks/**/*.php",
    "./blocks/**/**/*.php", // Added line to target all PHP files at any depth within app/blocks
    "./app/css/*.css",
    "./app/js/*.js",
    "./functions/*.php",
    "./app/ui/*.php",
    "./app/css/safelist.txt",
  ],

  theme: {
    container: {
      center: true,
      padding: {
        DEFAULT: "2rem",
        sm: "2rem",
        lg: "0rem",
      },
      margin: {
        DEFAULT: "5rem",
        sm: "2rem",
        lg: "0rem",
      },
    },
    extend: {
      colors: tailpress.colorMapper(
        tailpress.theme("settings.color.palette", theme),
      ),
    },
    screens: {
      sm: "640px",
      md: "768px",
      lg: "1024px",
      xl: tailpress.theme("settings.layout.contentSize", theme),
      "2xl": tailpress.theme("settings.layout.contentSize", theme),
    },
    fontFamily: {
      fredoka: ['"Fredoka"', "Arial", "sans-serif"],
      poppins: ['"Poppins"', "Arial", "sans-serif"],
      // 'brown': ['"Brown"', 'Arial', 'sans-serif'],
    },
  },
  plugins: [require("@tailwindcss/forms"), tailpress.tailwind],
};
