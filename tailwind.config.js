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
    },
    borderRadius: {
      'none': '0',
       'sm': '5px',
       DEFAULT: '0.25rem',
       DEFAULT: '10px',
       'md': '20px',
       'lg': '50px',
       'full': '9999px',
       'large': '12px',
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
