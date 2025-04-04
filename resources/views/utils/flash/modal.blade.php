{{--Модальное окно--}}
<div id="flash-overlay-modal" class="modal fade {{ $modalClass or '' }}">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<span class="fa fa-times"></span>
				</button>
				<h4 class="modal-title">{{ $title }}</h4>
			</div>

			<div class="modal-body">
				<p>{!! $body !!}</p>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		</div>
	</div>
</div>
