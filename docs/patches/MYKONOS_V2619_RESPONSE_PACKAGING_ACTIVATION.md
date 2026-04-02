# Mykonos Inquiry Plugin v2.6.19 Response Packaging Activation

## What this patch does
- reintroduces the **Response Packaging** panel on the Internal tab
- keeps the panel read-only and scan-first
- helps the operator decide whether the next move should be a clarification touch, starter package, or fuller guest-facing package

## Scope
- backend detail screen only
- no schema change
- no public theme change
- no list filter change

## Files changed
- `plugins/cabnet/mykonosinquiry/models/inquiry/fields.yaml`
- `plugins/cabnet/mykonosinquiry/updates/version.yaml`
- `CHANGELOG.md`
- `docs/patches/MYKONOS_V2619_RESPONSE_PACKAGING_ACTIVATION.md`
