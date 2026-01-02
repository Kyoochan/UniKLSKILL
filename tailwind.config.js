/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './vendor/livewire/flux/**/*.blade.php', // include Flux templates if you use their classes
  ],
  theme: {
    extend: {
      colors: {
        accent: 'var(--color-accent)',
        'accent-content': 'var(--color-accent-content)',
        'accent-foreground': 'var(--color-accent-foreground)',
      },
      fontFamily: {
        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
};
