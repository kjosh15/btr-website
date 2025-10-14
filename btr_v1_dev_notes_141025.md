# BTR.is Developer Handoff (for Codex)

This README gives you everything needed to build and deploy the BTR.is single page website. It includes context, IA, design guidance, tech choices, i18n, analytics, forms, and deployment steps. The goal is a lightweight, fast, and easily editable site.

---

## 1. Purpose and Context

**What BTR is**  
BTR designs Sovereign AI strategies for governments and organizations. BTR focuses on strategy, discovery, and validation. Implementation is handled by partners guided by BTR specifications.

**Primary goals**  
- Establish BTR as a strategic leader with international scope  
- Serve governments and technology partners equally well  
- Keep the site light, fast, and easy to edit  
- Support Icelandic first, then English  

**Important resources**  
- Final site copy is in the canvas titled “Btr Single Page Site”  
- Logo source reference: https://josh.is/clients/ (curate locally for the carousel)  
- PDFs to host: `BTR_OnePage_Overview.pdf`, `BTR_Sovereign_AI_Model.pdf`

---

## 2. Information Architecture

Single page with anchors:
1. Hero  
2. Why Sovereign AI Matters Now  
3. Our Strategic Process  
4. Proof of Approach  
5. For Governments  
6. For Technology and Institutional Partners  
7. About BTR  
8. Experience That Built BTR  
9. Final CTA  

Footer contains legal links and contact details.

---

## 3. Content Guidelines

**Brand line for meta and social**  
Title: `BTR — Designing Sovereign AI Strategies`  
Let body copy imply governments and organizations equally.

**Voice**  
Calm, precise, strategic, and international. Avoid hype. Avoid slang. No exclamation marks. 

**Editing**  
All text must be easy to tweak. Prefer markdown or JSON locale files over hard coded strings.

---

## 4. Visual and UX System

**Aesthetic**  
Nordic minimal, white space, clear hierarchy.

**Type**  
- Headings: Inter or Poppins  
- Body: IBM Plex Sans or Source Sans Pro  
System fallback stack should be defined.

**Color**  
- Background: white and very light gray sections  
- Text: near black for body  
- Accent: muted cobalt or teal for links and CTAs  
- Footer and final CTA: deep blue gray or charcoal  
All color choices must meet WCAG 2.2 AA.

**Logos**  
Grayscale. Equal height normalization. Slight hover to color is allowed but keep it subtle.

**Motion**  
Gentle fades. Smooth anchor scroll. No heavy animations.

**Accessibility**  
Keyboard navigation, visible focus states, proper landmarks, alt text for all images, ARIA where needed.

---

## 5. Internationalization (mandatory)

**Requirement**  
Icelandic and English must both be present. Icelandic will become the default once translations are finalized.

**Routing**  
- During initial build: default route `/` serves English  
- Add `/is/` for Icelandic  
- After translations are approved: set `/` to serve Icelandic and route English to `/en/`  
- Provide a language toggle in the header that persists user choice via cookie or localStorage

**Storage format**  
- Use locale JSON files: `/locales/en.json` and `/locales/is.json` for UI strings  
- Put section bodies in markdown per locale, for example:  
  - `/content/en/hero.md`, `/content/is/hero.md`  
  - Follow this pattern for each section  
- Prefer MDX if you need inline components

**Build time checks**  
Fail the build if a key is missing in either locale.

---

## 6. Tech Stack

**Preferred**  
- Astro static site with Content Collections for markdown  
- TailwindCSS for utility styling  
- Minimal client JS

**Alternative**  
- Next.js with static export and Contentlayer  
- Hugo with multilingual config

**Why**  
Astro is fast, simple, and excels at content sites. It supports i18n and markdown well.

---

## 7. Forms

Two forms are needed.

**Government Briefing Request**  
Fields: Name, Title, Organization, Email, Message  
Target: `gov@btr.is`

**Partner Inquiry**  
Fields: Name, Company, Role, Email, Message  
Target: `partners@btr.is`

**Implementation options**  
- Easiest: Formspree or Basin.  
- OSS or self hosted: small Node or Deno function that sends via SMTP. Put the function in repo under `api/` and deploy to a serverless host or DreamHost CGI. Use environment variables for SMTP credentials.  
- Add Honeypot and basic rate limit.

