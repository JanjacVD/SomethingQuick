<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Support\Facades\Request;

class PaginatedResourceResponseOverrider extends JsonResource
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
        $metaData = parent::meta($paginated);
        return [
            "currentPage" => $metaData['current_page'],
            "totalItems" => $metaData['total'],
            "itemsPerPage" => $metaData['per_page'],
            "totalPages" => $metaData['last_page']
        ];
    }
}
