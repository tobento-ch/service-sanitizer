<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Sanitizer;

use Tobento\Service\Sanitizer\Filter\FilterIf;
use Tobento\Service\Collection\Collection;

/**
 * The Sanitizer. To sanitize values.
 */
class Sanitizer implements SanitizerInterface
{
    /**
     * @var array The filters.
     */    
    protected array $filters = [];

    /**
     * @var null|Collection The data to sanitize
     */    
    protected ?Collection $data = null;    

    /**
     * Create a new Sanitizer.
     *
     * @param null|FiltersInterface $filters
     * @param null|FiltersParserInterface $filtersParser
     */
    public function __construct(
        null|FiltersInterface $filters = null,
        protected null|FiltersParserInterface $filtersParser = null,
    ) {
        $filters = $filters ?: new DefaultFilters();
        
        $filters->addFilters($this);
                
        $this->filtersParser = $filtersParser ?: new FiltersParser();
    }

    /**
     * Add a filter.
     * 
     * @param string $key The filter key such as 'stripTags'.
     * @param callable|FilterInterface $filter The filter.
     * @return static $this
     */
    public function addFilter(string $key, callable|FilterInterface $filter): static
    {
        $this->filters[$key] = $filter;
        
        return $this;
    }

    /**
     * Sanitizes a value with the given filters.
     * 
     * @param mixed $value The value
     * @param string|array $filters The filters 'stripTags|ucwords' or ['date' => ['Y-m-d', 'Y.m.d H:i']]
     *
     * @throws FilterException If filter cannot handle sanitation
     * @throws FilterNotFoundException
     *
     * @return mixed The sanitized value
     */
    public function sanitizing(mixed $value, string|array $filters): mixed
    {
        // parse filters
        $parsedFilters = $this->filtersParser->parse($filters);
        
        $original = $value;
        $sanitize = true;
        
        // call each filter
        foreach($parsedFilters as $filter)
        {
            if (! $filter instanceof ParsedFilter)
            {
                continue;
            }
            
            if ($this->getFilter($filter->key()) instanceof FilterIf)
            {
                $data = $this->data ?: new Collection();
                
                $sanitize = $this->filterSanitize($filter, [$value, $data]);
            }
            else
            {
                $value = $this->filterSanitize($filter, $value);
            }
        }
        
        return $sanitize ? $value : $original;
    }
    
    /**
     * Sanitizes the data given.
     * 
     * @param mixed $data The data.
     * @param array $sanitation The filters index by the data key ['title' => 'stripTags|ucwords']
     * @param bool $strictSanitation If true, sanitizes missing data too, otherwise not.
     * @param bool $returnSanitizedOnly If true, returns only the sanitized data, otherwise all.
     *
     * @throws FilterException If filter cannot handle sanitation
     * @throws FilterNotFoundException
     *
     * @return array The data sanitized
     */
    public function sanitize(
        mixed $data,
        array $sanitation,
        bool $strictSanitation = false,
        bool $returnSanitizedOnly = false,
    ): array {
        
        if (!is_array($data))
        {
            return [];
        }
        
        if ($strictSanitation) {
            return $this->sanitizeStrict($data, $sanitation, $returnSanitizedOnly);
        }
        
        // use Collection for notation support.
        $this->data = new Collection($data);
        
        $sanitizedKeys = [];
        
        foreach($sanitation as $key => $filters)
        {
            if ($this->data->has($key))
            {
                $sanitized = $this->sanitizing($this->data->get($key), $filters);

                // delete first as 'foo.bar' => 'value' turns to 'foo' => ['bar' => 'value']
                // otherwise, we have two values one sanitized and one not.
                $this->data->delete($key);

                $this->data->set($key, $sanitized);
                
                $sanitizedKeys[] = $key;
            }
        }
        
        return $returnSanitizedOnly
                   ? $this->data->only($sanitizedKeys)->all()
                   : $this->data->all();
    }

    /**
     * Strictly sanitizes the data given.
     * 
     * @param mixed $data The data.
     * @param array $sanitation The filters index by the data key ['title' => 'stripTags|ucwords']
     * @param bool $returnSanitizedOnly If true, returns only the sanitized data, otherwise all.
     *
     * @throws FilterException If filter cannot handle sanitation
     * @throws FilterNotFoundException
     *
     * @return array The data sanitized
     */    
    protected function sanitizeStrict(
        mixed $data,
        array $sanitation,
        bool $returnSanitizedOnly = false,
    ): array {
        // use Collection for notation support.
        $this->data = new Collection($data);
        
        foreach($sanitation as $key => $filters)
        {
            $sanitized = $this->sanitizing($this->data->get($key), $filters);

            // delete first as 'foo.bar' => 'value' turns to 'foo' => ['bar' => 'value']
            // otherwise, we have two values one sanitized and one not.
            $this->data->delete($key);

            $this->data->set($key, $sanitized);
        }

        return $returnSanitizedOnly
                   ? $this->data->only(array_keys($sanitation))->all()
                   : $this->data->all();
    }    
    
    /**
     * Calls the filter.
     * 
     * @param ParsedFilter $parsedFilter
     * @param mixed The value $value
     * @return mixed The value
     */
    protected function filterSanitize(ParsedFilter $parsedFilter, mixed $value): mixed
    {

        if (is_null($filter = $this->getFilter($parsedFilter->key())))
        {
            throw new FilterNotFoundException(
                $parsedFilter->key(),
                'Filter "'.$parsedFilter->key().'" does not exist. You need to add the filter first.'
            );
        }
        
        if ($filter instanceof FilterInterface)
        {
            $filter = [$filter, 'apply'];
        }
        
        return call_user_func_array($filter, [$value, $parsedFilter->parameters()]);
    }

    /**
     * Get the filter by key.
     * 
     * @param string $filter The filter key
     * @return null|callable|FilterInterface Null if filter does not exist.
     */
    protected function getFilter(string $filter): null|callable|FilterInterface
    {
        return $this->filters[$filter] ?? null;
    }    
}