---

## 8. Analytics

Use Google Analytics 4.

**Implementation**  
- Add GA4 measurement ID via environment variable `GA_MEASUREMENT_ID`  
- Anonymize IP and honor DNT  
- Track three events: `cta_gov_briefing`, `cta_partner_conversation`, `cta_pdf_download`  
- Track scroll depth at 50 and 90 percent

---

## 9. PDFs

Host two PDFs in `/public/pdfs/`:
- `BTR_OnePage_Overview.pdf`  
- `BTR_Sovereign_AI_Model.pdf`  
CTAs in Hero and Proof sections must link to these files.

---

## 10. Logo Carousel

**Source**  
Curate logos from https://josh.is/clients/ and save each logo as SVG or high res PNG in `/public/logos/`.

**Display**  
- Grayscale strip with slow loop  
- Pause on hover  
- Keyboard navigable  
- Caption: “Selected prior collaborations through Josh Klein’s independent consulting practice.”

**Performance**  
- Use `loading="lazy"`  
- Pre-size images to a consistent height

---

## 11. Performance Targets

- Lighthouse Performance 95+ on mobile  
- Core Web Vitals green  
- Total JS under 100 KB gzip  
- Images optimized and lazy loaded  
- Preload heading font only

---

## 12. SEO and Social

**Meta**  
- Title: `BTR — Designing Sovereign AI Strategies`  
- Description: short sentence that positions BTR as a strategy-first partner that turns context into buildable specifications

**Open Graph**  
- OG title equals meta title  
- OG image: 1200x630 PNG in `/public/og.png`  
- Twitter card summary large image

**Sitemap and robots**  
- Generate `/sitemap.xml` and `/robots.txt`

---

## 13. Code Structure (Astro example)

```
/
  astro.config.mjs
  package.json
  tailwind.config.js
  src/
    components/
      Header.astro
      Footer.astro
      LogoCarousel.astro
      LangToggle.astro
      CtaButtons.astro
    layouts/
      BaseLayout.astro
    pages/
      index.astro
      is/index.astro
      en/index.astro   
    content/
      en/
        hero.md
        why.md
        process.md
        proof.md
        gov.md
        partners.md
        about.md
        experience.md
        final-cta.md
      is/
        hero.md
        why.md
        process.md
        proof.md
        gov.md
        partners.md
        about.md
        experience.md
        final-cta.md
    locales/
      en.json
      is.json
  public/
    logos/
      ...curated-logos
    pdfs/
      BTR_OnePage_Overview.pdf
      BTR_Sovereign_AI_Model.pdf
    og.png
```

---

## 14. Build and Dev Scripts

**Install**  
`npm install`

**Dev**  
`npm run dev`

**Build**  
`npm run build`

**Preview**  
`npm run preview`

**Environment variables**  
- `GA_MEASUREMENT_ID`  
- `SMTP_HOST`, `SMTP_USER`, `SMTP_PASS` if using self hosted forms

---

## 15. Deployment

**DreamHost**  
- Build to `dist/`  
- Upload `dist/` via SFTP to your domain directory  
- Ensure `.htaccess` supports clean URLs if needed

**Cloudflare Pages (alternative)**  
- Connect repo  
- Build command: `npm run build`  
- Output directory: `dist`  
- Set environment variables in dashboard

**DNS via ISNIC**  
- Set A and CNAME records to host provider values  
- Confirm AAAA records if provided  
- Enable SSL

---

## 16. QA Checklist

- Content matches the “Btr Single Page Site” canvas  
- i18n toggle visible and working  
- Icelandic route available at `/is`  
- Once approved, default route serves Icelandic  
- CTAs functional: two forms and two PDF links  
- GA events captured  
- Carousel accessible and performant  
- SEO tags present  
- Lighthouse green across the board  
- 404 page present and localized

---

## 17. Future Enhancements

- Add Insights page with thought leadership  
- Add press kit with bio, headshot, and boilerplate  
- Add newsletter sign up using OSS stack or a vendor of choice  
- Add case study pages once public  

---

## 18. Contact

- Government intake: `gov@btr.is`  
- Partner intake: `partners@btr.is`  
- General: `hello@btr.is`  

That is everything needed to build BTR.is as a clean, fast, multilingual single page site with a clear editing model and minimal maintenance.