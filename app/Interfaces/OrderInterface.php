<?php

namespace App\Interfaces;

interface OrderInterface
{
    public function create($request);
    public function index($filters);
    public function show($order);
    public function update($order, $request);
    public function cancel($order);
}
