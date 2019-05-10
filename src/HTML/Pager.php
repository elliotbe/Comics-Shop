<?php
declare(strict_types = 1);
namespace App\HTML;

class Pager {

  private $number_of_page;
  private $current_page;
  private $range = 3;

  public function __construct(int $number_of_page) {
    $this->number_of_page = $number_of_page;
    $this->current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($this->current_page < 1) {
      $this->current_page = 1;
    }
    if ($this->current_page > $number_of_page) {
      throw new \Error("There is nothing on page $this->current_page.", 1);

    }
  }

  public function generate() :?string {
    if ($this->number_of_page === 1) {
      return null;
    }

    ob_start();
    echo $this->getPageNumber(1);

    if ($this->current_page > ($this->range + 1)) {
      echo $this->getSeparator('…');
    }

    foreach (range(1, $this->number_of_page) as $page) {
      $delta = $page - $this->current_page;
      $is_in_delta = $delta < $this->range && $delta > -$this->range;
      $is_first_or_last = $page === 1 || $page === $this->number_of_page;
      if ($is_in_delta && !$is_first_or_last) {
        echo $this->getPageNumber($page);
      }
    };

    if ($this->current_page < ($this->number_of_page - $this->range)) {
      echo $this->getSeparator('…');
    }

    // last page
    echo $this->getPageNumber($this->number_of_page);

    $inner_html = ob_get_clean();
    return "<div class=\"pager__wrap\">$inner_html</div>";
  }

  private function getPageNumber(int $page_number) :string {
    $is_active = $this->current_page === $page_number;
    $active_class_name = $is_active ? 'active' : null;
    $url = $is_active ? '#' : "?page=$page_number";
    return "<a class=\"pager__page-number $active_class_name\" href=\"$url\">$page_number</a>";

  }

  private function getSeparator(string $symbol) :string {
    return "<span class=\"pager__separator\">$symbol</span>";
  }

}
