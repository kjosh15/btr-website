import { defineCollection, z } from 'astro:content';

const baseSection = z.object({
  section: z.string(),
  eyebrow: z.string().optional(),
  heading: z.string().optional(),
  headline: z.string().optional(),
  subheadline: z.string().optional(),
  supportLine: z.string().optional(),
  quote: z.string().optional(),
  caption: z.string().optional(),
  primaryCtas: z
    .array(
      z.object({
        label: z.string(),
        href: z.string(),
        variant: z.string().optional(),
        external: z.boolean().optional(),
      }),
    )
    .optional(),
  cta: z
    .object({
      label: z.string(),
      href: z.string(),
      variant: z.string().optional(),
      external: z.boolean().optional(),
    })
    .optional(),
  ctas: z
    .array(
      z.object({
        label: z.string(),
        href: z.string(),
        variant: z.string().optional(),
        external: z.boolean().optional(),
      }),
    )
    .optional(),
  logos: z
    .array(
      z.object({
        name: z.string(),
        file: z.string().optional(),
      }),
    )
    .optional(),
  stats: z
    .array(
      z.object({
        value: z.string(),
        label: z.string(),
        source: z.string().optional(),
      }),
    )
    .optional(),
  calloutTitle: z.string().optional(),
  calloutBody: z.string().optional(),
  steps: z
    .array(
      z.object({
        title: z.string(),
        description: z.string(),
      }),
    )
    .optional(),
  cases: z
    .array(
      z.object({
        title: z.string(),
        summary: z.string(),
      }),
    )
    .optional(),
  benefits: z.array(z.string()).optional(),
});

const localeCollection = defineCollection({
  type: 'content',
  schema: baseSection,
});

export const collections = {
  en: localeCollection,
  is: localeCollection,
};
