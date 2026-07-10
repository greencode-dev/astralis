---
name: vercel-react-view-transitions
description: Guide for implementing smooth, native-feeling animations using React's View Transition API. Use when the user wants to add page transitions, animate route changes, create shared element animations, animate enter/exit of components, or implement directional navigation animations.
license: MIT
metadata:
  author: vercel
  version: "1.0.0"
---

# React View Transitions

Animate between UI states using the browser's native `document.startViewTransition`. Declare *what* with `<ViewTransition>`, trigger *when* with `startTransition`, control *how* with CSS classes.

## When to Animate

Every `<ViewTransition>` should communicate a spatial relationship or continuity. Implement in order:
1. Shared element (`name`) - "Same thing — going deeper"
2. Suspense reveal - "Data loaded"
3. List identity (per-item `key`) - "Same items, new arrangement"
4. State change (`enter`/`exit`) - "Something appeared/disappeared"
5. Route change (layout-level) - "Going to a new place"

## Core Concepts

The `<ViewTransition>` component auto-assigns `view-transition-name` and calls `document.startViewTransition`. Never call it yourself.

### Animation Triggers
- **enter** - VT first inserted during a Transition
- **exit** - VT first removed during a Transition
- **update** - DOM mutations inside a VT
- **share** - Named VT unmounts and another with same `name` mounts

### Critical Placement Rule
`<ViewTransition>` only activates enter/exit if it appears **before any DOM nodes**.

### Transition Types
Tag transitions with `addTransitionType` so VTs can pick different animations:
```jsx
startTransition(() => {
  addTransitionType('nav-forward');
  router.push('/detail/1');
});
```

See `references/` directory for CSS recipes, implementation workflow, and Next.js integration.
