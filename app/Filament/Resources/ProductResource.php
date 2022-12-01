<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Forms\Components\Uploader;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Uploader::make('uploader')->label('Uploader')
                        ->view('forms.components.uploader'),
                        // ->disk('public')
                        // ->directory('products'),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    // Forms\Components\TextInput::make('description')
                    //     ->required()
                    //     ->maxLength(255),
                    // Forms\Components\TextInput::make('normal_prize')
                    //     ->required(),
                    // Forms\Components\TextInput::make('discount_prize')
                    //     ->required(),
                    // Forms\Components\Toggle::make('is_popular')
                    //     ->required(),
                    // Forms\Components\Toggle::make('is_active')
                    //     ->required(),
                    // Forms\Components\TextInput::make('serial_number')
                    //     ->required()
                    //     ->maxLength(255),
                    FileUpload::make('file')->label('File')->disk('local')->directory('tet')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('normal_prize'),
                Tables\Columns\TextColumn::make('discount_prize'),
                Tables\Columns\IconColumn::make('is_popular')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('serial_number'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
