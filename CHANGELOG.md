# Changelog

## v7.37.00 - inquiry record two fix recovery summary strip
- added a backend-only render-safe strip that summarizes the shortest two-step recovery path when one fix alone is not enough
- package includes the new partial and the exact fields.yaml snippet required to mount it safely without blindly overwriting the current live form configuration
- no schema change
- no plugin refresh required
- no theme import required
- no /plan behavior change
