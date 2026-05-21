# Technical Decisions

## ADR-001 — Image upload: per-file 1.5 MB, total 10 MB

**Date:** 2026-05

**Decision:** nginx `client_max_body_size 10M`. Laravel validation `max:1536` (KB) per file, `array|max:20` files per request.

**Reason:** The 10 MB nginx limit matches another project (Salus Totalis SaaS) running on the same server config. 1.5 MB per image is sufficient for portfolio screenshots while keeping uploads fast.

**Note:** nginx enforces the total request size; Laravel enforces the per-file limit. Both layers are needed.

---

## ADR-002 — Client-side upload validation uses inline styles (not Tailwind classes)

**Date:** 2026-05

**Decision:** The upload error modal in `_form.blade.php` uses inline `style=""` attributes instead of Tailwind utility classes.

**Reason:** Tailwind's production build purges classes not found in source files at build time. The modal is rendered by JS at runtime using `style.display = 'flex'`, so any Tailwind classes applied dynamically would be purged. Inline styles are independent of the build pipeline and guaranteed to work.

---

## ADR-003 — Image deletion is deferred (mark-to-delete pattern)

**Date:** 2026-05

**Decision:** Clicking ✕ on an image in the edit form marks it visually (dimmed, red outline) and adds a hidden `delete_images[]` input. Actual deletion happens on "Save Changes", not immediately.

**Reason:** Immediate deletion via a nested `<form>` caused a browser bug (HTML disallows nested forms — inner `_method=DELETE` leaked into the outer form, triggering `Project::destroy()` instead of `ProjectImage::destroy()`). The deferred pattern avoids nested forms entirely and gives the user a chance to undo before saving.

---

## ADR-004 — Image reorder uses HTML5 native Drag and Drop (no library)

**Date:** 2026-05

**Decision:** Image reordering in the project edit form uses the browser's native `draggable` / `dragstart` / `dragover` / `dragend` API, with hidden `image_order[]` inputs synced on drop.

**Reason:** No external dependency, CSP-safe, no npm package needed. Sufficient for a simple grid reorder use case.

---

## ADR-005 — Timeline migrated from static PHP array to DB

**Date:** 2026-05

**Decision:** Content previously hardcoded in `app/Data/TimelineData.php` was migrated to the `timeline_entries` table. The file was deleted.

**Reason:** The static array required a code deploy for every content change. The admin CRUD allows adding courses, certifications, and new jobs without touching code.

**Migration note:** The three original entries (Tempos Brilhantes, Icatu Seguros, Estácio de Sá) need to be recreated via the admin panel. Translation keys (`timeline.job.*`, `timeline.edu.*`) in `lang/en.json` and `lang/pt_BR.json` are now unused and can be cleaned up.

---

## ADR-006 — SkillTag skills are free-text strings in TimelineEntry, not FK relations

**Date:** 2026-05

**Decision:** `timeline_entries.skills` is a JSON column storing plain strings, not a pivot to `skill_tags`.

**Reason:** Timeline skill lists are display-only badges and often include technologies not in the curated `skill_tags` list. Keeping them as free text avoids join complexity and allows ad-hoc entries like "GitLab CI" or "Moodle" that aren't portfolio skills.

---

## ADR-008 — Oracle Cloud Object Storage for production images

**Date:** 2026-05

**Decision:** Production image storage uses Oracle Cloud Object Storage (S3-compatible API) via a dedicated `oracle` disk in `config/filesystems.php`. Locally, `FILESYSTEM_DISK=public`; in production, `FILESYSTEM_DISK=oracle`.

**Reason:** Oracle Cloud Free Tier includes 20 GB object storage with no time limit. Railway free trial expired. Storage::url() and $file->store() use the default disk, so no disk is hardcoded in controllers — swapping is a single env var change.

**Security notes:**
- Credentials (`ORACLE_KEY`, `ORACLE_SECRET`) are env-only, never in code or version control.
- Bucket visibility is public (portfolio images must be publicly accessible).
- `use_path_style_endpoint: true` required for Oracle's S3-compatible endpoint.
- CORS on the bucket must be restricted to the production domain (see ISSUE-003).
- Customer Secret Keys should be rotated every 90 days (see ISSUE-004).
- `'throw' => false` means upload failures return `false` instead of throwing; `storeImages()` logs the error and skips the DB record.

---

## ADR-009 — CSP allows unsafe-inline and unsafe-eval (Alpine.js trade-off)

**Date:** 2026-05

**Decision:** `Content-Security-Policy` includes `'unsafe-inline'` and `'unsafe-eval'` in `script-src`.

**Reason:** Alpine.js v3 evaluates `x-data`, `x-on`, and `x-bind` expressions via `new Function()`, which requires `'unsafe-eval'`. Removing it breaks Alpine entirely. `'unsafe-inline'` is needed for Blade-rendered inline scripts (locale switching, project modal data). Upgrading to Alpine v4 with nonce-based CSP is the long-term fix but is out of scope for this version.

**Mitigation:** `default-src 'self'` prevents loading external scripts. All user-controlled data is rendered via `{{ }}` (escaped) or `x-text` (auto-escaped), so the XSS surface is contained.

---

## ADR-007 — Validation treats frontend and backend as independent

**Date:** 2026-05

**Decision:** Every field is fully validated server-side regardless of what HTML attributes (`required`, `maxlength`, `type="url"`) are present in the form.

**Reason:** HTML constraints are cosmetic — any HTTP client can bypass them. Backend validation is the authoritative layer.
