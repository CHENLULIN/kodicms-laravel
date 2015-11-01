<ul class="navigation">
	@foreach($navigation->getPages() as $item)
		<li @if($item->isActive())class="active"@endif>
			<a href="{{ $item->getUrl() }}">
				{!! $item->getIcon() !!}
				<span class="mm-text">{!! $item->getName() !!}</span>
			</a>
		</li>
	@endforeach

	@foreach($navigation->getSections() as $section)
		@if(count($section) > 0 or count($section->getSections()) > 0)
			<li class="mm-dropdown @if($section->isActive()) open @endif">
				<a href="#">
					{!! $section->getIcon() !!}
					<span class="mm-text">{!! $section->getName() !!}</span>
				</a>
				<ul>
					@foreach($section as $item)
						<?php if($item->isHidden()) continue; ?>
						<li @if ($item->isActive())class="active"@endif>
							<a href="{{ $item->getUrl() }}">
								{!! $item->getIcon() !!}
								<span class="mm-text">{!! $item->getName() !!}</span>
							</a>
						</li>
					@endforeach

					@foreach($section->getSections() as $sub_section )
						@if(!(count($sub_section) > 0)) <?php continue; ?>@endif
						<li class="mm-dropdown @if($section->isActive()) open @endif">
							<a href="#">
								{!! $sub_section->getIcon() !!}
								<span class="mm-text">{!! $sub_section->getName() !!}</span>
							</a>

							<ul>
								@foreach($sub_section as $sub_item)
									<?php if($sub_item->isHidden()) continue; ?>
									<li @if ($sub_item->isActive())class="active"@endif>
										<a href="{{ $sub_item->getUrl() }}">
											{!! $sub_item->getIcon() !!}
											<span class="mm-text">{!! $sub_item->getName() !!}</span>
										</a>
									</li>
								@endforeach
							</ul>
						</li>
					@endforeach
				</ul>
			</li>
		@endif
	@endforeach
</ul>