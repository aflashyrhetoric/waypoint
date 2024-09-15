/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/views/livewire/**/*.blade.php",
    ],
    theme: {
        extend: {},
    },
    plugins: [],

    // Redefine base sans font to be figtree
    fontFamily: {
        sans: ['figtree', 'sans-serif'],
    },
}

