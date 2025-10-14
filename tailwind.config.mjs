const config = {
  content: [
    './src/**/*.{astro,html,js,jsx,ts,tsx,md,mdx}',
  ],
  theme: {
    extend: {
      colors: {
        'btr-bg': '#ffffff',
        'btr-muted': '#f2f4f7',
        'btr-text': '#14171f',
        'btr-accent': '#1f75cb',
        'btr-accent-muted': '#1f8f9c',
        'btr-cta': '#0f1c2b',
      },
      fontFamily: {
        heading: ['"Inter"', '"Poppins"', 'system-ui', 'sans-serif'],
        body: ['"IBM Plex Sans"', '"Source Sans Pro"', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
};

export default config;
