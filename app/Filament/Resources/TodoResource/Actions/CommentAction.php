<?php

namespace App\Filament\Resources\TodoResource\Actions;

use Closure;
use Filament\Forms;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class CommentAction extends Action
{
	protected string | Closure | null $icon = 'heroicon-o-chat';

	protected string | Htmlable | Closure | null $label = 'Comment';

	protected ?string $notificationTitle = 'Saved';

	public static function getDefaultName(): ?string
	{
	    return 'comment';
	}

	public function setForm(): array
	{
	    return [
	    	Forms\Components\MarkdownEditor::make('comment')
	    		->placeholder('Write your comment...')
	    	    ->required(),

	    	Forms\Components\Placeholder::make('latest_comments')
	    		->visible(fn (Model $record): bool => $record->comments()->count())
	    		->content(function (Model $record) {
	    			$data['comments'] = $record->comments()->latest()->get();
	    			return new HtmlString(view('filament.resources.todo.pages.view-comments', $data)->render());
	    		}),
	    ];
	}

	protected static function setAction(): \Closure
	{
		return function (Model $record, array $data): void {
			$data['added_by'] = auth()->id();
			$record->comments()->create($data);
		};
	}

	protected function setUp(): void
	{
	    parent::setUp();

	    $this->modalHeading(fn (Model $record) => "{$record->title} Comments");

		$this->form(static::setForm());

		$this->slideOver();

		$this->modalButton('Post');

		$this->action(static::setAction());

        $this->successNotificationTitle($this->notificationTitle);
	}
}
