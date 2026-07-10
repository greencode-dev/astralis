---
name: vercel-cli-with-tokens
description: Deploy and manage projects on Vercel using token-based authentication. Use when working with Vercel CLI using access tokens rather than interactive login.
metadata:
  author: vercel
  version: "1.0.0"
---

# Vercel CLI with Tokens

Deploy and manage projects on Vercel using the CLI with token-based authentication, without relying on `vercel login`.

## Step 1: Locate the Vercel Token
Check `VERCEL_TOKEN` env var, then `.env` files. Never pass token as `--token` flag.

## Step 2: Locate Project and Team
Check `VERCEL_PROJECT_ID`, `VERCEL_ORG_ID` env vars or extract from project URL.

## Deploying
- **Quick deploy** (have project ID): `vercel deploy -y --no-wait`
- **Full deploy** (need to link): `vercel link --repo --scope <team-slug> -y` then deploy

Always deploy as preview unless explicitly asked for production.
