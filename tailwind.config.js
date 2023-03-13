module.exports = {
    mode: 'jit',
    prefix: 'course-',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    darkMode: 'media', // or 'media' or 'class'
    theme: {
        extend: {
        },
    },
    plugins: [
        // require('@tailwindcss/aspect-ratio'),
    ],
}
