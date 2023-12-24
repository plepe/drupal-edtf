# drupal-edtf
This module adds a date field with support for the [Extended Date/Time Format specification](https://www.loc.gov/standards/datetime/) (EDTF). This allows varying precision, uncertain and approximate (date or) timestamps. Internally the timestamp will be saved as string. The [ProfessionalWiki/EDTF](https://github.com/ProfessionalWiki/EDTF) library is used for validating and parsing.

When displaying timestamps, two formatters are available:
* Plain: the timestamp will be shown as is
* EDTF Humanizer: The humanizer of [this library](https://github.com/ProfessionalWiki/EDTF) is used.

This module adds field tokens:
* `[node:field_name:year]` - show only the specified year
* `[node:field_name:humanized]` - the timestamp in humanized form

This module adds a few Twig filters for processing EDTF values:
* `{{ value|edtf_validate }}` - check whether the value is valid (returns boolean).
* `{{ value|edtf_humanize }}` - humanize the value in the current language (returns string or null if the value was not valid).
* `{{ value|edtf_year }}` - returns the (minimum) year (returns int or null if the value was not valid).
* `{{ value|edtf_min }}` - returns the earliest UNIX timestamp (returns int or null if the value was not valid).
* `{{ value|edtf_max }}` - returns the latest UNIX timestamp (returns int or null if the value was not valid).
