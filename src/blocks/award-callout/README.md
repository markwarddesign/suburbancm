# suburbancm/award-callout Gutenberg block

A highlighted callout for an award or recognition. Shipped with defaults for
the BoiseDev Peak 43 2026 #1 ranking, but every field is editable so it can be
reused for future awards.

## Fields

| Attribute       | Purpose                                                        |
| --------------- | -------------------------------------------------------------- |
| `image`         | Award badge / logo (upload the "Peak 43 2026 Winner" logo).    |
| `imageAlt`      | Alt text for the badge.                                        |
| `eyebrow`       | Small label above the headline (e.g. "BoiseDev Peak 43 · 2026"). |
| `title`         | Headline.                                                      |
| `description`   | Supporting paragraph.                                          |
| `buttonText`    | Primary button label.                                          |
| `buttonUrl`     | Primary button link (defaults to the Peak 43 list).            |
| `secondaryText` | Optional secondary text link label.                            |
| `secondaryUrl`  | Optional secondary link (e.g. the BoiseDev YouTube video).     |

Leave `secondaryUrl` empty to hide the secondary link. If no image is set, a
gold trophy icon is shown instead.
