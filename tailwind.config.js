const colors = require('tailwindcss/colors');
module.exports = {
  purge: {
    content: [
      "./templates/*.twig",
      "./templates/**/*.twig",
      "./plugins/**/*.twig",
      "./plugins/**/*.php",
      "./../../plugins/ctx-blocks/templates/*.twig",
      "./../../plugins/events-manager-pro/templates/*.php",
      "./assets/purge.html"
    ]
  },
  theme: {
    
    extend: {},
    colors: {
      "primary": {
        contrast: "var(--primary-contrast)",
        transparent: "var(--primary-transparent)",
        contrastsoft: "var(--primary-soft-contrast)",
        lighter: "var(--primary-lighter)",
        DEFAULT: "var(--primary)",
        darker: "var(--primary-darker)",
      },
      "secondary": {
        contrast: "var(--secondary-contrast)",
        transparent: "var(--secondary-transparent)",
        contrastsoft: "var(--secondary-soft-contrast)",
        lighter: "var(--secondary-lighter)",
        DEFAULT: "var(--secondary)",
        darker: "var(--secondary-darker)",
      },
      transparent: 'transparent',
      current: 'currentColor',
      black: colors.black,
      white: colors.white,
      gray: colors.trueGray,
      blue: colors.blue,
      red: colors.rose,
      green: colors.green,
    },
    fontFamily: {
      display: ['"Exo 2"', 'sans-serif'],
      body: ['"Exo 2"', 'sans-serif'],
      script: ['"Gochi Hand"', 'sans-serif'],
    },
    backdropFilter: { // DEFAULTs to {}
      'none': 'none',
      'blur': 'blur(10px)',
      'blur-20': 'blur(20px)',
      'blur-5': 'blur(5px)',
    }
  },
  future: {
    removeDeprecatedGapUtilities: true,
    purgeLayersByDEFAULT: true
  },
  variants: {
    borderRadius: ['responsive', 'last', 'first', 'hover', 'focus']
  }
}
