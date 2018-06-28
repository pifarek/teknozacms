<?php
    function children($items)
    {
        ?>
<ul class="navbar-nav mr-auto">
        <?php
        foreach($items as $item) {
            ?>
            <li{!! ($item->children && $item->children->count())? ' class="drop"' : '' !!}>
            <?php
            if($item->type === 'label') {
            ?>
                <a class="nav-link" href="#" {!! ($item->children && $item->children->count())? ' class="dropdown-toggle"' : '' !!}>{{ $item->name }}</a>
            <?php
            } elseif($item->type === 'url') {
            ?>
                <a class="nav-link" href="{{ $item->rewrited_url }}" class="">{{ $item->name }}</a>
            <?php
            } else {
            ?>
                <a class="nav-link" href="{{ url($item->rewrited_url) }}" class="{{ $item->current? ' active' : '' }}{!! ($item->children && $item->children->count())? ' dropdown-toggle' : '' !!}">{{ $item->name }}</a>
            <?php
            }

			if($item->children && $item->children->count()) {
			?>
                <ul class="dropdown">
                    <?php
					foreach($item->children as $children) {
					?>
					<li>
					<?php
						if($children->type === 'label') {
					?>
                        <a href="#">{{ $children->name }}</span>
					<?php
                        } elseif($children->type === 'url') {
					?>
                        <a href="{{ $children->rewrited_url }}">{{ $item->name }}</a>
					<?php
                        } elseif($children->type === 'hash') {
					?>
					    <a href="{{ url('/') }}/#{{ $children->hash }}">{{ $children->name }}</a>
					<?php
                        } else {
					?>
                        <a href="{{ url($children->rewrited_url) }}" class="{{ $children->current? ' active' : '' }}">{{ $children->name }}</a>
					<?php
                        }
					?>
					</li>
					<?php
					}
					?>
                </ul>
			<?php
			}
			?>
			
            </li>
            <?php
        }
        ?>
</ul>
        <?php
    }
?>



    @if($items)
        {!! children($items) !!}
    @endif

