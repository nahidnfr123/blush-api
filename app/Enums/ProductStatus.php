<?php

namespace App\Enums;

enum ProductStatus: int {
  case Inactive = 0;
  case Active = 1;
  case OutOfStock = 2;
}
