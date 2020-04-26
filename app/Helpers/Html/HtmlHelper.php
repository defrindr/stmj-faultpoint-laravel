<?php
namespace App\Helpers\Html;
use App\Helpers\Html\Traits\SidebarTrait;
use App\Helpers\Html\Traits\ATrait;
use App\Helpers\Html\Traits\ButtonTrait;
use App\Helpers\Html\Traits\BaseTrait;
use App\Helpers\Html\Traits\ImgTrait;

class HtmlHelper {
	use SidebarTrait,
		ATrait,
		ButtonTrait,
		ImgTrait,
		BaseTrait;
}