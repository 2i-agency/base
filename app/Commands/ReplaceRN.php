<?php

namespace Chunker\Base\Commands;

use Illuminate\Console\Command;

class ReplaceRN extends Command
{
	protected $description = 'Replacing \r\n in file on line break';
	protected $signature = 'chunker:replace-rn {input} {output}';


	public function handle(){
		$input_filename = $this->argument('input');
		$output_filename = $this->argument('output');

		$content = file_get_contents($input_filename);
		$count = 0;
		$content = str_replace('\\\\r\\\\n', PHP_EOL, $content, $count);
		$content = str_replace('\\\\n', PHP_EOL, $content, $count);

		$this->line(mb_strlen($content));
		$this->line('Replaced ' . $count);

		return file_put_contents($output_filename, $content);
	}
}