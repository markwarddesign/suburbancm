module.exports = {
    parser: 'postcss-scss', // Use SCSS parser for PostCSS
    plugins: [
        require('postcss-import'), // Handles @import statements
        require('tailwindcss'), // TailwindCSS integration
        require('postcss-nested'), // Enables nested CSS rules
        require('autoprefixer'), // Adds vendor prefixes for browser compatibility
    ],
};