# Repo Cleanup Delete List

This patch zip can overwrite and add files, but it cannot safely remove already tracked files from your local repo by extraction alone.

Before committing this cleanup patch in GitHub Desktop, manually delete these from the local repo working copy if they are still tracked:

- `php.ini`
- `.user.ini`

For `storage/`, keep only the skeleton placeholders that belong in source control.

Recommended kept placeholders:
- `storage/app/.gitignore`
- `storage/cms/.gitignore`
- `storage/framework/.gitignore`
- `storage/logs/.gitignore`
- `storage/temp/.gitignore`

Recommended removal from repo tracking:
- runtime logs
- runtime cache files
- generated twig/cache/combiner files
- uploaded or temporary server-local artifacts that are not intentional source assets

After deleting those files locally, GitHub Desktop should show them as deletions, and you can commit that cleanup together with this patch.
