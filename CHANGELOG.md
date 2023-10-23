# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.2.082] - 2023-09-30

### Added

- Logout functionality using `keyboard` shortcut (1e62127)

<!-- ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->

# [Unreleased]

## [1.1.073] - 2023-09-24

<!-- ### Added

- lore10 -->

### Fixed

- KeyBinding (f3997b5) `Shift -> Alt+Shift`...

<!-- ### Removed

- lore10 -->

<!-- ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->

## [1.0.066] - 2023-09-22

### Added

- Context menu (f3b0a2d)
- Action menu (f3b0a2d)

### Fixed

- Context menu (807d269)

## [First Patch]

```powershell
npx nativefier --name "Admin-Private Jet" -i "./icon.ico" --inject "./admin-context.js" --disable-dev-tools --build-version "0.0.073-beta" --app-version "0.07"  --show-menu-bar --bookmarks-menu "./admin_menu-Action.json" --min-width "1360" --min-height "768" --ignore-certificate --portable "http://localhost/admin/"
```
