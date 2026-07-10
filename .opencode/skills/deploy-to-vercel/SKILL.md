---
name: deploy-to-vercel
description: Deploy applications and websites to Vercel. Use when the user requests deployment actions like "deploy my app", "deploy and give me the link", "push this live", or "create a preview deployment".
metadata:
  author: vercel
  version: "3.0.0"
---

# Deploy to Vercel

Deploy any project to Vercel. **Always deploy as preview** (not production) unless the user explicitly asks for production.

## Step 1: Gather Project State
Run all four checks before deciding which method to use:
```bash
git remote get-url origin 2>/dev/null
cat .vercel/project.json 2>/dev/null || cat .vercel/repo.json 2>/dev/null
vercel whoami 2>/dev/null
vercel teams list --format json 2>/dev/null
```

## Step 2: Choose a Deploy Method
- **Linked + has git remote** → Git push (commit + push, Vercel builds automatically)
- **Linked + no git remote** → `vercel deploy -y --no-wait`
- **Not linked + CLI authenticated** → Link first, then deploy
- **Not linked + CLI not authenticated** → Install, auth, link, deploy
- **No-auth fallback** → Use deploy script from `resources/deploy.sh`

## Output
Always show the user the deployment URL. Do not curl/fetch to verify.
