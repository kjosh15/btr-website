import { defineConfig } from 'astro/config';
import tailwind from '@astrojs/tailwind';

const isDev = process.env.NODE_ENV === 'development';

export default defineConfig({
  base: isDev ? '/' : './',
  trailingSlash: 'never',
  integrations: [
    tailwind({
      applyBaseStyles: false,
    }),
  ],
  site: 'https://btr.is',
  build: {
    assetsPrefix: isDev ? undefined : '.',
  },
});
