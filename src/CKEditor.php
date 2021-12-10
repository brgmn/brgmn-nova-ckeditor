<?php

namespace Brgmn\NovaCKEditor;

use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Brgmn\NovaCKEditor\Handlers\DiscardPendingAttachments;
use Brgmn\NovaCKEditor\Handlers\StorePendingAttachment;
use Brgmn\NovaCKEditor\Models\DeleteAttachments;
use Brgmn\NovaCKEditor\Models\DetachAttachment;

class CKEditor extends Trix
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'ckeditor';

    public function __construct(string $name, $attribute = null, ?callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
        $this->withMeta([
            'options' => config('ckeditor.options', [])
        ]);
    }
    /**
     * Set configuration options for the CKEditor editor instance.
     *
     * @param  array $options
     * @return $this
     */
    public function options($options)
    {
        $currentOptions = $this->meta['options'] ?? [];

        return $this->withMeta([
            'options' => array_merge($currentOptions, $options),
        ]);
    }
    /**
     * @param string|null $disk
     * @return $this
     */
    public function withFiles($disk = null, $path = '/')
    {
        $this->withFiles = true;

        $this->disk($disk);

        $this->attach(new StorePendingAttachment($this))
            ->detach(new DetachAttachment($this))
            ->delete(new DeleteAttachments($this))
            ->discard(new DiscardPendingAttachments())
            ->prunable();

        return $this;
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  NovaRequest $request
     * @param  string $requestAttribute
     * @param  object $model
     * @param  string $attribute
     * @return \Closure|null
     */
    protected function fillAttribute(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        parent::fillAttribute($request, $requestAttribute, $model, $attribute);

        if ($request->{$this->attribute.'DraftId'} && $this->withFiles) {
            return function () use ($request, $model, $attribute) {
                config('ckeditor.pending_attachment_model')::persistDraft(
                    $request->{$this->attribute.'DraftId'},
                    $this,
                    $model
                );
            };
        }
    }
}
