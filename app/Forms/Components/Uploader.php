<?php

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Filament\Support\Concerns\HasExtraAlpineAttributes;
use Filament\Tables\Filters\Concerns\HasPlaceholder;

class Uploader extends Field // BaseFileUpload
{
    // use Concerns\HasExtraInputAttributes;
    use HasPlaceholder;
    use HasExtraAlpineAttributes;
    use HasExtraInputAttributes;

    protected string $view = 'forms.components.uploader';

    protected string | Closure | null $imageCropAspectRatio = null;

    protected string | Closure | null $imagePreviewHeight = null;

    protected string | Closure | null $imageResizeTargetHeight = null;

    protected string | Closure | null $imageResizeTargetWidth = null;

    protected string | Closure | null $imageResizeMode = null;

    protected string | Closure $loadingIndicatorPosition = 'right';

    protected string | Closure | null $panelAspectRatio = null;

    protected string | Closure | null $panelLayout = 'compact';

    protected string | Closure $removeUploadedFileButtonPosition = 'left';

    protected bool | Closure $shouldAppendFiles = false;

    protected string | Closure $uploadButtonPosition = 'right';

    protected string | Closure $uploadProgressIndicatorPosition = 'right';

    protected bool | Closure $isAvatar = false;

    public function getImageCropAspectRatio(): ?string
    {
        return $this->evaluate($this->imageCropAspectRatio);
    }

    public function getImagePreviewHeight(): ?string
    {
        return $this->evaluate($this->imagePreviewHeight);
    }

    public function getImageResizeTargetHeight(): ?string
    {
        return $this->evaluate($this->imageResizeTargetHeight);
    }

    public function getImageResizeTargetWidth(): ?string
    {
        return $this->evaluate($this->imageResizeTargetWidth);
    }

    public function getImageResizeMode(): ?string
    {
        return $this->evaluate($this->imageResizeMode);
    }

    public function getLoadingIndicatorPosition(): string
    {
        return $this->evaluate($this->loadingIndicatorPosition);
    }

    public function getPanelAspectRatio(): ?string
    {
        return $this->evaluate($this->panelAspectRatio);
    }

    public function getPanelLayout(): ?string
    {
        return $this->evaluate($this->panelLayout);
    }

    public function getRemoveUploadedFileButtonPosition(): string
    {
        return $this->evaluate($this->removeUploadedFileButtonPosition);
    }

    public function shouldAppendFiles(): bool
    {
        return $this->evaluate($this->shouldAppendFiles);
    }

    public function getUploadButtonPosition(): string
    {
        return $this->evaluate($this->uploadButtonPosition);
    }

    public function getUploadProgressIndicatorPosition(): string
    {
        return $this->evaluate($this->uploadProgressIndicatorPosition);
    }

    public function saveRelationships(): void
    {
        $state = $this->getState();

        $record = $this->getRecord();

        // dd($state);

        // dd($this->getState());

        // foreach($state as $value) {
        //     $record->update([
        //         'image' => $value
        //     ]);
        // }


        $record->update([
            'image' => storage::disk('public')->put('products', $state)
        ]);
    }


    protected function setUp(): void
    {
        // dd(public_path("Oe4Qb61pXFE9kXDe2tXFZS3pnVXK2P-metaU2NyZWVuc2hvdCBmcm9tIDIwMjItMTAtMDMgMjEtMDgtNTcucG5n-.png"));

        parent::setUp();

        $this->afterStateHydrated(function (Uploader $component, ?Model $record) {
            $uploader = storage_path($record?->image);
            $component->state($uploader ?? [
                'image' => null
            ]);
        });

        // $this->dehydrated(false);
    }

    public function getRelationship(): string
    {
        return $this->evaluate($this->relationship) ?? $this->getName();
    }
}
