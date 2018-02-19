# Changelog

## 1.0.6
- Added an extra div to `body-header` component. Related to fixing a bug in hogan-grid. See [hogan-grid#18][https://github.com/DekodeInteraktiv/hogan-grid/issues/18]

## 1.0.5
- Use `medium_large` image size as default for all cards.
- Add filter `savage/card/components/image/size` for setting custom image size.
- Custom card does not require a layout as default. Can use savage meta fields with default card for simpler custom card.

## 1.0.4
- Added `Icon` component.
- Added `Avatar` component.
- Added support for custom attributes on heading component
- Switched from `plugins_loaded` to `after_setup_theme` to allow themes to register new cards.

## 1.0.3
- Added new component link teaser

## 1.0.2
- Deprecated `savage/card/meta/tagline_types` filter.
- Added new component to default card: label.
- Renamed Card meta field tagline to label (affects content).
- Added filter to set rules for auto-label: `savage/card/components/label/auto`
