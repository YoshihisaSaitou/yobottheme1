## Change Specification Rules for Block Theme Development

When modifying or adding template parts, patterns, templates, styles, scripts, or theme behavior, you must manage the change specification under `spec/changes/` if the change is medium or large in scope.

### When to use `spec/changes/`

Create a change specification in `spec/changes/<change-name>/` when any of the following applies:

- A new part, pattern, or template is added
- Existing part, pattern, or template behavior changes
- CSS or JavaScript files are newly added for a pattern or part
- File loading rules in `functions.php` or `init.php` change
- `theme.json` settings change
- Layout rules such as width, spacing, typography, or accessibility behavior change
- Naming conventions or file placement rules change
- The impact spans multiple files or multiple directories

For small text-only or trivial markup fixes, update the main spec files directly instead of creating a change spec.

### Directory structure

Store change specifications under:

`/spec/changes/<change-name>/`

Each change directory should contain:

- `requirements.md`
- `design.md`
- `tasks.md`
- `acceptance.md` (optional but recommended)

Example:

`/spec/changes/add-pagetop-pattern/requirements.md`  
`/spec/changes/add-pagetop-pattern/design.md`  
`/spec/changes/add-pagetop-pattern/tasks.md`  
`/spec/changes/add-pagetop-pattern/acceptance.md`

### Naming rules

Use clear kebab-case names for change directories.

Examples:

- `add-pagetop-pattern`
- `update-header-layout`
- `add-post-list-pattern-2`
- `refactor-theme-css-loading`

Do not use vague names such as:

- `fix1`
- `update`
- `test`
- `misc-changes`

### Document responsibilities

#### `requirements.md`
Describe what must change from a business, editorial, UI, or operational perspective.

Include:

- Purpose of the change
- Scope
- User-facing behavior
- Files or areas affected at a high level
- Constraints and non-goals

#### `design.md`
Describe how the change will be implemented.

Include:

- Target files
- New files to create
- Existing files to update
- Loading/enqueue behavior
- Dependency relationships between parts, patterns, templates, CSS, and JS
- Notes on `theme.json`, accessibility, layout, and compatibility

#### `tasks.md`
Break the implementation into concrete tasks.

Tasks must be small, explicit, and executable.

Include:

- File creation tasks
- File modification tasks
- Registration/loading tasks
- Verification tasks
- Cleanup tasks

#### `acceptance.md`
Define the completion criteria.

Include:

- What must be visible or selectable in WordPress admin
- What must render on the front end
- What CSS/JS behavior must work
- What templates, parts, or patterns must load correctly
- Regression checks if existing behavior must remain unchanged

### Required workflow

Do not implement medium or large changes immediately.

You must follow this order:

1. Create or update `requirements.md`
2. Create or update `design.md`
3. Create or update `tasks.md`
4. Wait for approval
5. Implement
6. Verify against `acceptance.md`

### Relationship to main spec files

The main spec files under `/spec/` represent the current baseline of the theme.

Use them as follows:

- `/spec/requirements.md` = baseline product requirements
- `/spec/design.md` = baseline architecture and file structure
- `/spec/tasks.md` = baseline implementation tasks if needed
- `/spec/acceptance.md` = baseline acceptance rules

Use `/spec/changes/` for change-specific work before implementation.

After the change is completed and accepted, update the main spec files if the baseline behavior or structure has changed.

### Rules for block theme files

For block theme changes, the change spec must explicitly describe any affected items such as:

- `patterns/*.php`
- `parts/*.html`
- `templates/*.html`
- `assets/css/*.css`
- `assets/js/*.js`
- `functions.php`
- `init.php`
- `theme.json`

If a pattern has dedicated CSS or JavaScript, the design spec must state the related files and naming convention.

Example:

- `patterns/pagetop-custom-block-pattern-1.php`
- `assets/css/pagetop-custom-block-pattern-1.css`
- `assets/js/pagetop-custom-block-pattern-1.js`

### Restrictions

Do not:

- Put specification documents inside `patterns/`, `parts/`, `templates/`, or `assets/`
- Create ad-hoc markdown files in the project root for temporary specifications
- Skip spec updates when changing layout, naming, loading rules, or behavior
- Implement from assumptions without documented requirements and design

### Small change rule

For very small changes, such as:

- Typo fixes
- Minor wording changes
- Small markup corrections with no structural impact
- CSS fixes limited to an existing rule with no design impact

Update the main spec files only when needed, and do not create a `spec/changes/` directory unless the change affects behavior, structure, loading, or reuse.

### Completion rule

A change is not complete unless:

- Implementation matches the change spec
- Acceptance criteria are checked
- Baseline spec is updated if the permanent structure or behavior changed