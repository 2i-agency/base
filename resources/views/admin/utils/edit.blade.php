@php

	// Информация о созданиии
	$create = "
	<span class='fa fa-plus-circle fa-fw'></span>
	<b>Создание</b>
	<br>" . $element->created_at;

	if ($element->creator)
	{
		$create .= "<br>" . $element->creator->getName();
	}


	// Информация об обновлении
	if ($element->created_at->ne($element->updated_at))
	{
		$update = "
		<span class='fa fa-pencil fa-fw'></span>
		<b>Редактирование</b>
		<br>" . $element->updated_at;

		if ($element->updater)
		{
			$update .= "<br>" . $element->updater->getName();
		}
	}

	$popover_content = '<p>' . $create . '</p><p>' . $update . '</p>';

@endphp


<span
	class="fa fa-info-circle fa-fw{!! isset($right) && $right ? ' pull-right' : NULL !!}"
	data-toggle="popover"
	data-content="{!! $popover_content !!}"
	data-placement="left"></span>
