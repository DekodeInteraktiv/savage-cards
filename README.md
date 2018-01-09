# Savage
Hogan + Savage = The Mega Powers!

A plugin for setting up a card view for different content. Intended for use with [Hogan Grid](https://github.com/DekodeInteraktiv/hogan-grid).

Also contains a custom post type for custom global cards.

## Installation
Install the module using Composer `composer require dekodeinteraktiv/savage-cards` or simply by downloading this repository and placing it in `wp-content/plugins`

## Available filters
Meta fields filters:
- `savage/card/meta/image_types` - customize dropdown for card image options
```
//default values
[
	'featured' => __( 'Use featured image', 'savage-cards' ),
	'alternative' => __( 'Use alternative image', 'savage-cards' ),
	'none' => __( 'No image', 'savage-cards' ),
]
```
- `savage/card/meta/tagline_types` - customize dropdown for card tagline types
```
//default values
[
	'none' => __( 'No tagline', 'savage-cards' ),
	'auto' => __( 'Auto', 'savage-cards' ),
	'manual' => __( 'Manual', 'savage-cards' ),
]
```
- `savage/card/meta/locations` - for adding locations to the ACF field group.
- `savage/card/field_group/fields_before` - add new fields to group before existing fields.
- `savage/card/field_group/fields_after` - add new fields to group after existing fields.

Custom card filters
- `savage/card/custom/content/tabs` - change tabs in custom card wysiwyg field.
- `savage/card/custom/content/toolbar` - change toolbar custom card wysiwyg field.

## Changelog
