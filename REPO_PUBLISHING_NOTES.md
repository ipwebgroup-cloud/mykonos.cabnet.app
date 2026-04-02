# Mykonos Cabnet Repo Publishing Notes

This package is prepared for creating a Git repository from the live OctoberCMS project source.

Included:
- application source
- plugins
- themes
- modules
- composer files
- safe storage skeleton

Excluded:
- `.env`
- `auth.json`
- `vendor/`
- runtime storage contents
- `php.ini`
- `.user.ini`
- SQL dumps
- zip archives

Recommended first steps:
1. Initialize the repo from this folder.
2. Review `.gitignore`.
3. Commit the current application baseline.
4. Keep the repository private unless you intentionally remove any proprietary content.
