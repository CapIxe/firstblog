<?php

namespace IXE83\BlogBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class IXE83BlogBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
