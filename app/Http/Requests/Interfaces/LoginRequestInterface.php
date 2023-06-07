<?php

namespace App\Http\Requests\Interfaces;


interface LoginRequestInterface
{
 public function getKey();
 public function ensureIsNotRateLimited();
 public function hit($key, $block_duration);
 public function authenticate();
 public function storeBlockedKey();   
}