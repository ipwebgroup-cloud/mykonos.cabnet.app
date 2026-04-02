# Cabnet Mykonos Inquiry Plugin v1.0.7

## Install path

This is a custom plugin package for manual installation.

1. Upload the zip or extracted folder to your OctoberCMS project.
2. Final plugin path must be:

```text
plugins/cabnet/mykonosinquiry
```

3. Run one of the following:

```bash
php artisan plugin:refresh Cabnet.MykonosInquiry
```

or

```bash
php artisan october:up
```

## What it does

- stores plan submissions in `cabnet_mykonos_inquiries`
- keeps the request reference sent from the public plan form when present
- generates a server-side reference when the form does not send one
- sends notification email to `mykonos@cabnet.app`
- adds backend inquiry list + detail screens

## Recommended next step

Install the matching theme integration package so `/plan` saves into this plugin instead of sending email only.


## v2.3 bridge note
- `PlanBridge` now returns the saved request reference and context fields back to the theme AJAX success handler so the public continuity layer can use the database-confirmed reference instead of only the client-generated placeholder.


## v2.4 backend detail note
- Inquiry records now expose operator-friendly overview summaries in the backend.
- The list view surfaces arrival timing, guest count, and service focus more clearly.
- Active/open/closed queue scopes were added for faster daily triage.
- Reopening an inquiry now clears stale `closed_at` values automatically.
