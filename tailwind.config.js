module.exports = {
  mode: 'jit', // Enable Just-In-Time mode for better performance
  content: [
    './*.php', // Root PHP files
    './template-parts/**/*.php', // Template parts
    './patterns/**/*.php', // Block patterns
    './src/**/*.js', // JavaScript files for blocks
    './assets/css/src/*.scss', // SCSS files
    './src/blocks/**/*.php', // Include PHP files in the `inc` folder if applicable
  ],
  theme: {
    extend: {
      spacing: {
        // Extend spacing scale if needed
        '1': '0.25rem', // 4px
        '2': '0.5rem',  // 8px
        '3': '0.75rem', // 12px
        '4': '1rem',    // 16px
        '5': '1.25rem', // 20px
        '6': '1.5rem',  // 24px
        '7': '1.75rem', // 28px
        '8': '2rem',    // 32px
        '9': '2.25rem', // 36px
        '10': '2.5rem', // 40px
        '11': '2.75rem', // 44px
        '12': '3rem',   // 48px
      },
      colors: {
        'dark-gray': '#1f1f1f',
        'medium-gray': '#2a2a2a',
        'gold': '#e4d198',
        'dark-gold': '#80703a',
        'medium-gold': '#a38f50',
        'light-gold': '#f6f5ec',
        'brand-bg-dark': '#232323', // or your desired hex
      },
      fontFamily: {
        inter: ['Inter', 'sans-serif'],
      },
      backgroundImage: {
        'gradient-brand': 'linear-gradient(to right, var(--tw-gradient-stops))',
        'gradient-brand-br': 'linear-gradient(to bottom right, #f6f5ec, #232323)', // Example: light gold to brand dark
      },
    },
  },
  plugins: [
    require('@tailwindcss/nesting'), // Enable modern CSS nesting
  ],
};