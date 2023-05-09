const yoastPreset = require("@yoast/tailwindcss-preset");
/** @type {import('tailwindcss').Config} */
module.exports = {
  presets: [yoastPreset],
  content: [
    ...yoastPreset.content,
    "./node_modules/@newfold-labs/**/*.js",
    "./vendor/newfold-labs/**/*.js",
    "./src/app/index.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

