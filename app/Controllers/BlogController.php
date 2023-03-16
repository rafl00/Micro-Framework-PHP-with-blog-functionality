<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Repositories\Contracts\BlogRepositoryInterface;
use App\Request;
use App\Services\DataTableService;
use App\View;

readonly class BlogController
{
    public function __construct(
        private BlogRepositoryInterface $blogRepository,
        private DataTableService $dataTableService,
    ) {
    }

    public function index(): View
    {
        return View::make('blog/index');
    }

    public function load(Request $request): void
    {
        $params = $this->dataTableService->getQueryParameters($request);

        $blogs = $this->blogRepository->getPaginated($params);

        $totalBlogs = $this->blogRepository->count();

        echo json_encode([
            'data' => $blogs,
            'draw' => $params->draw,
            'recordsTotal' => $totalBlogs,
            'recordsFiltered' => $totalBlogs,
        ]);
    }

    public function create(): View
    {
        return View::make('blog/create');
    }

    public function store(Request $request): View
    {
        if ($this->blogRepository->create(
            $request->postParam('text')
        )) {
            return View::make('blog/index');
        }

        return View::make('blog/index');
    }

    public function destroy(Request $request): View
    {
        if ($this->blogRepository->delete(
            (int)$request->postParam('id')
        )) {
            return View::make('blog/index');
        }

        return View::make('blog/index');
    }
}