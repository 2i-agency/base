<?php

namespace Chunker\Base\Commands\Traits;


use Symfony\Component\Console\Helper\ProgressBar as BaseProgressbar;

trait Progressbar
{
	protected function initProgressbar(int $max, int $typeMessage = 0, int $width = 25):BaseProgressbar {
		$bar = $this->output->createProgressBar($max);

		if ($typeMessage == 1) {
			$format = '[01;38;05;226m%message%[0m' . "\n";
		} elseif ($typeMessage == 2) {
			$format = '[01;38;05;226m%message%[0m' . "\t" . '[01;38;05;226m%hint%[0m' . "\n";
		} else {
			$format = '';
		}

		$format .= '[01;38;05;147m%current%/%max%[0m [%bar%] [01;38;05;147m%percent:3s%%[0m' . "\n" .
			'[01;38;05;244mПрошло: %elapsed%' . "\t" . 'Осталось: ~%remaining%' . "\t" . 'Расчётное время: ~%estimated%[0m';

		$bar->setFormat($format);
		$bar->setBarCharacter('[01;38;05;120m●[0m');
		$bar->setEmptyBarCharacter('[01;38;05;244m●[0m');
		$bar->setProgressCharacter('[01;38;05;226m●[0m');
		$bar->setBarWidth($width);

		return $bar;
	}


	protected function finishBar(BaseProgressbar &$bar) {
		$bar->setMessage('Выполнено');
		$bar->setMessage('', 'hint');
		$bar->finish();
		$this->line('');
	}
}