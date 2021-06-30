# Sanitizer Service

The Sanitizer Service provides an easy way to sanitize user input.

## Table of Contents

- [Getting started](#getting-started)
    - [Requirements](#requirements)
    - [Highlights](#highlights)
    - [Simple Example](#simple-example)
- [Documentation](#documentation)
    - [Sanitizing](#sanitizing)
        - [Single value](#single-value)
        - [Multiple values](#multiple-values)
        - [Nested values](#nested-values)
        - [Using array for filters](#using-array-for-filters)
        - [Strict sanitation](#strict-sanitation)
        - [Sanitized data only](#sanitized-data-only)
    - [Filtering](#filtering)
        - [Default filters](#default-filters)
        - [Custom Default Filters](#custom-default-filters)
        - [Adding filters](#adding-filters)
        - [A note on FilterIf](#a-note-on-filterif)
        - [Parsing filters](#parsing-filters)
- [Credits](#credits)
___

# Getting started

Add the latest version of the sanitizer service running this command.

```
composer require tobento/service-sanitizer
```

## Requirements

- PHP 8.0 or greater

## Highlights

- Framework-agnostic, will work with any project
- Decoupled design
- Extendable
- Nested value support
- Customize filters parsing

## Simple Example

Here is a simple example of how to use the Sanitizer Service.

```php
use Tobento\Service\Sanitizer\Sanitizer;

$sanitizer = new Sanitizer();

// sanitize a single value.
$sanitized = $sanitizer->sanitizing('<p>lorem ipsum</p>', 'cast:string|stripTags|ucwords');

// sanitize multiple values.
$sanitized = $sanitizer->sanitize(
    [
        'name' => 'Thomas',
        'birthday' => '1982-10-30',
        'description' => 'Lorem ipsum',
    ],
    [
        'name' => 'cast:string',
        'birthday' => 'date:Y-m-d:d.m.Y',
        'description' => 'cast:string|stripTags',
    ]
);
```

# Documentation

## Sanitizing

### Single value

Easily sanitize a single value.

```php
use Tobento\Service\Sanitizer\Sanitizer;

$sanitizer = new Sanitizer();

$sanitized = $sanitizer->sanitizing('<p>lorem ipsum</p>', 'stripTags|ucwords');

var_dump($sanitized); // string(11) "Lorem Ipsum"
```

### Multiple values

Sanitize multiple values.

```php
use Tobento\Service\Sanitizer\Sanitizer;

$sanitizer = new Sanitizer();

$sanitized = $sanitizer->sanitize(
    [
        'name' => 'Thomas',
        'birthday' => '1982-10-30',
        'description' => 'Lorem ipsum',
    ],
    [
        'name' => 'cast:string',
        'birthday' => 'date:Y-m-d:d.m.Y',
        'description' => 'cast:string|stripTags',
    ]
);

/*Array
(
    [name] => Thomas
    [birthday] => 30.10.1982
    [description] => Lorem ipsum
)*/
```

### Nested values

If the incoming values contains "nested" data, you may specify these attributes in your filters using "dot" syntax:

```php
use Tobento\Service\Sanitizer\Sanitizer;

$sanitizer = new Sanitizer();

$sanitized = $sanitizer->sanitize(
    [
        'title' => 'Title',
        'author' => [
            'name' => 'Tom',
            'description' => 'Lorem ipsum',
        ],
    ],
    [
        'name' => 'cast:string',
        'author.name' => 'cast:string',
        'author.description' => 'cast:string|stripTags',
    ]
);
```

### Using array for filters

Depending on the [FiltersParsers implementation](#parsing-filters) you may need to set the filters by an array as a parameter might need the parsing notation such as ":".

```php
use Tobento\Service\Sanitizer\Sanitizer;

$sanitizer = new Sanitizer();

$sanitized = $sanitizer->sanitizing(
    '1982-10-30T19:30',
    [
        'date' => ['Y-m-d', 'Y.m.d H:i']
    ]
);

var_dump($sanitized); // string(11) "30.10.1982 19:30"
```

### Strict sanitation

If strict sanitation is used, filters will be applied even if the data does not exist.

```php
use Tobento\Service\Sanitizer\Sanitizer;

$sanitizer = new Sanitizer();

$sanitized = $sanitizer->sanitize(
    [
        'name' => 'Thomas',
    ],
    [
        'age' => 'cast:int:21',
    ],
    strictSanitation: true,
);

/*Array
(
    [name] => Thomas
    [age] => 21
)*/
```

### Sanitized data only

Sometimes it might be useful to get only the sanitized data:

```php
use Tobento\Service\Sanitizer\Sanitizer;

$sanitizer = new Sanitizer();

$sanitized = $sanitizer->sanitize(
    [
        'name' => 'Thomas',
    ],
    [
        'age' => 'cast:int:21',
    ],
    strictSanitation: true,
    returnSanitizedOnly: true,
);

/*Array
(
    [age] => 21
)*/

$sanitized = $sanitizer->sanitize(
    [
        'name' => 'Thomas',
    ],
    [
        'age' => 'cast:int:21',
    ],
    strictSanitation: false,
    returnSanitizedOnly: true,
);

/*Array()*/
```

## Filtering

### Default filters

The following filters are available out of the box:

| Filter | Parameters | Description |
| --- | --- | --- |
| **cast:int:12** | int, float, string, bool, array | Casts a value into the given type. You might define a default value as the second parameter. This works only on [strict sanitation](#strict-sanitation) though. |
| **date:Y-m-d:d.m.Y** | Any DateTime formats | Formats the date from given to the target format. |
| **remove:foo:bar** | As many as you want | Removes the parameters set from an array. |
| **trim** | | Trims a string. |
| **digit** | | Get only digit characters. |
| **alphaStrict** | | Get only alpha characters [a-zA-Z]. |
| **stripTags** | | Strips any tags. |
| **ucwords** | | Uppercase the first character of each word in a string. |
| **lcfirst** | | Make a string's first character uppercase. |
| **lowercase** | | Make a string lowercase. |
| **uppercase** | | Make a string uppercase. |
| **array** | ['cast:string', 'cast:int'] | Filters each array data. You must use [array syntax for filters](#using-array-for-filters). The second parameter is optional and would be the filters for the array keys. |
| **filterIf:attribute:value** | | Applies filters if an attribute exactly matches the value. |

> :warning: **Some filters like stripTags return the original value if the type is not a string. So you might add the cast:string filter in addition.**

### Custom Default Filters

If you want to set your own default filters you can do it by the following way:

```php
use Tobento\Service\Sanitizer\Sanitizer;
use Tobento\Service\Sanitizer\SanitizerInterface;
use Tobento\Service\Sanitizer\FiltersInterface;

class CustomDefaultFilters implements FiltersInterface
{
    /**
     * Add the filters to the sanitizer.
     *
     * @param SanitizerInterface $sanitizer
     * @return void
     */
    public function addFilters(SanitizerInterface $sanitizer): void
    {
        $sanitizer->addFilter('cast', new \Tobento\Service\Sanitizer\Filter\Cast());        
    }    
}

$sanitizer = new Sanitizer(new CustomDefaultFilters());
```

### Adding filters

You can add your own filters by the following way. If the same filter key already exists it will overwrite the filter.

```php
use Tobento\Service\Sanitizer\Sanitizer;
use Tobento\Service\Sanitizer\FilterInterface;

$sanitizer = new Sanitizer();

// By a callable.
$sanitizer->addFilter('trim', function(mixed $value, array $parameters): mixed
{
    return is_string($value) ? trim($value) : $value;
});

// By a class implementing the FilterInterface.
class TrimFilter implements FilterInterface
{    
    /**
     * Apply the filter.
     * 
     * @param mixed $value The value to sanitize
     * @param array $parameters The parameters set on the sanitation 'filter:foo:bar'
     *
     * @throws FilterException If filter cannot handle sanitation
     *
     * @return mixed The sanitized value
     */
    public function apply(mixed $value, array $parameters = []): mixed
    {
        return is_string($value) ? trim($value) : $value;
    }
}

$sanitizer->addFilter('trim', new TrimFilter());
```

### A note on FilterIf

The "filterIf" filter applies filters only if a value matches the given condition.

```php
use Tobento\Service\Sanitizer\Sanitizer;

$sanitizer = new Sanitizer();

$sanitized = $sanitizer->sanitize(
    [
        'country' => 'CH',
        'phone' => '+41 76 123 45 67',
    ],
    [
        // filter phone only if country value is "CH"
        'phone' => 'filterIf:country:CH|digit',
    ],
    returnSanitizedOnly: true,
);

var_dump($sanitized);
// array(1) { ["phone"]=> string(11) "41761234567" }
```

You can easily add more FilterIf conditions by extending FilterIf class:

```php
use Tobento\Service\Sanitizer\Sanitizer;
use Tobento\Service\Sanitizer\Filter\FilterIf;
use Tobento\Service\Collection\Collection;

// Filter only if the attributes defined are present.
class FilterIfPresent extends FilterIf
{    
    /**
     * Apply the filter.
     * 
     * @param mixed $value The value to sanitize
     * @param array $parameters The parameters set on the sanitation 'filter:foo:bar'
     *
     * @throws FilterException If filter cannot handle sanitation
     *
     * @return mixed The sanitized value
     */
    public function apply(mixed $value, array $parameters = []): mixed
    {
        // extract value and data.
        [$value, $data] = $value;
        
        if (! $data instanceof Collection)
        {
            return false;
        }
        
        return $data->has($parameters);
    }
}

$sanitizer = new Sanitizer();
$sanitizer->addFilter('filterIfPresent', new FilterIfPresent());

$sanitized = $sanitizer->sanitize(
    [
        'country' => 'CH',
        'locale' => 'de-CH',
        'phone' => '+41 76 123 45 67',
    ],
    [
        // filter phone only if country and locale is present.
        'phone' => 'filterIfPresent:country:locale|digit',
    ]
);

/*Array
(
    [country] => CH
    [locale] => de-CH
    [phone] => 41761234567
)*/
```

### Parsing filters

You may change the behaviour of parsing the filters for sanitizing.

```php
use Tobento\Service\Sanitizer\Sanitizer;
use Tobento\Service\Sanitizer\FiltersParserInterface;
use Tobento\Service\Sanitizer\ParsedFilter;

class CustomParser implements FiltersParserInterface
{    
    /**
     * Parses the filters.
     * 
     * @param string|array
     * @return array The parsed filters [ParsedFilter, ...]
     */
    public function parse(string|array $filters): array
    {
        // do your parsing strategy
        $parsedFilters = [];
        
        return $parsedFilters;
    }
}

$sanitizer = new Sanitizer(filtersParser: new CustomParser());
```

# Credits

- [Tobias Strub](https://www.tobento.ch)
- [All Contributors](../../contributors)