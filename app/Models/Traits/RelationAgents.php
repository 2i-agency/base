<?php
namespace Chunker\Base\Models\Traits;

use Chunker\Base\Models\Agent;

trait RelationAgents
{
	public function agents() {
		return $this->morphToMany(Agent::class, 'model', 'base_agents_models');
	}
}