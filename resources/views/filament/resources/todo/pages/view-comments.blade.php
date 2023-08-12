@foreach($comments as $comment)
	<div class="">
		<p>{{ $comment->comment }}</p>
		<div class="mt-2">
		    <small class="mr-3">
		    	<span class="inline-flex items-center">
		    		<x-heroicon-o-user class="h-4 w-4 mr-2" />
		    		{{ $comment->user->name }}
		    	</span>
		    </small>
		    <small>
		    	<span class="inline-flex items-center" title="Comment posted at">
		    		<x-heroicon-o-clock class="h-4 w-4 mr-2" />
		    		{{ date('dS F, Y h:i A', strtotime($comment->created_at)) }}
		    	</span>
		    </small>
		</div>
	</div>
	<hr class="mt-2 mb-6 border-gray-600" />
@endforeach
