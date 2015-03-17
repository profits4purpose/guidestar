<?php
namespace Profits4Purpose\GuideStar;

class Search extends Client
{
    protected $path = '/search';

    public function count($query)
    {
        $result = $this->search($query, 1, 1);
        return $result->total_hits;
    }

    public function lookupEin($ein)
    {
        $ein = $this->normalizeEin($ein);
        $hits = $this->search(['ein' => $ein])->hits;
        if (!$hits) {
            return null;
        }

        return $hits[0];
    }

    /**
     * Search for charities using GuideStar's standard Search API
     *
     * @param $query string|array Keywords to filter with. Can be simple string
     *                            or associative array of search parameters
     * @param null $resultsPerPage int Rows per page to return. Max = 25, Default = 10
     * @param null $pageNumber int Page number to return. Default = 1
     * @return object Search results
     */
    public function search($query, $resultsPerPage = null, $pageNumber = null)
    {
        $args = [
            'q' => $this->stringifyQuery($query)
        ];
        if ($resultsPerPage) {
            $args['p'] = $resultsPerPage;
        }
        if ($pageNumber) {
            $args['p'] = $pageNumber;
        }

        $url = $this->baseUrl . $this->path . '.json?' . http_build_query($args);

        return $this->getJson($url);
    }

    private function stringifyQuery($query)
    {
        if (!is_scalar($query) && !is_array($query)) {
            throw new \Exception('Query must be a string or an array');
        }

        $query = $this->normalizeQueryParameters($query);
        if (!$query) {
            throw new \Exception('Empty query');
        }

        $output = array_shift($query);
        if ($query) {
            $output .= ' AND (' . join(') AND (', $query) . ')';
        }

        return $output;
    }

    private function normalizeQueryParameters($query)
    {
        if (is_scalar($query)) {
            $query = ['keyword' => $query];
        }

        $keywords = '';
        $filters = [];
        foreach ($query as $property => $value) {
            if ($property == 'keyword' || is_numeric($property)) {
                $keywords .= ' ' . $value;
            } else {
                $filters[] = sprintf('%s:%s', $property, $value);
            }
        }

        $keywords = trim($keywords);
        if ($keywords) {
            array_unshift($filters, 'keyword:' . $keywords);
        }

        sort($filters);

        return $filters;
    }
}
