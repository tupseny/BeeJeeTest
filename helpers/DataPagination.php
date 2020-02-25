<?php


class DataPagination
{
    const DEFAULT_DATA_PER_PAGE = 3;

    private  $splitted_data;
    private  $full_data;
    private  $page_count;

    function __construct($data, int $per_page = self::DEFAULT_DATA_PER_PAGE)
    {
        if ($per_page <= 0) {
            throw new Exception('per_page should be more than 0', MyExceptions::INTERNAL_ERROR);
        }

        $this->full_data = $data;
        if (count($data)) {
            $this->page_count = (int)ceil(count($this->full_data) / $per_page);
            $this->splitted_data = $this->split($per_page);
        } else {
            $this->page_count = 1;
            $this->splitted_data = [1 => []];
        }
    }

    /**
     * @return mixed
     */
    public function getPageCount()
    {
        return $this->page_count;
    }

    /**
     * @return array
     */
    public function getSplittedData(): array
    {
        return $this->splitted_data;
    }


    private function split($items_per_page)
    {
        $n = count($this->full_data);
        $items_per_last_page = $n % $items_per_page;
        $items_per_last_page = $items_per_last_page ? $items_per_last_page : $items_per_page;

        /*
        * Data divided into pages
        * ex: [ 1 => [item1, item2, item3], ..., 3 => [item1, item2] ]
        */
        $paginated_data = [];

        for ($page = 1; $page <= $this->page_count; $page++) {
//            store items for current page
            $page_array = [];

//            this page item count
            $per_this_page = $page === $this->page_count ? $items_per_last_page : $items_per_page;

            $start_index = $items_per_page * ($page - 1);
            $last_index = $start_index + $per_this_page - 1;

            for ($i = $start_index; $i <= $last_index; $i++) {
                array_push($page_array, $this->full_data[$i]);
            }

            /*
             * Append array with items for current page.
             * KEYS are page numbers
             * */
            $paginated_data[$page] = $page_array;
        }

        return $paginated_data;
    }
}