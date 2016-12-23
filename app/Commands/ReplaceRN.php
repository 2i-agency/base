<?php

namespace Chunker\Base\Commands;

use Illuminate\Console\Command;

/**
 * Class ReplaceRN. Команда для замены \r\n и \n на перенос строки
 *
 * @package Chunker\Base\Commands
 */
class ReplaceRN extends Command
{
	protected $signature = 'chunker:replace-rn {input} {output}';
	protected $description = 'Replacing string \r\n and \n in file on line break';


	public function handle(){
		$input_filename = $this->argument('input');
		$output_filename = $this->argument('output');

		$content = file_get_contents($input_filename);
		$count_rn = $count_n = 0;
		$content = str_replace('\\\\r\\\\n', PHP_EOL, $content, $count_rn);
		$content = str_replace('\\\\n', PHP_EOL, $content, $count_n);

		$this->line(mb_strlen($content));
		$this->line('Replaced ' . ( $count_rn + $count_n ));

		file_put_contents($output_filename, $content);
	}
}