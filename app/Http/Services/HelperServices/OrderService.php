<?php

namespace App\Http\Services\HelperServices;

use Exception;

class OrderService
{
  protected mixed $model;

  public function __construct($model)
  {
    $this->model = $model;
  }

  /**
   * @throws Exception
   */
  public function updateOrder($ids): void
  {
    if ($ids != '' && is_string($ids)) {
      $ids = explode(',', $ids);
    }

    if ($this->model && count($ids) > 0) {
      foreach ($ids as $index => $id) {
        $this->model->where('id', $id)->update(['order' => $index + 1]);
      }
    } else {
      throw new Exception('Model or ids not found');
    }
  }
}
