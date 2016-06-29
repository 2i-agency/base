<?php

namespace Chunker\Base\Models\Traits;

use Chunker\Base\Models\Traits\Scopes\ScopeByPublicationTime;
use Chunker\Base\Models\Traits\Scopes\ScopeIsNotPublished;
use Chunker\Base\Models\Traits\Scopes\ScopeIsPublished;

trait Publicable
{
	use ScopeByPublicationTime, ScopeIsPublished, ScopeIsNotPublished;
}