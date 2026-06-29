# Known Issues & Gotchas

## Fixed bugs (documented for reference)

### BUG-001 — Nested HTML forms caused project deletion on image ✕ click
**Status:** Fixed  
**Symptom:** Clicking the ✕ button on an image thumbnail deleted the entire project instead of just the image.  
**Root cause:** HTML does not allow nested `<form>` elements. The browser ignores the inner form's open tag. The inner form's `<input name="_method" value="DELETE">` and `<input name="_token">` were parsed as fields of the *outer* project form. When ✕ was clicked, the outer form submitted to the project's URL with `_method=DELETE`, triggering `ProjectController::destroy()`.  
**Fix:** Replaced the nested form with a `fetch()` JS call using the CSRF token from the meta tag.  
**Lesson:** Never put a `<form>` inside another `<form>`. Use `fetch()` for inline destructive actions.

---

### BUG-002 — Upload error modal never appeared (IIFE semicolon bug)
**Status:** Fixed  
**Symptom:** Selecting an oversized file caused the request to never be sent, but no error modal appeared.  
**Root cause:** Two IIFEs in `_form.blade.php` were separated by a blank line with no semicolon:
```js
})()\n\n(function () {
```
JavaScript's ASI (Automatic Semicolon Insertion) does not insert a semicolon before `(`. The parser read this as the first IIFE's return value being called as a function: `(undefined)(function(){...})` → `TypeError`. The error was silent because it happened before the `submit` event listener was registered.  
**Fix:** Added `});` (semicolon) between the two IIFEs.  
**Lesson:** Always terminate IIFEs with `});` — never rely on ASI between IIFE blocks.

---

### BUG-003 — `image:jpeg,png,webp,gif` rule did not validate MIME types
**Status:** Fixed  
**Symptom:** Files with disallowed MIME types were accepted.  
**Root cause:** Laravel's `image` validation rule does not accept parameters. Writing `image:jpeg,png` does not restrict to those types — the parameters are silently ignored. `image` alone only checks that the file is any valid image.  
**Fix:** Changed to `image|mimes:jpeg,png,webp,gif`. The `image` rule checks the generic image constraint; `mimes:` explicitly restricts the allowed types.

---

### BUG-004 — `delete_images.*` and `image_order.*` were not scoped to the current project
**Status:** Fixed  
**Symptom:** A malicious user could submit image IDs belonging to other projects.  
**Root cause:** Validation used `Rule::exists('project_images', 'id')` without a `where` clause, so any valid `project_images.id` would pass.  
**Fix:** Changed to `Rule::exists('project_images', 'id')->where('project_id', $project->id)` — IDs are only valid if they belong to the project being edited.

---

### BUG-005 — nginx `restart` fails after WSL restart
**Status:** Known behaviour (not a bug in the app)  
**Symptom:** `docker compose restart nginx` returns success but nginx serves stale config or fails to bind.  
**Root cause:** WSL bind mount paths change across WSL restarts. The running container has stale mount references.  
**Workaround:** Always use `docker compose up -d --force-recreate nginx` after a WSL restart.

---

### BUG-006 — HomeController still referenced deleted TimelineData after migration
**Status:** Fixed  
**Symptom:** Homepage returned 500 after `TimelineData.php` was deleted. All tests except `ExampleTest` passed, masking the issue until the homepage was hit.  
**Root cause:** `HomeController` had `use App\Data\TimelineData` and called `TimelineData::all()`. When the file was deleted, Composer's autoloader threw a fatal include error.  
**Fix:** Replaced `TimelineData::all()` with `TimelineEntry::orderBy(...)->get()` in `HomeController`. Updated `home.blade.php` to use model property access (`$item->type`, `$item->organization`, etc.) instead of array keys.  
**Lesson:** When deleting a class, grep all controllers and views for references before removing the file.

---

### BUG-007 — View composer on `layouts.public` didn't reach child view sections
**Status:** Fixed  
**Symptom:** `$profile` undefined in the hero and contact sections of `home.blade.php` despite a view composer being registered for `layouts.public`.  
**Root cause:** In Laravel Blade, `@extends` renders the child view's sections in the CHILD view's scope, before the parent layout is rendered. A view composer registered only for `layouts.public` injects variables into the layout template, but NOT into the child view's `@section` blocks. Variables used inside `@section('content')` must come from the controller or a composer registered for the child view itself.  
**Fix:** Changed `View::composer('layouts.public', ...)` to `View::composer(['layouts.public', 'public.*'], ...)` so that any public child view also receives `$profile`.  
**Lesson:** When a Blade variable needs to be available in child view sections AND in the layout, register the view composer for both.

---

## Open issues

### ISSUE-002 — GITHUB_TOKEN not configured
**Status:** Open  
**Detail:** `.env` does not have `GITHUB_TOKEN` set. The "Sync GitHub" button on projects will fail silently (logs the error) until the token is added.  
**Action:** Add a personal access token (classic, `public_repo` scope) to `.env`:
```
GITHUB_TOKEN=ghp_...
```

---

### ISSUE-003 — GCS service account key rotation
**Status:** Open (pre-production)  
**Detail:** GCP service account keys do not expire by default. If the JSON key leaks, it remains valid indefinitely.  
**Action:** Rotate the key every 90 days. GCP Console → IAM → Service Accounts → your account → Keys → delete old, create new, update `GCS_KEY_FILE_JSON` in production env vars.
