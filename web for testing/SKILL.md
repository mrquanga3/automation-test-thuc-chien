# SKILL.md — Claude Code Skills

Available slash commands (skills) for this project. Run them by typing `/<name>` in the Claude Code prompt.

## `/init`
Regenerates or updates `CLAUDE.md` by re-reading the codebase.
Use when the project structure changes significantly.

## `/review`
Reviews a pull request — reads the diff and gives structured feedback on correctness, style, and potential issues.
Use before merging any branch.

## `/security-review`
Runs a security-focused review of pending changes on the current branch.
Checks for injection vulnerabilities, exposed credentials, insecure configs, and OWASP Top 10 issues.
Useful before pushing changes that touch auth, API keys, or database queries.

## `/simplify`
Reviews recently changed code for unnecessary complexity, duplication, and quality issues, then applies fixes.
Use after a feature is working but before final commit.

## `/ultrareview`
Launches a multi-agent cloud review of the current branch (or `/ultrareview <PR#>` for a GitHub PR).
More thorough than `/review` — spawns parallel agents to analyse different aspects.
Requires a git repository; billed separately.
