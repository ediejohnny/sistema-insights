/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'trello-blue': '#0079BF',
        'trello-gray': '#F4F5F7',
        'trello-red': '#EB5A46',
        'trello-yellow': '#F2D600',
      },
    },
  },
  plugins: [],
}
