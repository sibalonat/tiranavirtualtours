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
            },
            colors: {
                "virtual-blue": "#0019DA",
                "gray-circles": "#E5E7EB",
            },
            width: {
                23: "400px",
                85: "80%",
                92: "92%",
            },
            gridTemplateColumns: {
                16: "repeat(16, minmax(0, 1fr))",
            },
            zIndex: {
                2: "2000",
            },
            inset: {
                "4/4": "40%",
            },
            margin: {
                22: "5.8rem",
                51: "12.08rem",
                58: "13.3rem",
            },
            strokeWidth: {
                3: "3px",
            },
            // spacing: {
            //     if height of pathVertical2 is bigger than 150px
            //     18: "4.7rem",
            // },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
