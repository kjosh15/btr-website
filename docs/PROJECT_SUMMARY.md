# BTR.is Website – Project Summary

_Last updated: October 26, 2025_

## Goals & Scope
- Refresh the BTR.is marketing site (Astro + Tailwind) to showcase sovereign AI strategy work.
- Ensure all stats are backed by reputable citations.
- Apply consistent typography, quote treatments, and brand assets across EN/IS pages.
- Align layout spacing, partner logos, and background rhythm.
- Prepare for DreamHost GitOps deployment with a simple push-to-deploy workflow.

## Key UX / Content Decisions
- **Hero & Partners**: Added the new BTR icon PNG in the header and hero, introduced a gradient hero background, and enforced grayscale partner logos to keep the palette cohesive.
- **Quote styling**: Created a `quote-card` utility so all blockquotes (Why, Process quote, Mandate) follow the same emphasis.
- **Section rhythm**: Alternated Section backgrounds (hero gradient → muted Why → light Process → muted Team → light Proof → muted CTA) for predictable cadence.
- **Stats**: Updated “Why Sovereign AI Matters Now” stats with the latest AP, Oxford Insights, OECD, and McKinsey sources. Cards show “Source:” with accessible links.
- **Mandate callout**: Reformatted the About-section quote to match the “Strategy is the system.” styling (small-caps label + body).
- **Footer**: Redesigned bottom nav with the new icon, brand statement (“Sovereign AI strategy, partnerships, and planning.”) and simple Privacy/Terms stack on the right.

## Technical Notes
- Built with **Astro** (static output) and **Tailwind**. `npm run dev` for local preview, `npm run build` for final `dist/`.
- Global utility classes live in `src/styles/global.css`.
- Localized content is stored under `src/locales` (strings) and `src/content` (MDX frontmatter).
- Contact form (`src/components/ContactForm.astro`) is not wired to a backend. Once you have a DreamHost mail handler or third-party service, update `forms.combined.action` in the locale JSON and remove the “not yet connected” note.

## Assets
- New brand mark files: `public/brand/btr-icon.png` (primary) and `public/brand/btr-mark.png`.
- Partner logos and carousel assets live in `public/logos`. We applied grayscale filters; no runtime color edits are necessary.

## Deployment Workflow (DreamHost GitOps)
1. **Server prep (already done)**:
   - Bare repo at `~/git/btr-site.git`.
   - Worktree at `~/git/btr-site-work` (used for reference only).
   - `post-receive` hook reset/rsyncs the repo but does **not** run builds anymore.
   - Node 18 remains available via `nvm` if needed.
2. **Local setup**:
   ```bash
   git remote add dreamhost dh_5mmegi@iad1-shared-b8-15.dreamhost.com:~/git/btr-site.git
   ```
3. **Deploy** (build locally, upload with deploy script):
   ```bash
   npm run deploy        # builds and rsyncs dist/ to DreamHost
   git add .
   git commit -m "Your message"
   git push origin main  # optional: keep remote repo in sync
   git push dreamhost main
   ```

_Tip_: `npm run deploy` runs `astro build` and then `rsync -av --delete dist/ dh_5mmegi@iad1-shared-b8-15.dreamhost.com:/home/dh_5mmegi/btr.is/`. Update the command if the path changes.

## Next Steps
- Monitor the contact form mailbox (josh@josh.is) and adjust the PHP handler if you want logs or alternative destinations.
- Keep DNS for `btr.is` pointing at DreamHost; no additional configuration needed.
- Optional: add a GitHub Action to call `npm run deploy` automatically if you prefer CI-driven deployments.

For any future contributors, start by reading this file, then run `npm install` and `npm run dev` to work locally. When you’re ready to publish, run `npm run deploy` followed by the Git pushes above.
