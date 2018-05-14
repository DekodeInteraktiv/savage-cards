# Changelog

## 1.0.15
- Added theme option field [#52](https://github.com/DekodeInteraktiv/savage-cards/pull/52)
- Added filter to image url for featured image [#51](https://github.com/DekodeInteraktiv/savage-cards/pull/51)

## 1.0.13
- Added default link text on custom cards. [#48](https://github.com/DekodeInteraktiv/savage-cards/pull/48)

## 1.0.12
- Removed required constraint on alternativ image in card meta box because it caused Gutenberg to break.

## 1.0.11
- Moved custom card content into actions so themes can unregister/register their own content [#42](https://github.com/DekodeInteraktiv/savage-cards/pull/42)

## 1.0.10
- Add classes for background color on custom card.

## 1.0.9
- Add menu order to field group [#39](https://github.com/DekodeInteraktiv/savage-cards/pull/39)

## 1.0.8
- Auto register custom cards to [Hogan-Grid](https://github.com/DekodeInteraktiv/hogan-grid) static cards relationship field.
- Custom cards can have layouts or use default card components.

## 1.0.7
- Added meta component. See [#31](https://github.com/DekodeInteraktiv/savage-cards/pull/31)

## 1.0.6
- Added an extra div to `body-header` component. Related to fixing a bug in hogan-grid. See [hogan-grid#18](https://github.com/DekodeInteraktiv/hogan-grid/issues/18)

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
