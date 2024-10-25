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
        "micromania-darkblue": "#123456",
        "offwhite": "#F9F9F9",
        "generic-grey": "#686868"
      },
      fontFamily: {
        "inter": ["Inter", "sans-serif"]
      },
    },
  },
  plugins: [
    require('tailwind-scrollbar-hide')
  ],
}

