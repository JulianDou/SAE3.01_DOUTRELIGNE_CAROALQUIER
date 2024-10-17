/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{inc,html}"
  ],
  theme: {
    extend: {
      colors: {
        "zing-green": "#52AE32",
        "micromania-blue": "#164094",
        "offwhite": "#F9F9F9",
        "generic-grey": "#686868"
      }
    },
  },
  plugins: [],
}

