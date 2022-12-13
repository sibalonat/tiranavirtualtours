const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Space Grotesk", ...defaultTheme.fontFamily.sans],
                // body: ['']
            },
            colors: {
                "virtual-blue": "#0019DA",
                "gray-circles": "#E5E7EB",
            },
            width: {
                23: "400px",
            },
            gridTemplateColumns: {
                16: "repeat(16, minmax(0, 1fr))",
            },
            zIndex: {
                2: "2000",
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
