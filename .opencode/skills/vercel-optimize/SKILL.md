---
name: vercel-optimize
description: "Use for Vercel cost and performance optimization on deployed projects, especially Next.js, SvelteKit, Nuxt, and limited Astro apps."
metadata:
  version: "1.2.0"
---

# Vercel Optimize

Run an observability-first Vercel optimization audit. Do not inspect source files until signals exist and a deterministic gate points to a route, file, or project setting.

Core doctrine: metrics first, deterministic gates, candidate-bound scope, version-aware citations.

## Pipeline
1. Collect, scan, and merge signals
2. Gate candidates
3. Deep-dive and reconcile
4. Generate briefs and investigate
5. Verify recommendations
6. Render report

See `references/` directory for detailed documentation on data collection, candidates, recommendations, and verification.
