<?php

/**
 * Reference middleware stack implementation.
 */
class Stack
{
    /**
     * @var FilterInterface[]
     */
    private $filters = array();
    
    /**
     * @param FilterInterface $filter
     *
     * @return void
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
    }
    
    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface|null
     */
    public function dispatch(ServerRequestInterface $request)
    {
        $response = null;
        
        for ($i=0; $i<count($this->filters); $i++) {
            $filter = $this->filters[$i];

            $result = $filter->applyFilter($request, $response);

            if ($result === false) {
                break; // abort after last filter
            }
        }

        return $response;
    }
}

// EXAMPLE:

$test = new Stack();

$test->addFilter(new FooFilter);
$test->addFilter(new BarFilter);

$response = $test->dispatch();
