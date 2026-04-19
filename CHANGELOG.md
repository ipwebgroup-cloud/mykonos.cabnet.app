# Changelog

## v7.38.00 - inquiry record recovery completion check strip
- added a backend-only render-safe strip that checks whether both recovery fixes are now complete enough to proceed with the current queue move
- package includes the new partial and the exact fields.yaml snippet required to mount it safely without blindly overwriting the current live form configuration
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change
