<?php


use Illuminate\Support\Facades\Request;

class PaginatedResourceResponseOverrider
{
    protected function paginationLinks($paginated)
    {

        $queryString = (Request::getPathInfo() . (Request::getQueryString()) ? ('&' . Request::getQueryString()) : '');
        $queryStringNoPage = str_replace('&page=' . $paginated['current_page'], '', $queryString);
        return [
            'prev' => $paginated['prev_page_url'] ? ($paginated['prev_page_url'] . $queryStringNoPage) : null,
            'next' => $paginated['next_page_url'] ? ($paginated['next_page_url'] . $queryStringNoPage) : null,
            'self' => url()->full(),
        ];
    }
    protected function meta($paginated)
    {

        return [
            "currentPage" => $paginated['current_page'],
            "totalItems" => $paginated['total'],
            "itemsPerPage" => $paginated['per_page'],
            "totalPages" => $paginated['last_page']
        ];
    }
}


//Put this is PaginatedResourceResponse in Illuminate\Http\Resources\Json; replace the 2 methods with these and it should work
//Sorry thats the only way i found it working